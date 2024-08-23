<template>
  <AuthLayout title="Manage Guests">
    <div class="p-4 ">
      <transition appear name="fade">
        <header>
            <div class="mb-6 flex flex-col justify-center items-center ">
              <h2 class="text-2xl font-bold text-gray-800 font-cormorant mb-4">{{ reservation.page_title }}</h2>
              <div class="bg-white border rounded-lg shadow-sm p-6">
                <div class="grid grid-cols-4 gap-6">
                  <div v-for="(stat, index) in stats" :key="stat.label" class="text-center">
                    <transition appear name="fade" :delay="index * 100">
                      <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">{{ stat.label }}</p>
                        <p class="text-3xl font-bold text-golden">
                          <animated-number :value="stat.value" :duration="1000" />
                        </p>
                      </div>
                    </transition>
                  </div>
                </div>
              </div>
            </div>
        </header>
      </transition>
      
      <div class="flex justify-between items-center my-4 border-y  py-6">
        <PrimaryButton @click="openModal" class="text-sm">
          Edit RSVP Questions
        </PrimaryButton>
        <PrimaryButton>
          + Add Guests
        </PrimaryButton>
      </div>
      <div class="flex space-x-4 mb-6">
        <SecondaryButton>
          Filter Guests
        </SecondaryButton>
        <SecondaryButton>
          Assign Tags
        </SecondaryButton>
        <SecondaryButton>
          Manage Tags
        </SecondaryButton>
        <SecondaryButton>
          Export Guests
        </SecondaryButton>
      </div>
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
                 class="grid grid-cols-4 gap-4 items-center p-4 cursor-pointer hover:bg-gray-50 transition-colors duration-150">
              <h3 class="text-lg font-semibold">{{ group.name }}</h3>
              <span class="text-gray-600">{{ group.rsvp_code }}</span>
              <div class="text-center">
                <Switch
                  v-model="group.invitationSent"
                  @change="toggleInvitation(group)"
                  :class="group.invitationSent ? 'bg-blue-600' : 'bg-gray-200'"
                  class="relative inline-flex h-6 w-11 items-center rounded-full"
                >
                  <span class="sr-only">Toggle invitation</span>
                  <span
                    :class="group.invitationSent ? 'translate-x-6' : 'translate-x-1'"
                    class="inline-block h-4 w-4 transform rounded-full bg-white transition"
                  />
                </Switch>
              </div>
              <div class="flex justify-end">
                <i :class="['pi', openGroups[group.id] ? 'pi-chevron-up' : 'pi-chevron-down']"></i>
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
      @update:show="closeModal"
      @update="updateRSVPQuestions"
    />
  </AuthLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthLayout from "@/Layouts/AuthLayout.vue";
import EditRSVPQuestionsModal from "./Components/EditRSVPQuestionsModal.vue";
import GuestsGroupTable from "./Components/GuestsGroupTable.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Switch } from '@headlessui/vue';
import AnimatedNumber from './Components/AnimatedNumber.vue';

const props = defineProps(['reservation']);
const isModalOpen = ref(false);
const openGroups = ref({});

const stats = computed(() => [
  { label: 'Attending', value: props.reservation.count_attending },
  { label: 'Not Attending', value: props.reservation.count_not_attending },
  { label: 'Pending', value: props.reservation.count_pending },
  { label: 'Total', value: props.reservation.count_total_guests },
]);

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

<style scoped>
/* Add any additional scoped styles here */

@keyframes countUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-enter-active {
  animation: countUp 0.5s ease-out forwards;
}
</style>