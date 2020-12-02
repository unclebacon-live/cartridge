require('./bootstrap');
require('particles.js');

require('alpinejs');

particlesJS.load('particles-js', 'particles.json', function() {
    console.log('callback - particles.js config loaded');
});