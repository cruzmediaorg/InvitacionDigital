<template>
  <div class="p-4">
    <div class="overflow-x-auto">
      <table class="w-full border-collapse">
        <thead>
          <tr class="bg-gray-100">
            <th class="p-2 text-left font-semibold">Guest</th>
            <th class="p-2 text-left font-semibold">Tags</th>
            <th v-for="question in rsvpQuestions" :key="question.question" 
                class="p-2 text-left font-semibold">
              {{ question.question }}
            </th>
            <th class="p-2 text-left font-semibold">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="guest in guests" :key="guest.id" class="border-t hover:bg-gray-50">
            <td class="p-2">{{ guest.name }}</td>
            <td class="p-2"><!-- Tags component --></td>
            <td v-for="question in rsvpQuestions" :key="question.question" class="p-2">
              {{ getGuestResponse(guest, question) }}
            </td>
            <td class="p-2">
              <button @click="openEditAttendanceModal(guest)" 
                      class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded text-sm transition-colors duration-150">
                Edit attendance
              </button>
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
  // Emit the updated guest to the parent component
  emit('update-guest', updatedGuest);
  closeEditAttendanceModal();
}

function selectGuest(guest) {
  selectedGuest.value = guest;
}

function getGuestResponse(guest, question) {
  if (!guest.rsvp_data) return '';
  
  // If rsvp_data is a string, try to parse it as JSON
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