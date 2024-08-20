<template>
    <div class="our-story-container">
        <h2 class="our-story-title">{{ block.fields[0].value }}</h2>
        <div class="our-story-content" v-html="block.fields[1].value"></div>
        <div v-if="storyImage" class="our-story-image">
            <img :src="storyImage" alt="Nuestra Historia">
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps(['block']);

const storyImage = computed(() => {
    return props.block.fields[2]?.value || null;
});
</script>

<style scoped>
</style>