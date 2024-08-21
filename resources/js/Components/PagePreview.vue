<template>
  <div class="page-preview">
    <div class="preview-controls">
      <button @click="setView('mobile')" :class="{ active: currentView === 'mobile' }">Mobile</button>
      <button @click="setView('desktop')">Full screen</button>
      <button @click="togglePreview">{{ isPreviewVisible ? 'Hide' : 'Show' }}</button>
    </div>
    <div v-if="isPreviewVisible && currentView === 'mobile'" class="preview-container mobile">
      <Show :page="pageWithBlocks" :styles="styles" :isMobileView="true" />
    </div>
    <transition name="fade">
      <div v-if="currentView === 'desktop'" class="fullscreen-modal">
        <transition name="slide-fade">
          <div v-if="currentView === 'desktop'" class="fullscreen-content">
            <button @click="setView('mobile')" class="close-fullscreen">&times;</button>
            <Show :page="pageWithBlocks" :styles="styles" :isMobileView="false" />
          </div>
        </transition>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import Show from '@/Pages/Pages/Public/Show.vue';

const props = defineProps({
  page: Object,
  blocks: Array,
  styles: Object,
});

const pageWithBlocks = computed(() => ({
  ...props.page,
  blocks: props.blocks,
}));

const currentView = ref('mobile');
const isPreviewVisible = ref(true);

const setView = (view) => {
  currentView.value = view;
  if (view === 'desktop') {
    isPreviewVisible.value = true;
  }
};

const togglePreview = () => {
  isPreviewVisible.value = !isPreviewVisible.value;
};
</script>

<style scoped>
.page-preview {
  width: 100%;
}

.preview-controls {
  display: flex;
  justify-content: center;
  margin-bottom: 1rem;
}

.preview-controls button {
  margin: 0 0.5rem;
  padding: 0.5rem 1rem;
  border: 1px solid #ccc;
  background-color: #fff;
  cursor: pointer;
}

.preview-controls button.active {
  background-color: #eee;
}

.preview-container {
  border: 1px solid #ccc;
  border-radius: 4px;
  overflow: hidden;
}

.preview-container.mobile {
  width: 375px;
  height: 667px;
  margin: 0 auto;
  overflow: auto;
  display: flex;
  flex-direction: column;
}

.fullscreen-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.fullscreen-content {
  width: 100%;
  height: 100%;
  background-color: white;
  position: relative;
  overflow: auto;
}

.close-fullscreen {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 24px;
  background: none;
  border: none;
  cursor: pointer;
  z-index: 1001;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateY(10px);
  opacity: 0;
}
</style>