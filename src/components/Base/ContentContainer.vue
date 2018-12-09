<template>
    <perfect-scrollbar class="flex-grow p-3 bg-white overflow-auto" :class="classNames">
        <slot/>
    </perfect-scrollbar>
</template>


<script>
export default {
    props: {
        title: {
            type: String,
            default: ''
        },
        classNames: {
            required: false
        }
    }
}
</script>
