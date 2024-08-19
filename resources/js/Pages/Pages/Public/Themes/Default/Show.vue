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

const props = defineProps(['page', 'styles']);

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
    return defineAsyncComponent(() => import(`./components/${componentName}`));
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
::v-deep h1, ::v-deep h2, ::v-deep h3, ::v-deep h4, ::v-deep h5, ::v-deep h6 {
    color: var(--h-text-color);
    font-family: var(--h-font-family);
}

::v-deep h1 { font-size: var(--h1-font-size); }
::v-deep h2 { font-size: var(--h2-font-size); }
::v-deep h3 { font-size: var(--h3-font-size); }

::v-deep p, ::v-deep div {
    color: var(--p-text-color);
    font-family: var(--p-font-family);
    font-size: var(--p-font-size);
}

.page-container {
    @media (min-width: 768px) {
        display: flex;
        height: 100vh;
        overflow: hidden;
    }
}

.home-section {
    @media (min-width: 768px) {
        flex: 0 0 50%;
        height: 100vh;
        overflow: hidden;
    }
}

.scrollable-section {
    @media (min-width: 768px) {
        flex: 0 0 50%;
        height: 100vh;
        overflow-y: auto;
        padding: 2rem;
    }
}

@media (max-width: 767px) {
    .home-section,
    .scrollable-section {
        width: 100%;
    }
}

/* ----------------- */
/* Home component */
::v-deep .home-container {
    width: 100%;
    height: 100vh;
}

::v-deep .hero-section {
    height: 100%;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

::v-deep .hero-content {
    padding: 2rem;
}

::v-deep .hero-title {
    font-size: 4rem;
    margin-bottom: 1rem;
    font-weight: normal;
}

::v-deep .hero-subtitle {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

::v-deep .hero-date {
    font-size: 1.5rem;
    font-weight: normal;
}

/* ----------------- */
/* Location component */

::v-deep .location-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

::v-deep .title {
    margin-bottom: 20px;
    text-align: center;
}


::v-deep .location-details {
    margin-bottom: 20px;
    line-height: 1.6;

    ::v-deep p {
        margin-bottom: 10px;
    }
}


::v-deep .location-map {
    width: 100%;
    height: 450px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* ----------------- */
/* Our Story component */

::v-deep .our-story-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

::v-deep .our-story-title {
    margin-bottom: 20px;
    text-align: center;
}


::v-deep .our-story-content {
    line-height: 1.6;
    margin-bottom: 20px;

   p {
        margin-bottom: 15px;
    }
}

::v-deep .our-story-image {
    text-align: center;

    img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
}

/* ----------------- */
/* Q&A component */

::v-deep .qna-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

::v-deep .qna-title {
    margin-bottom: 20px;
    text-align: center;
}

::v-deep .qna-item {
    margin-bottom: 15px;

    details {
        background-color: #f5f5f5;
        border-radius: 8px;
        padding: 10px;

         summary {
            font-weight: bold;
            cursor: pointer;
            padding: 5px 0;
        }


         p {
            margin-top: 10px;
            padding-left: 20px;
        }
    }
}

/* ----------------- */
/* Schedule component */
::v-deep .schedule-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

::v-deep .schedule-title {
    margin-bottom: 20px;
    text-align: center;
}

::v-deep .event-item {
    background-color: #f5f5f5;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;

    ::v-deep .private-event {
        font-style: italic;
        color: #888;
    }
}
</style>