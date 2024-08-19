<template>
    <input
      :id="id"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      type="text"
      class="w-full px-3 py-2 border-0 border-b-2 border-grey-dark focus:outline-none focus:border-golden hover:border-golden focus:ring-0"
      :class="{ 'border-red-500': error, 'border-gray-300': !error }"
    >
  </template>

  <script setup>
  defineProps({
    id: String,
    modelValue: String,
    error: Boolean
  });

  defineEmits(['update:modelValue']);
  </script>
