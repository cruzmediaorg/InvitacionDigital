<template>
  <div class="max-w-2xl mx-auto p-6">
    <h2 class="text-2xl font-semibold text-center mb-8">
      Antes de empezar, ¿podría la pareja presentarse?
    </h2>
    
    <div class="space-y-8">
      <div v-for="(partner, index) in partners" :key="index">
        <h3 class="text-xl font-medium mb-4">
          {{ index === 0 ? 'Pareja uno' : 'Pareja dos' }}
        </h3>
        
        <div class="space-y-4">
          <div>
            <label :for="`firstName${index}`" class="block text-sm font-medium text-gray-700 mb-1">
              Nombre
            </label>
            <BorderlessInput
              :id="`firstName${index}`"
              v-model="partner.firstName"
              :error="partner.firstNameError"
              v-focus="index === 0"
            />
            <p v-if="partner.firstNameError" class="mt-1 text-sm text-red-600">
              El nombre es obligatorio
            </p>
          </div>
          
          <div>
            <label :for="`lastName${index}`" class="block text-sm font-medium text-gray-700 mb-1">
              Apellido
            </label>
            <BorderlessInput
              :id="`lastName${index}`"
              v-model="partner.lastName"
            />
          </div>
        </div>
      </div>
    </div>
    
    <GoldenButton
      @click="validateAndProceed"
      class="w-full mt-8"
    >
      Siguiente
    </GoldenButton>
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick, watch } from "vue";
import BorderlessInput from '@/Components/BorderlessInput.vue';
import GoldenButton from '@/Components/GoldenButton.vue';

const props = defineProps(['formData']);
const emit = defineEmits(['update:formData', 'next']);

const partners = ref([
  { firstName: '', lastName: '', firstNameError: false },
  { firstName: '', lastName: '', firstNameError: false }
]);

// Inicializar los datos del formulario si existen
watch(() => props.formData, (newFormData) => {
  if (newFormData && newFormData.partners) {
    partners.value = newFormData.partners.map(partner => ({
      ...partner,
      firstNameError: false
    }));
  }
}, { immediate: true });

const validateAndProceed = () => {
  let isValid = true;
  partners.value.forEach(partner => {
    if (!partner.firstName.trim()) {
      partner.firstNameError = true;
      isValid = false;
    } else {
      partner.firstNameError = false;
    }
  });

  if (isValid) {
    // Emitir los datos actualizados al componente padre
    emit('update:formData', { partners: partners.value });
    emit('next');
  }
};

// Directiva personalizada para el enfoque automático
const vFocus = {
  mounted: (el) => el.focus()
}

onMounted(() => {
  // Asegurarse de que el componente esté completamente montado antes de enfocar
  nextTick(() => {
    const firstInput = document.getElementById('firstName0');
    if (firstInput) firstInput.focus();
  });
});
</script>