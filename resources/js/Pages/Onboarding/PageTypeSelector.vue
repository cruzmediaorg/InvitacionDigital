<template>
   <div class="w-full px-4 min-h-[100dvh]">
       <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">¿Qué tipo de sitio deseas construir?</h2>
                <div class="space-y-4">
                    <div v-for="type in types" :key="type.id">
                        <GoldenButton @click="$emit('select', type)">
                            {{ type.name }}
                        </GoldenButton>
                    </div>
                </div>
   </div>

</template>

<script setup>
import GoldenButton from '@/Components/GoldenButton.vue';

defineProps({
    types: {
        type: Array,
        required: true,
    },
});

defineEmits(['select']);
</script>

<style lang="scss" scoped>

</style>