<template>
  <div class="max-w-2xl mx-auto p-6">
    <h2 class="text-2xl font-semibold text-center mb-8">
      ¿Cuál es la fecha de tu boda?
    </h2>

    <div class="mb-6">
      <label for="weddingDate" class="block text-sm font-medium text-gray-700 mb-2">
        Fecha de la boda
      </label>
      <input
        type="date"
        id="weddingDate"
        v-model="localWeddingDate"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden focus:ring focus:ring-golden/20 focus:ring-opacity-50"
        placeholder="dd/mm/yyyy"
        :disabled="localNotDecidedYet"
      >
    </div>

    <div class="mb-6">
      <label class="inline-flex items-center">
        <input
          type="checkbox"
          v-model="localNotDecidedYet"
          @change="handleNotDecidedYetChange"
          class="rounded border-gray-300 text-golden shadow-sm focus:border-indigo-300 focus:ring focus:ring-golden focus:ring-opacity-50"
        >
        <span class="ml-2">Aún no decidido</span>
      </label>
    </div>

    <div class="mt-8">
      <GoldenButton
        type="button"
        @click="validateAndProceed"
      >
        Siguiente
      </GoldenButton>
    </div>
    <p v-if="errorMessage" class="text-red-500 mt-2 text-center">{{ errorMessage }}</p>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import GoldenButton from '@/Components/GoldenButton.vue';

const props = defineProps(['formData']);
const emit = defineEmits(['update:formData', 'next']);

const localWeddingDate = ref('');
const localNotDecidedYet = ref(false);
const errorMessage = ref('');

// Inicializar los datos del formulario si existen
watch(() => props.formData, (newFormData) => {
  if (newFormData) {
    localWeddingDate.value = newFormData.weddingDate || '';
    localNotDecidedYet.value = newFormData.notDecidedYet || false;
  }
}, { immediate: true });

const isFormValid = computed(() => {
  return localNotDecidedYet.value || (localWeddingDate.value && isValidDate(localWeddingDate.value));
});

const handleNotDecidedYetChange = () => {
  if (localNotDecidedYet.value) {
    localWeddingDate.value = '';
  }
  errorMessage.value = '';
}

const isValidDate = (date) => {
  const selectedDate = new Date(date);
  const today = new Date();
  return selectedDate > today;
}

const validateAndProceed = () => {
  if (localNotDecidedYet.value) {
    updateFormDataAndProceed();
  } else if (localWeddingDate.value) {
    if (isValidDate(localWeddingDate.value)) {
      updateFormDataAndProceed();
    } else {
      errorMessage.value = 'La fecha de la boda debe ser en el futuro.';
    }
  } else {
    errorMessage.value = 'Por favor, selecciona una fecha o marca "Aún no decidido".';
  }
}

const updateFormDataAndProceed = () => {
  emit('update:formData', {
    weddingDate: localWeddingDate.value,
    notDecidedYet: localNotDecidedYet.value
  });
  emit('next');
}
</script>
