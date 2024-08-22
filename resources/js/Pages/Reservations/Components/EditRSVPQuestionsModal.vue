<template>
  <Modal :show="show" @close="$emit('close')">
    <div class="p-4">
      <h2 class="text-lg font-medium mb-4">Edit RSVP Questions</h2>
      <form @submit.prevent="updateRSVPQuestions">
        <div class="border py-5 px-6 rounded-md">
          <div v-for="(question, index) in editableQuestions" :key="index" class="pt-4 rounded relative mb-4 border-b pb-4">
            <div class="mb-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">Question #{{ index + 1 }}:</label>
              <BorderlessInput
                v-model="question.question"
                placeholder="Enter question here"
                class="w-full"
              />
            </div>
            <div class="mb-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">Type:</label>
              <select v-model="question.type" class="w-full border-0 focus:ring-0">
                <option value="options">Multiple Choice</option>
                <option value="text">Text</option>
              </select>
            </div>
            <div v-if="question.type === 'options'" class="mb-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">Options:</label>
              <div v-for="(option, optionIndex) in question.options" :key="optionIndex" class="flex items-center mb-2">
                <BorderlessInput
                  v-model="question.options[optionIndex]"
                  placeholder="Enter option here"
                  class="w-full mr-2"
                />
                <button @click="removeOption(question, optionIndex)" type="button" class="text-red-500 text-sm">
                  <i class="pi pi-trash"></i>
                </button>
              </div>
              <div class="flex justify-center py-4">
              <button @click="addOption(question)" type="button" class="text-gray-800 text-sm">
                <i class="pi pi-plus"></i> Add Option
              </button>
            </div>
            </div>
            <label class="flex items-center text-sm font-medium text-gray-700">
              <input type="checkbox" v-model="question.optional" class="mr-2" />
              Optional
            </label>
            <button @click="removeQuestion(index)" type="button" class="text-red-500 text-sm absolute right-4 top-4">
              <i class="pi pi-trash"></i>
            </button>
          </div>
          <div class="flex justify-center">
            <button type="button" @click="addQuestion" class="mt-4 border-gray-800 px-4 py-3">
              <i class="pi pi-plus"></i> New Question
            </button>
          </div>
        </div>
        <div class="flex justify-end mt-4">
          <GoldenButton>Save Changes</GoldenButton>
        </div>
      </form>
    </div>
  </Modal>
</template>

<script setup>
import { ref } from 'vue';
import Modal from "@/Components/Modal.vue";
import GoldenButton from "@/Components/GoldenButton.vue";
import BorderlessInput from "@/Components/BorderlessInput.vue";

const props = defineProps(['show', 'rsvpQuestions']);
const emit = defineEmits(['close', 'update']);

const editableQuestions = ref([...props.rsvpQuestions]);

const addQuestion = () => {
  editableQuestions.value.push({
    // id: // get the next id
    id: getNextId(),
    type: 'text',
    question: '',
    optional: false,
    options: []
  });
};

const getNextId = () => {
  let highestId = 0;
  editableQuestions.value.forEach(question => {
    if (question.id > highestId) {
      highestId = question.id;
    }
  });
  return highestId + 1;
};

const removeQuestion = (index) => {
  editableQuestions.value.splice(index, 1);
};

const addOption = (question) => {
  question.options.push('');
};

const removeOption = (question, index) => {
  question.options.splice(index, 1);
};

const updateRSVPQuestions = () => {
  emit('update', editableQuestions.value);
};
</script>