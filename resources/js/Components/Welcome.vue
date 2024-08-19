<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps(['pages']);


</script>

<template>
    <div>

        <h2 class="text-2xl font-bold mb-4">Pages:</h2>
        <ul>
            <li v-for="page in pages" :key="page.id">
                <Link class="text-blue-500 hover:underline  px-2" :href="page.url">{{ page.title }}</Link>
            </li>
        </ul>

    </div>
</template>
