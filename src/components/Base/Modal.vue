<template>
    <div class="fez123-modal-container fixed pin">
        <div class="fez123-modal absolute bg-white shadow-lg fez123-border p-4">
            <div class="text-xl fez123-modal-title">{{ title }}</div>
            <div class="fez123-modal-body">
                <slot name="body"></slot>
            </div>
            <div class="fez123-modal-footer">
                
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'fez123-modal',
    props: {
        title: {
            type: String,
            default: ''
        }
    }
}
</script>
