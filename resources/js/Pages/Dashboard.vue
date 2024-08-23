<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps(['pages']);

const showProfileMenu = ref(false);

const toggleProfileMenu = () => {
    showProfileMenu.value = !showProfileMenu.value;
};
</script>

<template>
    <AuthLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-800 font-cormorant">Dashboard</h1>
                        <div class="relative">
                            <PrimaryButton @click="toggleProfileMenu">
                                My Profile
                            </PrimaryButton>
                            <div v-if="showProfileMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                <Link :href="route('profile.show')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Profile</Link>
                                <Link :href="route('profile.edit')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</Link>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <div v-for="page in pages" :key="page.id" class="bg-gray-50 p-6 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ page.title }}</h2>
                            <p class="text-gray-600 mb-4">{{ page.blocks.length }} blocks</p>
                            <div class="flex justify-between items-center">
                                <Link :href="route('pages.edit', page.slug)" class="text-golden hover:text-golden-dark transition duration-300">Edit Page</Link>
                                <Link :href="route('pages.show', page.slug)" class="text-golden hover:text-golden-dark transition duration-300"><i class="pi pi-eye"></i></Link>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <Link :href="route('pages.create')" class="bg-golden text-white p-4 rounded-lg text-center hover:bg-golden-dark transition duration-300">
                                Create New Page
                            </Link>
                            <SecondaryButton class="p-4 text-center">
                                Manage Blocks
                            </SecondaryButton>
                            <SecondaryButton class="p-4 text-center">
                                Analytics
                            </SecondaryButton>
                            <SecondaryButton class="p-4 text-center">
                                Settings
                            </SecondaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>