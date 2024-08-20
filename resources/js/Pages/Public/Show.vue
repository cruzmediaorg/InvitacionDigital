<template>
    <div :style="globalStyles" :class="{'page-container': true}">
        <div :class="{'home-section': true}">
            <component
                v-if="homeBlock"
                :is="getComponent(getComponentName(homeBlock))"
                :theme="styles"
                :block="homeBlock"
            />
        </div>
        <div :class="{'scrollable-section': true}">
            <component
                v-for="block in otherBlocks"
                :key="block.id"
                :is="getComponent(getComponentName(block))"
                :theme="styles"
                :block="block"
            />
        </div>
    </div>
</template>

<script setup>
import { defineAsyncComponent, computed } from 'vue';

const props = defineProps(['page', 'styles', 'theme']);

const homeBlock = computed(() => {
    return props.page.blocks.find(block => block.type.name === 'Home');
});

const otherBlocks = computed(() => {
    return props.page.blocks
        .filter(block => block.type.name !== 'Home')
        .sort((a, b) => a.order - b.order);
});

const getComponentName = (block) => {
    return block.blocks_type_design?.component || block.type.page_component;
};

const getComponent = (componentName) => {
    // Adjust the import path to match the theme path stored in the database
    return defineAsyncComponent(() => import(`../../${props.theme}/Components/${componentName}.vue`));
};

const globalStyles = computed(() => ({
    '--h-text-color': props.styles.h_text_color,
    '--p-text-color': props.styles.p_text_color,
    '--h-font-family': `${props.styles.h_font_family}, sans-serif`,
    '--p-font-family': `${props.styles.p_font_family}, sans-serif`,
    '--h1-font-size': `${props.styles.h1_font_size}px`,
    '--h2-font-size': `${props.styles.h2_font_size}px`,
    '--h3-font-size': `${props.styles.h3_font_size}px`,
    '--p-font-size': `${props.styles.p_font_size}px`,
}));
</script>

<style lang="scss" scoped>
// ... (styles remain the same as in the original Show.vue)
</style>