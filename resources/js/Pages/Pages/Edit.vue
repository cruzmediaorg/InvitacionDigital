<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import draggable from 'vuedraggable'
import { ref, computed, watch } from 'vue';
import { router } from '@inertiajs/vue3'
import ThemeEditor from './Partials/ThemeEditor.vue';
import PagePreview from '@/Components/PagePreview.vue';

const props = defineProps(['page'])
const blocks = ref(props.page.blocks.sort((a, b) => a.order - b.order))
const activeTab = ref('blocks');
const styles = ref({ ...props.page });

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

watch([blocks, styles], () => {
  // This will trigger a re-render of the preview when blocks or styles change
}, { deep: true });
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
                <PrimaryButton 
                    type="button"
                    @click="router.get(route('pages.blocks.edit', [page.slug, block.id]))"
                    class="hover:bg-golden/80 cursor-pointer">Edit</PrimaryButton>
              </div>
            </template>
          </draggable>
        </div>

        <!-- Theme tab content -->
        <div v-if="activeTab === 'theme'">
          <ThemeEditor :page="page" v-model="styles" />
        </div>
      </div>
      
      <!-- Preview section -->
      <div class="w-1/2 p-4">
        <PagePreview :page="page" :blocks="blocks" :styles="styles" />
      </div>
    </div>
  </AuthLayout>
</template>

<style scoped>
.cursor-not-allowed {
  cursor: not-allowed;
}
</style>