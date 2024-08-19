<script setup>
import { ref, watch } from 'vue';
import BorderlessInput from "@/Components/BorderlessInput.vue";
import BorderlessTextarea from "@/Components/BorderlessTextarea.vue";
const props = defineProps(['value']);
const emit = defineEmits(['input']);

const qaItems = ref(props.value);

watch(qaItems, (newValue) => {
    emit('input', newValue);
}, { deep: true });

const addItem = () => {
    qaItems.value.push({ question: '', answer: '' });
};

const removeItem = (index) => {
    qaItems.value.splice(index, 1);
};
</script>

<template>
    <div class="border py-5 px-6 rounded-md">
        <div v-for="(item, index) in qaItems" :key="index" class="pt-4 rounded relative mb-4">
            <div class="mb-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pregunta:</label>
                <BorderlessInput
                    v-model="item.question"
                    placeholder="Escribe la pregunta aquí"
                    class="w-full"
                />
            </div>
            <div class="mb-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Respuesta:</label>
                <BorderlessTextarea
                    v-model="item.answer"
                    placeholder="Escribe la respuesta aquí"
                    class="w-full"
                />
            </div>
            <button type="button" @click="removeItem(index)" class="text-red-500 text-sm absolute right-4 top-4">
                <i class="pi pi-trash"></i>
            </button>
        </div>
        <div class="flex justify-center">
            <button type="button"  @click="addItem" class="mt-4 border-gray-800  px-4 py-3">
                <i class="pi pi-plus"></i> Nueva pregunta
            </button>
        </div>
    </div>
</template>