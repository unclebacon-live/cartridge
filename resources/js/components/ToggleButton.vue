<template>
    <div class="ui-toggle" :class="on ? 'ui-toggle-on' : 'ui-toggle-off'">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: [
            'user-id',
            'type',
            'on'
        ]
    }
</script>

<style scoped>
    .ui-toggle {
        cursor: pointer;
    }
</style>