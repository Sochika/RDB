import './bootstrap';
/*
  Add custom scripts here
*/
import.meta.glob([
  '../assets/img/**',
  // '../assets/json/**',
  '../assets/vendor/fonts/**'
]);
// resources/js/app.js

import './../../vendor/power-components/livewire-powergrid/dist/powergrid';
// resources/js/app.js

import './../../vendor/power-components/livewire-powergrid/dist/tailwind.css';

// resources/js/app.js

import flatpickr from 'flatpickr';
// resources/js/app.js
import Alpine from 'alpinejs';

import TomSelect from 'tom-select';
window.TomSelect = TomSelect;

window.Alpine = Alpine;

Alpine.start();
