<script setup>
import OnboardingLayout from "@/Layouts/OnboardingLayout.vue";
import PageTypeSelector from "./PageTypeSelector.vue";
import {  computed, defineAsyncComponent } from "vue";
import { useOnboardingStore } from '@/States/onboarding'
import { router } from '@inertiajs/vue3';

defineProps(['types'])

const onboardingStore = useOnboardingStore()

const currentForm = computed(() => {
    if (!onboardingStore.currentType?.page_onboarding_forms) return null;
    return onboardingStore.currentType.page_onboarding_forms[onboardingStore.currentStep];
});

const currentComponent = computed(() => {
    if (!currentForm.value) return null;
    return defineAsyncComponent(() => import(`./${currentForm.value.component}`));
});

const formattedFormData = computed(() => {
  return Object.values(onboardingStore.formData).reduce((acc, curr) => ({...acc, ...curr}), {});
});

async function submitForm() {
  router.post('/onboarding', {
    data: formattedFormData.value,
    type: onboardingStore.currentType.id,
  })
}

function nextForm() {
  if (!onboardingStore.isLastStep) {
    onboardingStore.nextStep()
  } else {
    submitForm()
  }
}

function prevForm() {
  onboardingStore.prevStep()
}

function selectType(type) {
  onboardingStore.setType(type)
}
</script>

<template>
  <OnboardingLayout>

    <div class="max-w-2xl mx-auto">
      <PageTypeSelector
        v-if="!onboardingStore.currentType"
        :types="types"
        @select="selectType"
      />
      <template v-if="onboardingStore.currentType && currentComponent">
        <component
          :is="currentComponent"
          @next="nextForm"
          @prev="prevForm"
          :formData="onboardingStore.getCurrentFormData"
          @update:formData="(data) => onboardingStore.updateFormData(onboardingStore.currentStep, data)"
        />
      </template>
    </div>
  </OnboardingLayout>
</template>
