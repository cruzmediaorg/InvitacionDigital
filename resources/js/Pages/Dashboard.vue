<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

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
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-semibold text-gray-800">Dashboard</h1>
                        <div class="relative">
                            <button @click="toggleProfileMenu" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                                My Profile
                            </button>
                            <div v-if="showProfileMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                <Link :href="route('profile.show')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Profile</Link>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="page in pages" :key="page.id" class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ page.title }}</h2>
                            <p class="text-gray-600 mb-4">{{ page.blocks.length }} blocks</p>
                            <div class="flex justify-between items-center">
                                <Link :href="route('pages.edit', page.slug)" class="text-blue-500 hover:text-blue-700 transition duration-300">Edit Page</Link>
                                <Link :href="page.url" class="text-green-500 hover:text-green-700 transition duration-300">View Page</Link>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <Link :href="route('pages.create')" class="bg-indigo-500 text-white p-4 rounded-lg text-center hover:bg-indigo-600 transition duration-300">
                                Create New Page
                            </Link>
                            <button class="bg-purple-500 text-white p-4 rounded-lg text-center hover:bg-purple-600 transition duration-300">
                                Manage Blocks
                            </button>
                            <button class="bg-yellow-500 text-white p-4 rounded-lg text-center hover:bg-yellow-600 transition duration-300">
                                Analytics
                            </button>
                            <button class="bg-red-500 text-white p-4 rounded-lg text-center hover:bg-red-600 transition duration-300">
                                Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>