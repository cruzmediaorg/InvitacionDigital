<template>
    <div class="py-1 hover:cursor-pointer relative overflow-hidden" :class="{ 'border-r-2 hover:border-y-0 border-r-golden': active && !isParent }">
        <div class="flex justify-between items-center gap-2 px-4 py-2.5 hover:rounded-r-full mr-2 transition-all duration-300 ease-in-out" :class="{ 'ml-8': !isParent && parentIsOpen, 'bg-gray-200 rounded-r-full': active, 'hover:bg-gray-200': !active }">
            <Link v-if="href !== '#'" :href="href" class="w-full relative" @click="handleLinkClick">
                <span :class="[isParent ? 'pl-4' : 'pl-8']">{{ text }}</span>
                <span class="ripple absolute" ref="ripple"></span>
            </Link>
            <span v-else @click="handleLinkClick" class="relative">
                {{ text }}
                <span class="ripple absolute" ref="ripple"></span>
            </span>
            <i v-if="isParent" class="transition-transform duration-300 ease-in-out pi" :class="[isOpen ? 'pi-chevron-up' : 'pi-chevron-down']" @click.stop="toggleDropdown"></i>
        </div>
        <div v-if="isParent && isOpen" class="submenu-wrapper">
            <slot name="submenu"></slot>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: false,
        default: '#'
    },
    active: {
        type: Boolean,
        required: true
    },
    icon: {
        type: String,
        required: false
    },
    text: {
        type: String,
        required: true
    },
    isParent: {
        type: Boolean,
        required: false,
        default: false
    },
    parentIsOpen: {
        type: Boolean,
        required: false,
        default: false
    }
});

const isOpen = ref(true);

const toggleDropdown = () => {
    if (props.isParent) {
        isOpen.value = !isOpen.value;
    }
};

const ripple = ref(null);

const handleLinkClick = (event) => {
    if (props.isParent && props.href !== '#') {
        event.preventDefault();
    }
    
    // Add subtle ripple effect
    const rippleElement = ripple.value;
    rippleElement.classList.remove('animate-ripple');
    const rect = event.currentTarget.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height) * 0.5; // Reduced size
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;
    
    rippleElement.style.width = `${size}px`;
    rippleElement.style.height = `${size}px`;
    rippleElement.style.left = `${x}px`;
    rippleElement.style.top = `${y}px`;
    
    rippleElement.classList.add('animate-ripple');
};
</script>

<style scoped>
.ripple {
  background-color: rgba(255, 255, 255, 0.3); /* Reduced opacity */
  border-radius: 50%;
  pointer-events: none;
  transform: scale(0);
}

@keyframes ripple {
  to {
    transform: scale(2); /* Reduced scale */
    opacity: 0;
  }
}

.animate-ripple {
  animation: ripple 0.4s ease-out; /* Shortened duration and changed timing function */
}
</style>