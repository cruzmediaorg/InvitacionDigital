<template>
    <div class="schedule-container">
        <h2 class="schedule-title">{{ block.fields[0].value }}</h2>
        <div v-for="(event, index) in scheduleEvents" :key="index" class="event-item">
            <h2>{{ event.title }}</h2>
            <p>Fecha: {{ formatDate(event.date) }}</p>
            <p>Hora: {{ event.startTime }} - {{ event.endTime }}</p>
            <p>Ubicación: {{ event.location }}</p>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps(['block']);

const scheduleEvents = computed(() => {
    return JSON.parse(props.block.fields[1].value);
});

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('es-ES', options);
};
</script>

<style  scoped>

</style>