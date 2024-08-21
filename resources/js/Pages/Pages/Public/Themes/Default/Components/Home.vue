<template>
    <div class="home-container">
        <div class="hero-section" :style="heroSectionStyle">
            <div class="hero-content">
                <h1 class="hero-title">{{ getValueByKey('partner_1_name') }}</h1>
                <p class="hero-subtitle">{{ getValueByKey('and')  }}</p>
                <h1 class="hero-title">{{ getValueByKey('partner_2_name') }}</h1>
                <p v-if="getValueByKey('welcome_message')" class="hero-date">{{ getValueByKey('welcome_message') }}</p>
                <p class="hero-date">{{ getValueByKey('date') }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps(['block', 'theme']);

const heroImage = computed(() => {
    return getValueByKey('main_image') ?? '/assets/opal.webp';
});

const heroSectionStyle = computed(() => ({
    backgroundImage: `url(${heroImage.value})`,
    color: props.theme.h_text_color, // Updated to use the new theme property
}));

function getValueByKey(key) {
    return props.block.fields.find(field => field.key === key).value;
}
</script>

<style lang="scss" scoped>
.hero-section {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;

    &::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.1) 100%);
    }
}

.hero-content {
    position: relative;
    z-index: 1;
    text-align: center;
    padding: 2rem;
}
</style>