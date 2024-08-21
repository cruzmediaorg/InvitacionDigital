<template>
  <div class="page-preview">
    <iframe :src="previewUrl" class="preview-iframe"></iframe>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  page: Object,
  blocks: Array,
  styles: Object,
});

const previewUrl = computed(() => {
  const baseUrl = route('pages.show', props.page.slug);
  const queryParams = new URLSearchParams({
    preview: 'true',
    blocks: JSON.stringify(props.blocks),
    styles: JSON.stringify(props.styles),
  });
  return `${baseUrl}?${queryParams.toString()}`;
});
</script>

<style scoped>
.page-preview {
  width: 100%;
  height: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  overflow: hidden;
}

.preview-iframe {
  width: 100%;
  height: 100%;
  border: none;
}
</style>