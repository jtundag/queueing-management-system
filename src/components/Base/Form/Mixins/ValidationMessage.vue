<template v-if="errors.has(name)">
    <div class="v-message text-sm pt-2 text-red">
        {{ errors.first(name) }}
    </div>
</template>

<script>
export default {
    inject: ['$validator'],
    props: {
        name: {
            type: String,
            required: true
        }
    }
}
</script>
