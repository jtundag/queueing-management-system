<template>
    <form action="#" @submit.prevent="$emit('submit', $event)">
        <slot/>
    </form>
</template>

<script>
export default {
    inject: ['$validator'],
    methods: {
        validate(){
            return this.$validator.validate()
        }
    }
}
</script>
