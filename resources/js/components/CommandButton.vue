<template>
    <div 
        class="button" 
        v-on:click="onClick" 
        :class="inProgress && 'is-loading'" 
        :disabled="inProgress">
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: [
        'path'
    ],
    data: function() {
        return {
            inProgress: false
        }
    },
    methods: {
        onClick: function() {
            let component = this;
            this.inProgress = true
            axios
                .post(this.path)
                .then(function(response) {
                    component.inProgress = false
                });
        }
    }
}
</script>