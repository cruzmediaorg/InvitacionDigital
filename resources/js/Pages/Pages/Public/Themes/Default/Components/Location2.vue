<template>
    <div class="location-container">
        <h2 class="title">{{ block.fields[0].value }}</h2>
        <div class="location-details">
            <p><strong>Locaaation:</strong> {{ block.fields[1].value }}</p>
            <p v-if="block.fields[2]?.value"><strong>Información adicional:</strong> {{ block.fields[2].value }}</p>
        </div>
        <div v-if="mapUrl" class="location-map">
            <iframe 
                :src="mapUrl" 
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps(['block']);

const mapUrl = computed(() => {
    return props.block.fields[3]?.value || null;
});
</script>

<style scoped>

</style>