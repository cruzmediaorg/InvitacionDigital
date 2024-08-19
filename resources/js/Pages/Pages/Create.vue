<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
defineProps(['types'])
</script>

<template>
    <AppLayout>
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold text-gray-800">Create Page</h1>

            {{ types}}
        </div>
    </AppLayout>
</template>

<style scoped lang="scss">

</style>
