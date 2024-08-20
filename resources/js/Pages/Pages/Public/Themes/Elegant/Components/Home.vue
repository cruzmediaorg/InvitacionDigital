<template>
  <div class="elegant-home-container">
    <div class="elegant-hero-section" :style="{ backgroundImage: `url(${backgroundImage})` }">
      <div class="elegant-hero-content">
        <h1 class="elegant-hero-title">{{ block.fields[0].value }}</h1>
        <h2 class="elegant-hero-subtitle">{{ block.fields[1].value }}</h2>
        <p class="elegant-hero-date">{{ block.fields[2].value }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps(['block']);

const backgroundImage = computed(() => {
    return props.block.fields[3]?.value || '';
});
</script>

<style scoped>
.elegant-home-container {
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.elegant-hero-section {
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  justify-content: center;
}

.elegant-hero-content {
  text-align: center;
  color: white;
  background-color: rgba(0, 0, 0, 0.5);
  padding: 2rem;
  border-radius: 10px;
}

.elegant-hero-title {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.elegant-hero-subtitle {
  font-size: 2rem;
  margin-bottom: 1rem;
}

.elegant-hero-date {
  font-size: 1.5rem;
}
</style>