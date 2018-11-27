<template>
    <perfect-scrollbar class="flex-grow p-6 bg-white overflow-auto" :class="classNames">
        <div class="text-3xl mb-4 pb-2 fez123-border-bottom" v-if="title">{{ title }}</div>
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
