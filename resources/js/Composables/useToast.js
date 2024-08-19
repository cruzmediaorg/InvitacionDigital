import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

export function useToast() {
    const page = usePage();

    watch(() => page.props.flash, (flash) => {
        if (flash.success) {
            showToast('success', flash.success);
        }
        if (flash.error) {
            showToast('error', flash.error);
        }
    }, { immediate: true });
}

function showToast(icon, title) {
    let width = Math.min(Math.max(title.length * 10, 400), 500);

    Swal.fire({
        position: 'bottom-right',
        icon,
        toast: true,
        title,
        showConfirmButton: false,
        width,
        timer: 3000
    });
}