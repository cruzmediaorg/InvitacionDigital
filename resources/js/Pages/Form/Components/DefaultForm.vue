<script setup>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { ref, computed, watch } from 'vue';
import BorderlessInput from "@/Components/BorderlessInput.vue";
import GoldenButton from "@/Components/GoldenButton.vue";
import {router } from "@inertiajs/vue3";
import QAEditor from "@/Components/QAEditor.vue";
import EventsEditor from "@/Components/EventsEditor.vue"; 
import ImageUploader from "@/Components/ImageUploader.vue";
import PagePreview from '@/Components/PagePreview.vue';

const props = defineProps(['page','block', 'styles']);
const formData = ref([]);
const existingFields = ref([]);

props.block.fields.forEach(field => {
    const fieldType = props.block.type.block_types_fields.find(f => f.id === field.block_types_field_id);
    if (fieldType) {
        existingFields.value.push({
            ...fieldType,
            value: field.value,
            fieldId: field.id
        });
    }
});

const getFieldType = (type) => {
    switch(type) {
        case 'Text':
            return 'text';
        case 'Date':
            return 'date';
        case 'Array':
            return 'array';
        case 'Events': 
            return 'events';
        case 'Image':
            return 'image';
        default:
            return 'text';
    }
};

const submit = () => {
    const formDataToSubmit = existingFields.value.map(field => ({
        id: field.fieldId,
        block_types_field_id: field.id,
        value: field.value
    }));
    router.put(route('pages.blocks.update', {page: props.page.slug, block: props.block.id}), { fields: formDataToSubmit }, {
        preserveState: true,
        preserveScroll: true,
    });
}

const setFieldValue = (key, value) => {
    const field = existingFields.value.find(field => field.key === key);
    if (field) {
        field.value = value;
    }
}

const updateArrayField = (key, newValue) => {
    setFieldValue(key, JSON.stringify(newValue));
}

const blockTitle = ref(props.block.title);
const isVisible = ref(props.block.is_visible);

const updatedBlock = computed(() => ({
  ...props.block,
  fields: existingFields.value,
  title: blockTitle.value,
  is_visible: isVisible.value
}));

const updatedPage = computed(() => ({
  ...props.page,
  blocks: props.page.blocks?.map(b => b.id === props.block.id ? updatedBlock.value : b)
}));

</script>

<template>
    <AuthLayout title="Edit Block">
        <div class="flex">
            <div class="w-1/2 p-4 overflow-y-auto">
                <form @submit.prevent="submit">
                    <h1 class="text-2xl font-bold mb-4">{{ block.title }}</h1>
                    <div v-for="field in existingFields" :key="field.id" class="mb-4">
                        <label :for="field.key" class="block mb-2 font-bold">{{ field.name }}</label>
                        <template v-if="field.type === 'array'">
                            <QAEditor v-if="field.key === 'questions'"
                                :value="JSON.parse(field.value || '[]')"
                                @input="updateArrayField(field.key, $event)"
                            />
                            <EventsEditor v-if="field.key === 'events'"
                                :value="JSON.parse(field.value || '[]')"
                                @input="updateArrayField(field.key, $event)"
                            />
                        </template>
                        <template v-else-if="field.type === 'Image'">
                            <ImageUploader :id="field.fieldId" :value="field.value" @input="setFieldValue(field.key, $event)" />
                        </template>
                        <template v-else>
                            <BorderlessInput
                                :id="field.key"
                                :type="getFieldType(field.type)"
                                :value="field.value"
                                @input="setFieldValue(field.key, $event.target.value)"
                                :required="field.required"
                                :placeholder="field.default"
                            />
                        </template>
                    </div>
                    <GoldenButton type="submit">
                        Guardar cambios
                    </GoldenButton>
                </form>
            </div>
            <div class="w-1/2 min-h-screen p-4">
                <PagePreview :page="updatedPage" :blocks="updatedPage.blocks" :styles="styles" />
            </div>
        </div>
    </AuthLayout>
</template>