<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import draggable from 'vuedraggable'
import { ref, computed } from 'vue';
import { router} from '@inertiajs/vue3'

const props = defineProps(['page'])
const blocks = ref(props.page.blocks.sort((a, b) => a.order - b.order))

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
</script>

<template>
  <AuthLayout title="Pages">
    <div class="bg-white min-h-screen">
      <h1 class="text-3xl mb-4 font-bold text-gray-800 font-cormorant">{{ page.title }}</h1>
      <draggable 
        v-model="blocks" 
        item-key="id"
        @end="onDragEnd"
        :disabled="!block?.type_is_draggable"
        class="flex flex-col gap-2">
        <template #item="{element: block}">
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
  </AuthLayout>
</template>

<style scoped>
.cursor-not-allowed {
  cursor: not-allowed;
}
</style>