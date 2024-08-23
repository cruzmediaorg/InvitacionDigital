<template>
    <Teleport to="body">
      <div v-if="modelValue" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
          <!-- Background overlay -->
          <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" @click="$emit('update:modelValue', false)"></div>
  
          <!-- Modal panel -->
          <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
              <slot></slot>
            </div>
            <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
              <slot name="footer"></slot>
            </div>
          </div>
        </div>
      </div>
    </Teleport>
  </template>
  
  <script setup>
  import { watch } from 'vue';
  
  const props = defineProps({
    modelValue: {
      type: Boolean,
      required: true
    }
  });
  
  const emit = defineEmits(['update:modelValue']);
  
  watch(() => props.modelValue, (newValue) => {
    if (newValue) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
  });
  </script>