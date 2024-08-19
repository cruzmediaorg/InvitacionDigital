<script setup>
import { ref, watch, computed } from 'vue';
import BorderlessInput from "@/Components/BorderlessInput.vue";

const props = defineProps(['value']);
const emit = defineEmits(['input']);

const events = ref(props.value);
const showModal = ref(false);
const editingEvent = ref(null);
const newEvent = ref({ title: '', date: '', startTime: '', endTime: '', location: '', isPrivate: false });

const currentEvent = computed(() => editingEvent.value || newEvent.value);

const formatDateTime = (dateTime) => {
    if (!dateTime) return '';
    return dateTime.replace(' ', 'T');
};

const parseDateTime = (dateTime) => {
    if (!dateTime) return '';
    return dateTime.replace('T', ' ');
};

const minDate = computed(() => {
    const today = new Date();
    return today.toISOString().split('T')[0];
});

watch(events, (newValue) => {
    emit('input', newValue);
}, { deep: true });

const openModal = (event = null) => {
    if (event) {
        editingEvent.value = { ...event };
    } else {
        editingEvent.value = null;
        newEvent.value = { title: '', date: '', startTime: '', endTime: '', location: '', isPrivate: false };
    }
    showModal.value = true;
};

const saveEvent = () => {
    const eventToSave = editingEvent.value || newEvent.value;

    if (editingEvent.value) {
        const index = events.value.findIndex(e => e === editingEvent.value);
        if (index !== -1) {
            events.value[index] = eventToSave;
        }
    } else {
        events.value.push(eventToSave);
    }
    showModal.value = false;
};

const closeModal = () => {
    showModal.value = false;
    editingEvent.value = null;
};

const updateEventField = (field, value) => {
    if (editingEvent.value) {
        editingEvent.value[field] = value;
    } else {
        newEvent.value[field] = value;
    }
};

const removeEvent = (index) => {
    events.value.splice(index, 1);
};
</script>

<template>
    <div>
        <div v-for="(event, index) in events" :key="index" class="mb-4 border border-gray-200 rounded-lg p-4 relative">
            <h3 class="text-lg font-semibold mb-2">{{ event.title }}</h3>
            <p class="text-gray-600 mb-1">{{ event.date }} {{ event.startTime }} - {{ event.endTime }}</p>
            <p class="text-red-800"><i class="pi pi-map-marker"></i> {{ event.location }}</p>
            <div class="mt-2 flex justify-end absolute right-5 bottom-5">
                <button type="button" @click="openModal(event)" class="text-gray-500 mr-2">
                    <i class="pi pi-pencil"></i>
                </button>
                <button type="button" @click="removeEvent(index)" class="text-gray-500">
                    <i class="pi pi-trash"></i>
                </button>
            </div>
        </div>
        
        <div class="flex justify-center">
            <button type="button"  @click="openModal()" class="mt-4 border-gray-800  px-4 py-3">
                <i class="pi pi-plus"></i> Nuevo evento
            </button>
        </div>

        <!-- Modal para añadir/editar evento -->
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg w-full max-w-md">
                <div class="flex justify-between items-center p-4 border-b">
                    <h3 class="text-xl font-medium">{{ editingEvent ? 'Edit Event' : 'Add Event' }}</h3>
                    <button type="button" @click="closeModal" class="text-gray-500 hover:text-gray-700">
                        <i class="pi pi-times"></i>
                    </button>
                </div>
                <div class="p-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                        <BorderlessInput 
                            :value="currentEvent.title"
                            @input="(e) => updateEventField('title', e.target.value)"
                            placeholder="Event title"
                            class="w-full"
                        />
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha *</label>
                        <BorderlessInput 
                            :value="currentEvent.date"
                            @input="(e) => updateEventField('date', e.target.value)"
                            type="date"
                            :min="minDate"
                            class="w-full"
                        />
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hora de inicio *</label>
                        <BorderlessInput 
                            :value="currentEvent.startTime"
                            @input="(e) => updateEventField('startTime', e.target.value)"
                            type="time"
                            class="w-full"
                        />
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hora de fin</label>
                        <BorderlessInput 
                            :value="currentEvent.endTime"
                            @input="(e) => updateEventField('endTime', e.target.value)"
                            type="time"
                            class="w-full"
                        />
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <BorderlessInput 
                            :value="currentEvent.location"
                            @input="(e) => updateEventField('location', e.target.value)"
                            placeholder="Event location"
                            class="w-full"
                        />
                    </div>
                    <div class="mb-4 flex items-center">
                        <input 
                            type="checkbox" 
                            :checked="currentEvent.isPrivate"
                            @change="(e) => updateEventField('isPrivate', e.target.checked)"
                            id="privateEvent" 
                            class="mr-2"
                        />
                        <label for="privateEvent" class="text-sm text-gray-700">Private event for guests:</label>
                        <i class="pi pi-info-circle ml-2 text-gray-500"></i>
                    </div>
                    <div>
                        <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded mr-2">Select tags</button>
                    </div>
                </div>
                <div class="flex justify-end p-4 border-t">
                    <button @click="closeModal" class="text-gray-600 px-4 py-2 rounded mr-2">Cancel</button>
                    <button @click="saveEvent" class="bg-gray-800 text-white px-4 py-2 rounded">Save Event</button>
                </div>
            </div>
        </div>
    </div>
</template>