<script setup>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import draggable from 'vuedraggable'
import { ref, computed, watch } from 'vue';
import { router } from '@inertiajs/vue3'
import ThemeEditor from './Partials/ThemeEditor.vue';
import PagePreview from '@/Components/PagePreview.vue';
import { Switch } from '@headlessui/vue'

const props = defineProps(['page', 'styles'])
const blocks = ref(props.page.blocks.sort((a, b) => a.order - b.order))
const activeTab = ref('blocks');
const isPublished = ref(!!props.page.published_at);
const updatedStyles = ref(props.styles);

function onDragEnd() {
  blocks.value.forEach((block, index) => {
    block.order = index + 1
  })

  let blocksToUpdate = blocks.value.map(block => ({
    id: block.id,
    order: block.order
  }));

  router.post(route('blocks.order.update'), {
    blocks: blocksToUpdate
  })
}

function togglePublished() {
  isPublished.value = !isPublished.value;
  router.put(route('pages.toggle-visibility', props.page.slug), {
    published: isPublished.value
  });
}

function downloadQRCode() {
  console.log('Downloading QR code...');
}

const toggleBlockVisibility = (block) => {
  router.put(route('pages.blocks.toggle-visibility', [props.page.slug, block.id]), {}, {
    preserveState: true,
    preserveScroll: true,
    onSuccess: () => {
      block.is_visible = !block.is_visible;
    },
  });
};

</script>

<template>
  <AuthLayout title="Pages">
    <div class="bg-white min-h-screen flex">
      <div class="w-1/2 p-4 overflow-y-auto">
        <h1 class="text-3xl mb-4 font-bold text-gray-800 font-cormorant">{{ page.title }}</h1>
        
        <!-- Add tabs -->
        <div class="mb-4 border-b border-gray-200">
          <ul class="flex flex-wrap -mb-px">
            <li class="mr-2">
              <a href="#" @click.prevent="activeTab = 'blocks'" :class="{'border-b-2 border-golden': activeTab === 'blocks'}" class="inline-block p-4 text-gray-600 hover:text-gray-800">Blocks</a>
            </li>
            <li class="mr-2">
              <a href="#" @click.prevent="activeTab = 'theme'" :class="{'border-b-2 border-golden': activeTab === 'theme'}" class="inline-block p-4 text-gray-600 hover:text-gray-800">Theme</a>
            </li>
            <li class="mr-2">
              <a href="#" @click.prevent="activeTab = 'settings'" :class="{'border-b-2 border-golden': activeTab === 'settings'}" class="inline-block p-4 text-gray-600 hover:text-gray-800">Settings</a>
            </li>
          </ul>
        </div>

        <!-- Blocks tab content -->
        <div v-if="activeTab === 'blocks'">
          <draggable 
            v-model="blocks" 
            item-key="id"
            @end="onDragEnd"
            class="flex flex-col gap-2">
            <template #item="{element: block}" :class="{'cursor-move': block.type.is_draggable, 'cursor-not-allowed pointer-events-none': !block.type.is_draggable}">
              <div :class="['border px-12 flex justify-between py-4 rounded-md', {'cursor-move': block.type.is_draggable, 'cursor-not-allowed': !block.type.is_draggable}]">
                <div class="flex items-center gap-2">
                  <i v-if="block.type.is_draggable" class="pi pi-bars"></i>
                  <h2 class="text-lg font-bold text-gray-800 font-sans">{{ block.type.name }}</h2>
                </div>
                <div class="flex items-center gap-2">
                  <button
                    v-if="block.type.is_draggable"
                    @click="toggleBlockVisibility(block)"
                    class="p-2 rounded-full hover:bg-gray-200 transition-colors"
                    :title="block.is_visible ? 'Hide block' : 'Show block'"
                  >
                    <i :class="['pi', block.is_visible ? 'pi-eye' : 'pi-eye-slash']"></i>
                  </button>
                  <PrimaryButton 
                    type="button"
                    @click="router.get(route('pages.blocks.edit', [page.slug, block.id]))"
                    class="hover:bg-golden/80 cursor-pointer">Edit</PrimaryButton>
                </div>
              </div>
            </template>
          </draggable>
        </div>

        <!-- Theme tab content -->
        <div v-if="activeTab === 'theme'">
          <ThemeEditor :page="page" :styles="styles" @handlePreviewUpdate="updatedStyles = $event" />
        </div>

        <!-- Settings tab content -->
        <div v-if="activeTab === 'settings'" class="space-y-6">
          <div class="flex items-center justify-between">
            <span class="text-lg font-light text-gray-900">Website is <span :class="isPublished ? 'text-green-600' : 'text-red-600'" class="font-bold">{{ isPublished ? 'published' : 'hidden' }}</span></span>
            <Switch
              v-model="isPublished"
              @click="togglePublished"
              :class="isPublished ? 'bg-blue-600' : 'bg-gray-200'"
              class="relative inline-flex h-6 w-11 items-center rounded-full"
            >
              <span class="sr-only">Toggle publication</span>
              <span
                :class="isPublished ? 'translate-x-6' : 'translate-x-1'"
                class="inline-block h-4 w-4 transform rounded-full bg-white transition"
              />
            </Switch>
          </div>
          
          <div>
            <h3 class="text-lg font-medium text-gray-900">Your URL</h3>
            <p class="mt-1 text-sm text-gray-600">{{ route('pages.show', page.slug) }}</p>
          </div>
          
          <div>
            <h3 class="text-lg font-medium text-gray-900">Website QR code</h3>
            <PrimaryButton @click="downloadQRCode" class="mt-2">Download QR Code</PrimaryButton>
          </div>
        </div>
      </div>
      
      <!-- Preview section -->
      <div class="w-1/2 p-4">
        <PagePreview :page="page" :blocks="blocks" :styles="updatedStyles" />
      </div>
    </div>
  </AuthLayout>
</template>

<style scoped>
.cursor-not-allowed {
  cursor: not-allowed;
}
</style>