<template>
  <div>
    <div v-if="imagePreview && !isUpdating && !isLoading">
      <img :src="imagePreview" alt="Vista previa" class="w-72 h-72 rounded-md object-cover mb-2" />
      <div class="flex gap-2 mt-2">
        <button class="bg-white text-black px-4 py-2 text-sm rounded-md border border-gray-400" type="button" @click="startUpdate" :disabled="isLoading">
          <i class="pi pi-refresh"></i> Actualizar
        </button>
        <button class="bg-red-700 text-white px-4 py-2 text-sm rounded-md" type="button" @click="deleteImage" :disabled="isLoading">
          <i class="pi pi-trash"></i> Eliminar
        </button>
      </div>
    </div>
    <div v-else>
      <input type="file" @change="handleFileChange" accept="image/*" ref="fileInput" style="display: none;" />
      <button class="bg-white text-black px-4 py-2 rounded-md border border-gray-400" type="button" @click="$refs.fileInput.click()" :disabled="isLoading">
        <i class="pi pi-image"></i> Subir imagen
      </button>
    </div>

    <!-- Loading Circle -->
    <div v-if="isLoading" class="loading-overlay">
      <div class="loading-circle"></div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="modal-overlay">
      <div class="modal-content">
        <Cropper
          v-if="imageUrl"
          :src="imageUrl"
          @change="onChange"
          :stencil-props="{
            aspectRatio: 1
          }"
          ref="cropperRef"
        />
        <div class="modal-buttons">
          <button class="bg-white text-black px-4 py-2 rounded-md border border-gray-400" type="button" @click="uploadCroppedImage" :disabled="isLoading">Subir</button>
          <button class="bg-red-700 text-white px-4 py-2 rounded-md border border-gray-400" type="button" @click="closeModal" :disabled="isLoading">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, nextTick, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';

const props = defineProps({
    id: {
        type: String,
        required: true
    },
    value: {
        type: [String, Object],
        required: true
    }
});

const imageUrl = ref(null);
const cropperRef = ref(null);
const fileInput = ref(null);
const isUpdating = ref(false);
const showModal = ref(false);
const isLoading = ref(false);

const imagePreview = computed(() => {
  if (typeof props.value === 'string') {
    return props.value;
  } else if (props.value && props.value.url) {
    return props.value.url;
  }
  return null;
});

const startUpdate = () => {
  isUpdating.value = true;
  nextTick(() => {
    fileInput.value.click();
  });
};

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    imageUrl.value = URL.createObjectURL(file);
    showModal.value = true;
  }
};

const uploadCroppedImage = () => {
  if (cropperRef.value) {
    isLoading.value = true;
    const { canvas } = cropperRef.value.getResult();
    canvas.toBlob((blob) => {
      const formData = new FormData();
      formData.append('file', blob, 'cropped-image.jpg');
      formData.append('id', props.id);
      router.post(route('blocks.upload-image'), formData, {
        onSuccess: () => {
          closeModal();
          setTimeout(() => {
            window.location.reload();
          }, 500);
        },
      });
    }, 'image/jpeg');
  }
};

const deleteImage = () => {
  isLoading.value = true;
  router.delete(route('blocks.delete-image', { id: props.id }), {
    onSuccess: () => {
      imageUrl.value = null;
      props.value = null;
      setTimeout(() => {
        isLoading.value = false;
        window.location.reload();
      }, 500);
    },
  });
};

const closeModal = () => {
  showModal.value = false;
  imageUrl.value = null;
};
</script>

<style scoped>
.preview-image {
  max-width: 200px;
  max-height: 200px;
}
.button-group {
  margin-top: 10px;
}
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}
.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  width: 80%;
  max-width: 500px;
}
.modal-buttons {
  margin-top: 20px;
  display: flex;
  justify-content: space-between;
}
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}
.loading-circle {
  width: 50px;
  height: 50px;
  border: 5px solid #f3f3f3;
  border-top: 5px solid #3498db;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>