<template>
    <div v-if="!page.is_published && !isMobileView" class="fixed top-0 bg-green-800 text-white font-bold uppercase flex left-0 z-10 w-full justify-center py-2 border-b border-gray-200 items-center min-w-[100vw]">
        <p>
            <i class="pi pi-lock"></i>
            This page is not public accessible yet.
        </p>
    </div>

    <div class="page-container" :class="{ 'mobile-view': isMobileView }" ref="pageContainer">
        <div class="home-section">
            <component
                v-if="homeBlock"
                :is="getComponent(getComponentName(homeBlock))"
                :theme="homeTheme"
                :block="homeBlock"
            />
        </div>
        <div class="scrollable-section">
            <component
                :id="generateComponentId(block.type.name)"
                v-for="block in otherBlocks"
                v-show="block.is_visible"
                :key="block.id"
                :is="getComponent(getComponentName(block))"
                :block="block"
            />
        </div>
    </div>
</template>

<script setup>
import { defineAsyncComponent, computed, onMounted, watch, ref } from 'vue';

const props = defineProps({
    page: Object,
    styles: Object,
    isMobileView: {
        type: Boolean,
        default: false
    }
});

const homeBlock = computed(() => {
    return props.page.blocks?.find(block => block.type.name === 'Home');
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
    return defineAsyncComponent(() => import(`./Themes/${props.page.theme.name}/Components/${componentName}`));
};

const homeTheme = computed(() => ({
    h_text_color: props.styles.home_h_text_color,
    p_text_color: props.styles.home_p_text_color,
    h_font_family: props.styles.home_h_font_family,
    p_font_family: props.styles.home_p_font_family,
    h1_font_size: props.styles.home_h1_font_size,
    h2_font_size: props.styles.home_h2_font_size,
    h3_font_size: props.styles.home_h3_font_size,
    p_font_size: props.styles.home_p_font_size,
}));

const bodyTheme = computed(() => ({
    h_text_color: props.styles.body_h_text_color,
    p_text_color: props.styles.body_p_text_color,
    h_font_family: props.styles.body_h_font_family,
    p_font_family: props.styles.body_p_font_family,
    h1_font_size: props.styles.body_h1_font_size,
    h2_font_size: props.styles.body_h2_font_size,
    h3_font_size: props.styles.body_h3_font_size,
    p_font_size: props.styles.body_p_font_size,
}));

const generateComponentId = (componentName) => {
    // Remove spaces and special characters
    return componentName.replace(/[^a-zA-Z0-9]/g, '').toLowerCase();
};

const pageContainer = ref(null);

const updateStyles = () => {
  if (pageContainer.value) {
    const style = pageContainer.value.style;
    
    // Home styles
    style.setProperty('--home-h-text-color', props.styles.home_h_text_color);
    style.setProperty('--home-p-text-color', props.styles.home_p_text_color);
    style.setProperty('--home-h-font-family', `${props.styles.home_h_font_family}, sans-serif`);
    style.setProperty('--home-p-font-family', `${props.styles.home_p_font_family}, sans-serif`);
    style.setProperty('--home-h1-font-size', `${props.styles.home_h1_font_size}px`);
    style.setProperty('--home-h2-font-size', `${props.styles.home_h2_font_size}px`);
    style.setProperty('--home-h3-font-size', `${props.styles.home_h3_font_size}px`);
    style.setProperty('--home-p-font-size', `${props.styles.home_p_font_size}px`);
    
    // Body styles
    style.setProperty('--body-h-text-color', props.styles.body_h_text_color);
    style.setProperty('--body-p-text-color', props.styles.body_p_text_color);
    style.setProperty('--body-h-font-family', `${props.styles.body_h_font_family}, sans-serif`);
    style.setProperty('--body-p-font-family', `${props.styles.body_p_font_family}, sans-serif`);
    style.setProperty('--body-h1-font-size', `${props.styles.body_h1_font_size}px`);
    style.setProperty('--body-h2-font-size', `${props.styles.body_h2_font_size}px`);
    style.setProperty('--body-h3-font-size', `${props.styles.body_h3_font_size}px`);
    style.setProperty('--body-p-font-size', `${props.styles.body_p_font_size}px`);
  }
};

onMounted(updateStyles);

watch(() => props.styles, updateStyles, { deep: true });
</script>

<style lang="scss" scoped>
.page-container {
    @media (min-width: 768px) {
        display: flex;
        height: 100vh;
        overflow: hidden;
    }

    &.mobile-view {
        display: flex;
        flex-direction: column;
        height: auto;
        overflow: visible;
    }
}

.home-section {
    @media (min-width: 768px) {
        flex: 0 0 50%;
        height: 100vh;
        overflow: hidden;
    }

    .mobile-view & {
        height: auto;
        overflow: visible;
    }

    ::v-deep h1, ::v-deep h2, ::v-deep h3, ::v-deep h4, ::v-deep h5, ::v-deep h6 {
        color: var(--home-h-text-color);
        font-family: var(--home-h-font-family);
    }

    ::v-deep h1 { font-size: var(--home-h1-font-size); }
    ::v-deep h2 { font-size: var(--home-h2-font-size); }
    ::v-deep h3 { font-size: var(--home-h3-font-size); }

    ::v-deep p, ::v-deep div {
        color: var(--home-p-text-color);
        font-family: var(--home-p-font-family);
        font-size: var(--home-p-font-size);
    }
}

.scrollable-section {
    @media (min-width: 768px) {
        flex: 0 0 50%;
        height: 100vh;
        overflow-y: auto;
        padding: 2rem;
    }

    .mobile-view & {
        height: auto;
        overflow: visible;
        padding: 1rem;
    }

    :deep(h1), :deep(h2), :deep(h3), :deep(h4), :deep(h5), :deep(h6) {
        color: var(--body-h-text-color);
        font-family: var(--body-h-font-family);
    }

    :deep(h1) { font-size: var(--body-h1-font-size); }
    :deep(h2) { font-size: var(--body-h2-font-size); }
    :deep(h3) { font-size: var(--body-h3-font-size); }

    :deep(p), :deep(div) {
        color: var(--body-p-text-color);
        font-family: var(--body-p-font-family);
        font-size: var(--body-p-font-size);
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