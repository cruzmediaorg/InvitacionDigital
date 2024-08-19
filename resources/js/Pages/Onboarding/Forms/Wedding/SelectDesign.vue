<template>
  <div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center mb-2">Selecciona tu diseño</h1>
    <p class="text-center text-gray-600 mb-8">¡Puedes cambiar el diseño en cualquier momento!</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div 
        v-for="design in designs" 
        :key="design.name" 
        @click="selectDesign(design)"
        class="border rounded-lg overflow-hidden cursor-pointer transition-all duration-300 hover:shadow-lg relative group"
        :class="{ 'ring-2 ring-golden': selectedDesign?.name === design.name }"
      >
        <img :src="design.image" :alt="design.name" class="w-full h-64 object-cover">
        <div class="p-4">
          <h3 class="font-bold text-lg mb-2">{{ design.name }}</h3>
          <div class="flex space-x-2">
            <span v-for="color in design.colors" :key="color" class="w-6 h-6 rounded-full" :style="{ backgroundColor: color }"></span>
          </div>
        </div>
        <div class="absolute inset-0 bg-golden bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
      </div>
    </div>

    <div class="mt-8 flex justify-between">
      <GoldenButton @click="$emit('prev')" type="button">
        Anterior
      </GoldenButton>
      <GoldenButton @click="validateAndProceed" type="button">
        Siguiente
      </GoldenButton>
    </div>
    <p v-if="errorMessage" class="text-red-500 mt-2 text-center">{{ errorMessage }}</p>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import GoldenButton from '@/Components/GoldenButton.vue';

const props = defineProps(['formData']);
const emit = defineEmits(['update:formData', 'next', 'prev']);

const designs = ref([
  { id: 1, name: 'Create Your Own', image: 'https://www.fixdate.io/public/images/modelo_01_es.webp', colors: ['#f3e8d2', '#e6ccb2', '#ddb892', '#b08968'] },
  { id: 2, name: 'Classic', image: 'https://www.fixdate.io/public/images/modelo_36_es.webp', colors: ['#ffffff', '#000000', '#ff0000', '#800000'] },
  { id: 3, name: 'Opal', image: 'https://www.fixdate.io/public/images/modelo_21_es.webp', colors: ['#b0e0e6'] },
]);

const selectedDesign = ref(null);
const errorMessage = ref('');

// Inicializar los datos del formulario si existen
watch(() => props.formData, (newFormData) => {
  if (newFormData && newFormData.selectedDesign) {
    selectedDesign.value = designs.value.find(design => design.name === newFormData.selectedDesign.name);
  }
}, { immediate: true });

const selectDesign = (design) => {
  selectedDesign.value = design.id,
  errorMessage.value = '';
}

const validateAndProceed = () => {
  if (selectedDesign.value) {
    emit('update:formData', { selectedDesign: selectedDesign.value });
    emit('next');
  } else {
    errorMessage.value = 'Por favor, selecciona un diseño antes de continuar.';
  }
}
</script>