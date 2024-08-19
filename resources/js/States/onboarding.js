import { defineStore } from 'pinia'

export const useOnboardingStore = defineStore('onboarding', {
  state: () => ({
    formData: {},
    currentType: null,
    currentStep: 0,
  }),

  actions: {
    setType(type) {
      this.currentType = type
      this.formData = {}
      this.currentStep = 0
    },

    updateFormData(step, data) {
      this.formData[step] = { ...this.formData[step], ...data }
    },

    nextStep() {
      this.currentStep++
    },

    prevStep() {
      if (this.currentStep > 0) {
        this.currentStep--
      }
    },

    resetForm() {
      this.formData = {}
      this.currentStep = 0
    },
  },

  getters: {
    getCurrentFormData: (state) => state.formData[state.currentStep] || {},
    isLastStep: (state) => {
      if (!state.currentType?.page_onboarding_forms) return true
      return state.currentStep === state.currentType.page_onboarding_forms.length - 1
    },
  },
})