<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps(['page']);
const emit = defineEmits(['update:modelValue']);

const form = ref({
  theme_id: props.page.theme_id,
  home_h_text_color: props.page.home_h_text_color || props.page.theme?.home_h_text_color,
  home_p_text_color: props.page.home_p_text_color || props.page.theme?.home_p_text_color,
  home_h_font_family: props.page.home_h_font_family || props.page.theme?.home_h_font_family,
  home_p_font_family: props.page.home_p_font_family || props.page.theme?.home_p_font_family,
  home_h1_font_size: props.page.home_h1_font_size || props.page.theme?.home_h1_font_size,
  home_h2_font_size: props.page.home_h2_font_size || props.page.theme?.home_h2_font_size,
  home_h3_font_size: props.page.home_h3_font_size || props.page.theme?.home_h3_font_size,
  home_p_font_size: props.page.home_p_font_size || props.page.theme?.home_p_font_size,
  body_h_text_color: props.page.body_h_text_color || props.page.theme?.body_h_text_color,
  body_p_text_color: props.page.body_p_text_color || props.page.theme?.body_p_text_color,
  body_h_font_family: props.page.body_h_font_family || props.page.theme?.body_h_font_family,
  body_p_font_family: props.page.body_p_font_family || props.page.theme?.body_p_font_family,
  body_h1_font_size: props.page.body_h1_font_size || props.page.theme?.body_h1_font_size,
  body_h2_font_size: props.page.body_h2_font_size || props.page.theme?.body_h2_font_size,
  body_h3_font_size: props.page.body_h3_font_size || props.page.theme?.body_h3_font_size,
  body_p_font_size: props.page.body_p_font_size || props.page.theme?.body_p_font_size,
});

watch(form, (newValue) => {
  emit('update:modelValue', newValue);
}, { deep: true });

const updateTheme = () => {
  router.put(route('pages.update-theme', props.page.slug), form.value, {
    preserveState: true,
    preserveScroll: true,
  });
};
</script>

<template>
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <form @submit.prevent="updateTheme">
      <h2 class="text-2xl font-bold mb-4">Home Styles</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
          <InputLabel for="home_h_text_color" value="Home Heading Text Color" />
          <TextInput id="home_h_text_color" v-model="form.home_h_text_color" type="color" class="mt-1 block w-full" />
        </div>
        <div>
          <InputLabel for="home_p_text_color" value="Home Paragraph Text Color" />
          <TextInput id="home_p_text_color" v-model="form.home_p_text_color" type="color" class="mt-1 block w-full" />
        </div>
        <div>
          <InputLabel for="home_h_font_family" value="Home Heading Font Family" />
          <TextInput id="home_h_font_family" v-model="form.home_h_font_family" type="text" class="mt-1 block w-full" />
        </div>
        <div>
          <InputLabel for="home_p_font_family" value="Home Paragraph Font Family" />
          <TextInput id="home_p_font_family" v-model="form.home_p_font_family" type="text" class="mt-1 block w-full" />
        </div>
        <div>
          <InputLabel for="home_h1_font_size" value="Home H1 Font Size" />
          <TextInput id="home_h1_font_size" v-model="form.home_h1_font_size" type="number" class="mt-1 block w-full" />
        </div>
        <div>
          <InputLabel for="home_h2_font_size" value="Home H2 Font Size" />
          <TextInput id="home_h2_font_size" v-model="form.home_h2_font_size" type="number" class="mt-1 block w-full" />
        </div>
        <div>
          <InputLabel for="home_h3_font_size" value="Home H3 Font Size" />
          <TextInput id="home_h3_font_size" v-model="form.home_h3_font_size" type="number" class="mt-1 block w-full" />
        </div>
        <div>
          <InputLabel for="home_p_font_size" value="Home Paragraph Font Size" />
          <TextInput id="home_p_font_size" v-model="form.home_p_font_size" type="number" class="mt-1 block w-full" />
        </div>
      </div>

      <h2 class="text-2xl font-bold mb-4">Body Styles</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <InputLabel for="body_h_text_color" value="Body Heading Text Color" />
          <TextInput id="body_h_text_color" v-model="form.body_h_text_color" type="color" class="mt-1 block w-full" />
        </div>
        <div>
          <InputLabel for="body_p_text_color" value="Body Paragraph Text Color" />
          <TextInput id="body_p_text_color" v-model="form.body_p_text_color" type="color" class="mt-1 block w-full" />
        </div>
        <div>
          <InputLabel for="body_h_font_family" value="Body Heading Font Family" />
          <TextInput id="body_h_font_family" v-model="form.body_h_font_family" type="text" class="mt-1 block w-full" />
        </div>
        <div>
          <InputLabel for="body_p_font_family" value="Body Paragraph Font Family" />
          <TextInput id="body_p_font_family" v-model="form.body_p_font_family" type="text" class="mt-1 block w-full" />
        </div>
        <div>
          <InputLabel for="body_h1_font_size" value="Body H1 Font Size" />
          <TextInput id="body_h1_font_size" v-model="form.body_h1_font_size" type="number" class="mt-1 block w-full" />
        </div>
        <div>
          <InputLabel for="body_h2_font_size" value="Body H2 Font Size" />
          <TextInput id="body_h2_font_size" v-model="form.body_h2_font_size" type="number" class="mt-1 block w-full" />
        </div>
        <div>
          <InputLabel for="body_h3_font_size" value="Body H3 Font Size" />
          <TextInput id="body_h3_font_size" v-model="form.body_h3_font_size" type="number" class="mt-1 block w-full" />
        </div>
        <div>
          <InputLabel for="body_p_font_size" value="Body Paragraph Font Size" />
          <TextInput id="body_p_font_size" v-model="form.body_p_font_size" type="number" class="mt-1 block w-full" />
        </div>
      </div>
      <div class="mt-6">
        <PrimaryButton type="submit">Update Theme</PrimaryButton>
      </div>
    </form>
  </div>
</template>