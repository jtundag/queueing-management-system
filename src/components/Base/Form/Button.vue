<template>
    <button :type="submit ? 'submit' : 'button'" 
        class="py-2 px-5 no-outline rounded-sm text-sm mr-2"
        :class="`fez123-button-${type}`"
        @click="$emit('click')">
        {{ text }}
    </button>
</template>

<script>
export default {
    props: {
        type: {
            default: 'default'
        },
        submit: {
            type: Boolean,
            default: false
        },
        text: {
            type: String,
            required: true
        }
    }
}
</script>

