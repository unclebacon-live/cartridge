<template>
    <span class="icon" v-html="icon"></span>
</template>

<script>
    const feather = require('feather-icons');

    export default {
        props: [
            'type'
        ],
        data: function() {
            return {
                icon: ''
            }
        },
        mounted: function() {
            if(typeof feather.icons[this.type] === 'undefined') {

            } else {
                this.icon = feather.icons[this.type].toSvg({
                    width: '1em',
                    height: '1em'
                })
            }
        }
    }
</script>