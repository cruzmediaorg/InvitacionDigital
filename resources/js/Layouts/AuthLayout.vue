<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import MenuLink from '@/Components/MenuLink.vue';
import { useToast } from '@/Composables/useToast';
import { computed, ref } from "vue";

defineProps({
    title: String,
});

useToast();

const page = usePage();
const isSidebarOpen = ref(false);

const sortedMenu = computed(() => {
    const menu = page.props.menu;
    if (typeof menu === 'object' && menu !== null) {
        return Object.values(menu).sort((a, b) => a.order - b.order);
    }
    return [];
});

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};
</script>

<template>
    <div class="flex h-screen bg-gray-100">
        <Head :title="title" />
        
        <aside class="hidden md:flex w-60 bg-[#f3f7f8] shadow-md flex-col border-r">
            <div class="py-4 flex items-center justify-center w-full">
                <ApplicationLogo class="h-10" />
            </div>
            <nav class="flex flex-col">
                <MenuLink class="border-y" href="/" :active="$page.url === '/'" text="Dashboard" />
                <p class="ml-4 mt-4 text-xs font-semibold text-gray-600 uppercase tracking-wide">WEBSITE</p>
                <MenuLink :href="route('pages.edit', page.props.defaultPage.slug)" :active="$page.url.startsWith('/pages')" text="Pages" :isParent="true" :parentIsOpen="true">
                    <template #submenu>
                        <MenuLink v-for="item in sortedMenu" :key="item.id" :active="item.url.includes($page.url)" :href="item.url" :text="item.name" />
                    </template>
                </MenuLink>
            </nav>
        </aside>

        <!-- Mobile header -->
        <div class="md:hidden fixed top-0 left-0 right-0 bg-white z-30 border-b">
            <div class="flex items-center justify-between px-4 py-2">
                <ApplicationLogo class="h-8" />
                <button @click="toggleSidebar" class="p-2 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile sidebar -->
        <div class="md:hidden">
            <!-- Mobile sidebar content -->
            <div :class="{'translate-x-0': isSidebarOpen, '-translate-x-full': !isSidebarOpen}" class="fixed inset-y-0 left-0 w-60 bg-[#f3f7f8] shadow-md flex flex-col border-r transform transition-transform duration-300 ease-in-out z-40 pt-14">
                <nav class="flex flex-col">
                    <MenuLink class="border-y" href="/" :active="$page.url === '/'" text="Dashboard" />
                    <p class="ml-4 mt-4 text-xs font-semibold text-gray-600 uppercase tracking-wide">WEBSITE</p>
                    <MenuLink :href="route('pages.edit', page.props.defaultPage.slug)" :active="$page.url.startsWith('/pages')" text="Pages" :isParent="true" :parentIsOpen="true">
                        <template #submenu>
                            <MenuLink v-for="item in sortedMenu" :key="item.id" :active="item.url.includes($page.url)" :href="item.url" :text="item.name" />
                        </template>
                    </MenuLink>
                </nav>
            </div>

            <!-- Overlay -->
            <div v-if="isSidebarOpen" @click="toggleSidebar" class="fixed inset-0 bg-black bg-opacity-50 z-30"></div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden ">
            <!-- Desktop header -->
            <header class="hidden md:block bg-white border-b">
                <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ title }}
                    </h2>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-white md:pt-6 pt-14">
                <div class="container mx-auto px-6 py-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>