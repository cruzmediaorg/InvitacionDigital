<template>
  <SimpleModal :model-value="show" @update:model-value="closeModal">
    <div class="p-6">
      <h2 class="text-2xl font-bold text-gray-800 font-cormorant mb-4">
        {{ selectedGuest ? `Edit Attendance for ${selectedGuest.name}` : 'Update Attendance' }}
      </h2>
      
      <div v-if="!selectedGuest">
        <h3 class="text-lg font-medium text-gray-700 mb-4">Select your name to respond</h3>
        <div class="space-y-2">
          <button 
            v-for="guest in guests" 
            :key="guest.id"
            @click="selectGuest(guest)"
            class="w-full text-left flex justify-between items-center bg-white border border-gray-300 rounded-lg px-4 py-3 transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-golden focus:border-golden"
          >
            <span class="font-medium text-gray-700">{{ guest.name }}</span>
            <span class="text-sm text-golden">Respond now</span>
          </button>
        </div>
      </div>
      <form v-else @submit.prevent="submitAttendance" class="space-y-6">
        <div v-for="(question, index) in rsvpQuestions" :key="question.id" v-show="currentStep === index">
          <h3 class="text-lg font-medium text-gray-700 mb-2">
            {{ question.question }}
            <span v-if="!question.optional" class="text-red-500 ml-1">*</span>
          </h3>
          <div v-if="question.type === 'options'" class="space-y-2">
            <div v-for="option in question.options" :key="option" class="flex items-center">
              <input 
                :id="`radio-${question.id}-${option}`"
                :type="question.multiple ? 'checkbox' : 'radio'" 
                :name="`question-${question.id}`"
                :value="option" 
                v-model="answers[question.id].answer" 
                :required="!question.optional"
                class="hidden checked:bg-no-repeat checked:bg-center checked:border-golden checked:bg-golden-100"
              >
              <label :for="`radio-${question.id}-${option}`" class="flex items-start cursor-pointer text-gray-600 text-sm font-normal">
                <span class="border border-gray-300 rounded-full mr-2 w-4 h-4 mt-1"></span>
                <div class="block">
                  <h5 class="w-full text-sm font-normal text-gray-600">{{ option }}</h5>
                </div>
              </label>
            </div>
          </div>
          <div v-else-if="question.type === 'text'">
            <BorderlessInput 
              type="text" 
              v-model="answers[question.id].answer" 
              :required="!question.optional"
            />
          </div>
        </div>
        <div class="flex justify-between mt-6">
          <SecondaryButton 
            type="button" 
            @click="prevStep" 
            v-if="currentStep > 0"
          >
            Previous
          </SecondaryButton>
          <PrimaryButton 
            type="button" 
            @click="nextStep" 
            v-if="currentStep < rsvpQuestions.length - 1"
          >
            Next
          </PrimaryButton>
          <PrimaryButton 
            type="submit" 
            v-if="currentStep === rsvpQuestions.length - 1"
          >
            Submit
          </PrimaryButton>
        </div>
      </form>
    </div>
  </SimpleModal>
</template>

<script setup>
import { ref, watch } from 'vue';
import SimpleModal from "@/Components/SimpleModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BorderlessInput from "@/Components/BorderlessInput.vue";
const props = defineProps({
  show: Boolean,
  guest: Object,
  guests: Array,
  rsvpQuestions: Array
});

const emit = defineEmits(['update:show', 'update', 'select-guest']);

const localShow = ref(props.show);
const currentStep = ref(0);
const answers = ref({});
const selectedGuest = ref(props.guest);

watch(() => props.show, (newValue) => {
  localShow.value = newValue;
  if (newValue) {
    currentStep.value = 0;
    if (selectedGuest.value) {
      initializeAnswers();
    } else {
      answers.value = {};
    }
  }
});

watch(() => props.guest, (newValue) => {
  selectedGuest.value = newValue;
  if (newValue) {
    initializeAnswers();
  } else {
    answers.value = {};
  }
});

function initializeAnswers() {
  answers.value = {};
  if (selectedGuest.value && selectedGuest.value.rsvp_data) {
    try {
      const parsedData = JSON.parse(selectedGuest.value.rsvp_data);
      parsedData.forEach(item => {
        answers.value[item.question_id] = { question_id: item.question_id, answer: item.answer };
      });
    } catch (e) {
      console.error('Error parsing rsvp_data:', e);
    }
  }
  // Initialize unanswered questions
  props.rsvpQuestions.forEach(question => {
    if (!(question.id in answers.value)) {
      answers.value[question.id] = { 
        question_id: question.id, 
        answer: question.multiple ? [] : (question.default || '')
      };
    }
  });
}

function selectGuest(guest) {
  selectedGuest.value = guest;
  initializeAnswers();
  emit('select-guest', guest);
}

function nextStep() {
  if (currentStep.value < props.rsvpQuestions.length - 1) {
    currentStep.value++;
  }
}

function prevStep() {
  if (currentStep.value > 0) {
    currentStep.value--;
  }
}

function submitAttendance() {
  const rsvpData = Object.values(answers.value);
  const updatedGuest = {
    ...selectedGuest.value,
    rsvp_data: JSON.stringify(rsvpData)
  };
  emit('update', updatedGuest);
  closeModal(false);
}

function closeModal(value) {
  localShow.value = value;
  emit('update:show', value);
}
</script>

<style scoped>
input[type="radio"]:checked + label span {
  @apply bg-golden border-white shadow-sm relative;
}
input[type="radio"]:checked + label span::after {
  content: "\2713"; /* Unicode character for checkmark */
  @apply absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-xs font-bold;
}
</style>