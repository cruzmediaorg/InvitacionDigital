<template>
  <button
    :type="type"
    @click="$emit('click')"
    class="w-full py-3 px-4 bg-white border border-golden text-golden hover:text-white hover:bg-golden transition duration-300"
  >
    <slot></slot>
  </button>
</template>

<script setup>
defineProps(['type']);
defineEmits(['click']);
</script>
