<script setup>
import { ref, watch, reactive, toRefs } from 'vue';
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import { ColorPicker } from 'vue-color-kit'
import 'vue-color-kit/dist/vue-color-kit.css'
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import FontSelector from '@/Components/FontSelector.vue';
import { router } from '@inertiajs/vue3';
import debounce from 'lodash.debounce';

const props = defineProps(['page', 'styles']);
const emit = defineEmits(['handlePreviewUpdate']);

const form = reactive({ ...props.styles });

const fonts = [
  'Allura', 'Alex Brush', 'Cormorant Garamond', 'Crafty Lover', 'DM Serif',
  'French Press', 'Helostar', 'Grance', 'Gresthine', 'Hujan',
  'Jost', 'Julius Sans One', 'Lorina Script', 'Metafors', 'Neuton Light',
  'Playfair', 'Quicksand'
];

const updateColor = debounce((color, key) => {
  form[key] = color.hex;
}, 300); 

const updateFontSize = debounce((value, key) => {
  form[key] = value;
}, 300);

watch(() => form, (newVal) => {
  emit('handlePreviewUpdate', newVal);
}, { deep: true });

const updateTheme = () => {
  router.put(route('pages.update-theme', props.page.slug), {
    ...form
  });
};

</script>

<template>
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <form @submit.prevent="updateTheme">
      <h2 class="text-2xl font-bold mb-4">Heading</h2>
      <div class="space-y-4 mb-8">
        <div class="flex items-center justify-between">
          <InputLabel for="home_h_text_color" value="Header Text Color" class="w-1/2" />
          <Popover class="relative w-1/2 flex justify-end">
            <PopoverButton class="w-fit flex items-center justify-between border border-gray-300 rounded-md p-2">
              
              <div class="w-6 h-6 rounded-full border" :style="{ backgroundColor: form.home_h_text_color }"></div>
            </PopoverButton>
            <PopoverPanel class="absolute z-10 right-0 mt-2">
              <ColorPicker
                :color="form.home_h_text_color"
                @change-color="color => updateColor(color, 'home_h_text_color')"
                :sucker-hide="true"
                :sucker-canvas="null"
                :sucker-area="null"
              />
            </PopoverPanel>
          </Popover>
        </div>
        <div class="flex items-center justify-between">
          <InputLabel for="home_p_text_color" value="Paragraph Text Color" class="w-1/2" />
          <Popover class="relative w-1/2 flex justify-end">
            <PopoverButton class="w-fit flex items-center justify-between border border-gray-300 rounded-md p-2">
              
              <div class="w-6 h-6 rounded-full border " :style="{ backgroundColor: form.home_p_text_color }"></div>
            </PopoverButton>
            <PopoverPanel class="absolute z-10 right-0 mt-2">
              <ColorPicker
                :color="form.home_p_text_color"
                @change-color="color => updateColor(color, 'home_p_text_color')"
                :sucker-hide="true"
                :sucker-canvas="null"
                :sucker-area="null"
              />
            </PopoverPanel>
          </Popover>
        </div>
        <div class="flex items-center justify-between">
          <InputLabel for="home_h_font_family" value="Home Heading Font Family" class="w-1/2" />
          <FontSelector
            id="home_h_font_family"
            v-model="form.home_h_font_family"
            :fonts="fonts"
            class="w-1/2 "
          />
        </div>
        <div class="flex items-center justify-between">
          <InputLabel for="home_p_font_family" value="Paragraph Font Family" class="w-1/2" />
          <FontSelector
            id="home_p_font_family"
            v-model="form.home_p_font_family"
            :fonts="fonts"
            class="w-1/2"
          />
        </div>
        <div class="flex items-center justify-between">
          <InputLabel for="home_h1_font_size" value="Heading Font Size" class="w-1/2" />
          <div class="flex items-center w-1/2">
            <input
              type="range"
              id="home_h1_font_size"
              v-model="form.home_h1_font_size"
              min="17"
              max="40"
              step="1"
              class="w-3/4 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
              @input="updateFontSize($event.target.value, 'home_h1_font_size')"
            />
          </div>
        </div>
       
        <div class="flex items-center justify-between">
          <InputLabel for="home_p_font_size" value="Paragraph Font Size" class="w-1/2" />
          <div class="flex items-center w-1/2">
            <input
              type="range"
              id="home_p_font_size"
              v-model="form.home_p_font_size"
              min="17"
              max="40"
              step="1"
              class="w-3/4 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
              @input="updateFontSize($event.target.value, 'home_p_font_size')"
            />
          </div>
        </div>
      </div>

      <h2 class="text-2xl font-bold mb-4">Body</h2>
      <div class="space-y-4">
        <div class="flex items-center justify-between">
          <InputLabel for="body_h_text_color" value="Headings Text Color" class="w-1/2" />
          <Popover class="relative w-1/2 flex justify-end">
            <PopoverButton class="w-fit flex items-center justify-between border border-gray-300 rounded-md p-2">
              
              <div class="w-6 h-6 rounded-full border" :style="{ backgroundColor: form.body_h_text_color }"></div>
            </PopoverButton>
            <PopoverPanel class="absolute z-10 right-0 mt-2">
              <ColorPicker
                :color="form.body_h_text_color"
                @change-color="color => updateColor(color, 'body_h_text_color')"
                :sucker-hide="true"
                :sucker-canvas="null"
                :sucker-area="null"
              />
            </PopoverPanel>
          </Popover>
        </div>
        <div class="flex items-center justify-between">
          <InputLabel for="body_p_text_color" value="Paragraph Text Color" class="w-1/2" />
          <Popover class="relative w-1/2 flex justify-end">
            <PopoverButton class="w-fit flex items-center justify-between border border-gray-300 rounded-md p-2">
              
              <div class="w-6 h-6 rounded-full border" :style="{ backgroundColor: form.body_p_text_color }"></div>
            </PopoverButton>
            <PopoverPanel class="absolute z-10 right-0 mt-2">
              <ColorPicker
                :color="form.body_p_text_color"
                @change-color="color => updateColor(color, 'body_p_text_color')"
                :sucker-hide="true"
                :sucker-canvas="null"
                :sucker-area="null"
              />
            </PopoverPanel>
          </Popover>
        </div>
        <div class="flex items-center justify-between">
          <InputLabel for="body_h_font_family" value="Headings Font Family" class="w-1/2" />
          <FontSelector
            id="body_h_font_family"
            v-model="form.body_h_font_family"
            :fonts="fonts"
            class="w-1/2"
          />
        </div>
        <div class="flex items-center justify-between">
          <InputLabel for="body_p_font_family" value="Paragraph Font Family" class="w-1/2" />
          <FontSelector
            id="body_p_font_family"
            v-model="form.body_p_font_family"
            :fonts="fonts"
            class="w-1/2"
          />
        </div>
        <div class="flex items-center justify-between">
          <InputLabel for="body_h2_font_size" value="Headings Font Size" class="w-1/2" />
          <div class="flex items-center w-1/2">
            <input
              type="range"
              id="body_h1_font_size"
              v-model="form.body_h2_font_size"
              min="17"
              max="40"
              step="1"
              class="w-3/4 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
              @input="updateFontSize($event.target.value, 'body_h1_font_size')"
            />
          </div>
        </div>
  
        <div class="flex items-center justify-between">
          <InputLabel for="body_p_font_size" value="Paragraph Font Size" class="w-1/2" />
          <div class="flex items-center w-1/2">
            <input
              type="range"
              id="body_p_font_size"
              v-model="form.body_p_font_size"
              min="17"
              max="40"
              step="1"
              class="w-3/4 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
              @input="updateFontSize($event.target.value, 'body_p_font_size')"
            />
          </div>
        </div>
      </div>
      <div class="mt-6">
        <PrimaryButton type="submit">Update Theme</PrimaryButton>
      </div>
    </form>
  </div>
</template>

<style scoped>
.color-picker {
  width: 100%;
  max-width: 250px;
}

input[type="range"] {
  width: 75%;
}

input[type="range"]::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 20px;
  height: 20px;
  background: #4CAF50;
  cursor: pointer;
  border-radius: 50%;
}

input[type="range"]::-moz-range-thumb {
  width: 20px;
  height: 20px;
  background: #4CAF50;
  cursor: pointer;
  border-radius: 50%;
}

</style>