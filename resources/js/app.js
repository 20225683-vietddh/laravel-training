import './bootstrap';

// Import Bootstrap JS
import 'bootstrap';

// Import jQuery (required for Light Bootstrap Dashboard)
import $ from 'jquery';
window.$ = window.jQuery = $;

// Import Light Bootstrap Dashboard JS
import './light-bootstrap-dashboard';
import './demo';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
