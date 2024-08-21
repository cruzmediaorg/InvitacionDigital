<template>
    <div class="location-container">
        <h2 class="title">{{ block.fields[0].value }}</h2>
        <div class="location-details">
            <p><strong>Dirección:</strong> {{ block.fields[1].value }}</p>
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
    const rawUrl = props.block.fields[3]?.value;
    if (!rawUrl) return null;
    
    // Extract the place ID or coordinates from the Google Maps URL
    const placeId = rawUrl.match(/place\/([^\/]+)/)?.[1];
    const coords = rawUrl.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/);
    
    if (placeId) {
        return `https://www.google.com/maps/embed/v1/place?key=YOUR_API_KEY&q=place_id:${placeId}`;
    } else if (coords) {
        return `https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center=${coords[1]},${coords[2]}&zoom=15`;
    }
    
    return null;
});
</script>

<style scoped>

</style>