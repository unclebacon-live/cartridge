<template>
    <span class="icon icon-small">
        <feather :type="type"></feather>
    </span>
</template>

<script>
    export default {
        props: [
            'type'
        ]
    }
</script>