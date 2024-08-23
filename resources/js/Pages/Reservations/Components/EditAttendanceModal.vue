<template>
  <SimpleModal :model-value="show" @update:model-value="closeModal">
    <div class="p-4">
      <h2 class="text-lg font-medium mb-4">
        {{ selectedGuest ? `Edit Attendance for ${selectedGuest.name}` : 'Update Attendance' }}
      </h2>
      
      <div v-if="!selectedGuest">
        <h3 class="text-md font-medium mb-2">Select your name to respond</h3>
        <div v-for="guest in guests" :key="guest.id" class="mb-2">
          <button 
            @click="selectGuest(guest)"
            class="bg-orange-500 hover:bg-brown-600 text-white font-bold py-2 px-4 rounded w-full text-left flex justify-between items-center"
          >
            <span>{{ guest.name }}</span>
            <span>Respond now</span>
          </button>
        </div>
      </div>
      <form v-else @submit.prevent="submitAttendance">
        <div v-for="(question, index) in rsvpQuestions" :key="question.id" v-show="currentStep === index">
          <h3 class="text-md font-medium mb-2">
            {{ question.question }}
            <span v-if="!question.optional" class="text-red-500 ml-1">*</span>
          </h3>
          <div v-if="question.type === 'options'">
            <div v-for="option in question.options" :key="option" class="mb-2">
              <label class="inline-flex items-center">
                <input 
                  :type="question.multiple ? 'checkbox' : 'radio'" 
                  :value="option" 
                  v-model="answers[question.id].answer" 
                  class="form-radio"
                  :required="!question.optional"
                >
                <span class="ml-2">{{ option }}</span>
              </label>
            </div>
          </div>
          <div v-else-if="question.type === 'text'">
            <input 
              type="text" 
              v-model="answers[question.id].answer" 
              class="form-input w-full"
              :required="!question.optional"
            >
          </div>
        </div>
        <div class="flex justify-between mt-4">
          <button type="button" @click="prevStep" v-if="currentStep > 0" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
            Previous
          </button>
          <button type="button" @click="nextStep" v-if="currentStep < rsvpQuestions.length - 1" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Next
          </button>
          <button type="submit" v-if="currentStep === rsvpQuestions.length - 1" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
            Submit
          </button>
        </div>
      </form>
    </div>
  </SimpleModal>
</template>

<script setup>
import { ref, watch } from 'vue';
import SimpleModal from "@/Components/SimpleModal.vue";

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