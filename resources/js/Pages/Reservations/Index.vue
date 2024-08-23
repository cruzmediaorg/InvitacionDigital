<template>
  <AuthLayout title="Manage Guests">
    <div class="manage-guests p-6">
      <header class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manage Guests</h1>
        <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
          + Add Guests
        </button>
      </header>

      <div class="actions flex space-x-4 mb-6">
        <button class="border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 rounded">
          Filter Guests
        </button>
        <button class="border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 rounded">
          Assign Tags
        </button>
        <button class="border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 rounded">
          Manage Tags
        </button>
        <button class="border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 rounded">
          Export Guests
        </button>
      </div>

      <button @click="openModal" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mb-6">
        Edit RSVP Questions
      </button>

      <div class="space-y-4">
        <div class="border rounded-lg shadow-sm overflow-hidden">
          <div class="bg-gray-50 p-4">
            <div class="grid grid-cols-4 gap-4 font-semibold text-gray-700">
              <div>Group Name</div>
              <div>RSVP Code</div>
              <div class="text-center">Invitation Sent</div>
              <div></div>
            </div>
          </div>
          <div v-for="group in reservation.groups" :key="group.id">
            <div @click="toggleGroup(group.id)" 
                 class="grid grid-cols-4 gap-4 items-center p-4 cursor-pointer hover:bg-gray-100 transition-colors duration-150">
              <h3 class="text-lg font-semibold">{{ group.name }}</h3>
              <span class="text-gray-600">{{ group.rsvp_code }}</span>
              <div class="text-center">
                <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" 
                       :checked="isInvitationSent(group)" @change="toggleInvitation(group)" />
              </div>
              <div class="flex justify-end">
                <svg :class="{'transform rotate-180': openGroups[group.id]}" class="w-5 h-5 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
            
            <div v-show="openGroups[group.id]" class="border-t">
              <GuestsGroupTable 
                :guests="group.guests"
                :rsvp-questions="reservation.rsvp_questions"
                @update-guest="updateGuestAttendance"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <EditRSVPQuestionsModal 
      :show="isModalOpen" 
      :rsvp-questions="reservation.rsvp_questions"
      @close="closeModal"
      @update="updateRSVPQuestions"
    />
  </AuthLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthLayout from "@/Layouts/AuthLayout.vue";
import EditRSVPQuestionsModal from "./Components/EditRSVPQuestionsModal.vue";
import GuestsGroupTable from "./Components/GuestsGroupTable.vue";

const props = defineProps(['reservation']);
const isModalOpen = ref(false);
const openGroups = ref({});

function toggleGroup(groupId) {
  openGroups.value[groupId] = !openGroups.value[groupId];
}

function isInvitationSent(group) {
  return group.guests.some(guest => guest.invitation_sent_at !== null);
}

function toggleInvitation(group) {
  // Implement invitation toggle logic
  console.log('Toggle invitation for group:', group.id);
}

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

const updateRSVPQuestions = (updatedQuestions) => {
  router.put('/reservations/' + props.reservation.id, {
    rsvp_questions: updatedQuestions
  });

  props.reservation.rsvp_questions = [...updatedQuestions];
  closeModal();
};

const updateGuestAttendance = (updatedGuest) => {
  router.put(`/guests/${updatedGuest.id}`, {
    rsvp_data: updatedGuest.rsvp_data
  }, {
    preserveState: true,
    preserveScroll: true,
  });
};
</script>

<style lang="scss" scoped>
.manage-guests {
  // Add styles for layout, buttons, tables, etc.
}
</style>