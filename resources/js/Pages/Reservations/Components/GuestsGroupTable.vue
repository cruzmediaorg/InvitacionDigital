<template>
  <div class="p-4">
    <div class="overflow-x-auto">
      <table class="w-full border-collapse">
        <thead>
          <tr class="">
            <th class="p-3 text-left font-semibold text-gray-600">Guest</th>
            <th v-for="question in rsvpQuestions" :key="question.question" 
                class="p-3 text-left font-semibold text-gray-600">
              {{ question.question }}
            </th>
            <th class="p-3 text-left font-semibold text-gray-600">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="guest in guests" :key="guest.id" class="border-t hover:bg-gray-50 transition-colors duration-150">
            <td class="p-3">{{ guest.name }}</td>
            <td v-for="question in rsvpQuestions" :key="question.question" class="p-3">
              {{ getGuestResponse(guest, question) }}
            </td>
            <td class="p-3">
              <PrimaryButton @click="openEditAttendanceModal(guest)" class="text-sm">
                Edit attendance
              </PrimaryButton>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <EditAttendanceModal
      :show="isEditAttendanceModalOpen"
      :guest="selectedGuest"
      :guests="guests"
      :rsvp-questions="rsvpQuestions"
      @update:show="closeEditAttendanceModal"
      @update="updateGuestAttendance"
      @select-guest="selectGuest"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import EditAttendanceModal from './EditAttendanceModal.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
  guests: Array,
  rsvpQuestions: Array,
});

const emit = defineEmits(['update-guest']);

const isEditAttendanceModalOpen = ref(false);
const selectedGuest = ref(null);

function openEditAttendanceModal(guest) {
  selectedGuest.value = guest;
  isEditAttendanceModalOpen.value = true;
}

function closeEditAttendanceModal() {
  isEditAttendanceModalOpen.value = false;
  selectedGuest.value = null;
}

function updateGuestAttendance(updatedGuest) {
  emit('update-guest', updatedGuest);
  closeEditAttendanceModal();
}

function selectGuest(guest) {
  selectedGuest.value = guest;
}

function getGuestResponse(guest, question) {
  if (!guest.rsvp_data) return '';
  
  const rsvpData = typeof guest.rsvp_data === 'string' 
    ? JSON.parse(guest.rsvp_data) 
    : guest.rsvp_data;

  if (Array.isArray(rsvpData)) {
    const response = rsvpData.find(item => item.question_id === question.id);
    return response ? response.answer : '';
  } else if (typeof rsvpData === 'object') {
    return rsvpData[question.id] || '';
  }
  
  return '';
}
</script>