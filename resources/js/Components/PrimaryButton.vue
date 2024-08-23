<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-golden border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-golden/90 focus:bg-golden/80 active:bg-golden/70 focus:outline-none focus:ring-2 focus:ring-golden focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
