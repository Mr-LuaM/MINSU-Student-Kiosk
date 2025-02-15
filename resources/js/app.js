import './bootstrap';
import Alpine from 'alpinejs';
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

// ✅ Import Tall Toasts only if Alpine exists
import ToastComponent from '../../vendor/usernotnull/tall-toasts/resources/js/tall-toasts.js';

// ✅ Ensure Livewire is available globally
window.Livewire = Livewire;
Livewire.start();

// ✅ Ensure AlpineJS is available globally
if (!window.Alpine) {
    window.Alpine = Alpine;
}

// ✅ Register Tall Toasts Plugin properly if Alpine is defined
if (typeof ToastComponent !== "undefined" && !window.Alpine.$persist) {
    window.Alpine.plugin(ToastComponent);
} else {
    console.warn("⚠️ Tall Toasts not loaded or $persist already defined!");
}

// ✅ Start Alpine (ensure it starts only once)
document.addEventListener("DOMContentLoaded", () => {
    if (!window.__AlpineStarted) {
        window.__AlpineStarted = true;
        Alpine.start();
    }
});
