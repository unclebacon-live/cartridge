<template>
    <div id="particles-js"></div>
</template>

<script>
    require('particles.js');

    export default {
        mounted: function(){
            particlesJS.load('particles-js', 'particles.json', function() {
                console.log('callback - particles.js config loaded');
            });
        }
    }
</script>