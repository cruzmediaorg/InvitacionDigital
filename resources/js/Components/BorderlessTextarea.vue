<template>
    <textarea
      :id="id"
      :value="modelValue"
      maxlength="255"
      @input="$emit('update:modelValue', $event.target.value)"
      type="text"
      class="w-full px-3 py-2 border-0 border-b-2 border-grey-dark focus:outline-none focus:border-golden hover:border-golden focus:ring-0"
      :class="{ 'border-red-500': error, 'border-gray-300': !error }"
    ></textarea>
    <p class="text-sm text-gray-500">{{ remainingChars }} caracteres restantes</p>
  </template>

  <script setup>
  import { computed } from 'vue';
  const props = defineProps({
    id: String,
    modelValue: String,
    error: Boolean
  });

  const maxLength = 255;
  const remainingChars = computed(() => maxLength - props.modelValue?.length);

  defineEmits(['update:modelValue']);
  </script>
