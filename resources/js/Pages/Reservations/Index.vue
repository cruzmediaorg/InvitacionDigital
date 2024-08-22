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

      <button @click="openModal" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
        Edit RSVP Questions
      </button>

      <div v-for="group in reservation.groups" :key="group.id" class="guest-group mb-8">
        <div class="group-header flex justify-between items-center bg-gray-100 p-4 rounded-t-lg">
          <span class="font-semibold">{{ group.name }}</span>
          <div class="flex items-center space-x-4">
            <span class="text-gray-600">{{ group.rsvp_code }}</span>
            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" 
                   :checked="isInvitationSent(group)" @change="toggleInvitation(group)" />
          </div>
        </div>

        <GuestGroupTable 
          :guests="group.guests"
          :rsvp-questions="reservation.rsvp_questions"
        />
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
import AuthLayout from "@/Layouts/AuthLayout.vue";
import EditRSVPQuestionsModal from "./Components/EditRSVPQuestionsModal.vue";
import GuestGroupTable from "./Components/GuestsGroupTable.vue";
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
const props = defineProps(['reservation']);

function isInvitationSent(group) {
  return group.guests.some(guest => guest.invitation_sent_at !== null);
}

function toggleInvitation(group) {
  // Implement invitation toggle logic
}

const isModalOpen = ref(false);

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

const updateRSVPQuestions = (updatedQuestions) => {
  // Here you would typically make an API call to update the questions
  //   console.log('Updated questions:', updatedQuestions);
  router.put('/reservations/' + props.reservation.id, {
    rsvp_questions: updatedQuestions
  });

  // After successful update:
  props.reservation.rsvp_questions = [...updatedQuestions];
  closeModal();
};
</script>

<style lang="scss" scoped>
.manage-guests {
  // Add styles for layout, buttons, tables, etc.
}
</style>