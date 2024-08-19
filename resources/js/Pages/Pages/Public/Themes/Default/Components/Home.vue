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
    return '/assets/opal.webp';
});

const heroSectionStyle = computed(() => ({
    backgroundImage: `url(${heroImage.value})`,
    color: props.theme.text_color,
}));

function getValueByKey(key) {
    return props.block.fields.find(field => field.key === key).value;
}
</script>

<style lang="scss" scoped>

</style>