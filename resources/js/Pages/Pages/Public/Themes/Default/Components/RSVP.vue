<template>
   {{ $page.props.guests }}
</template>

<script setup>
import { onMounted } from 'vue'
import { usePage, router } from '@inertiajs/vue3';

const page = usePage();

onMounted(() => {

})
</script>