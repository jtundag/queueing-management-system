<template>
    <div>
        <label :for="name" class="block text-sm mb-2">
            {{ label }}
            <span class="text-red" v-if="required">
                *
            </span>
        </label>
        <input :type="type" 
            :name="name" 
            :id="name" 
            class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" 
            :placeholder="placeholder"
            :required="required"
            :value="value"
            @input="$emit('input', $event.target.value)">
    </div>
</template>

<script>
import FieldMixin from './FieldMixin.vue'

export default {
    mixins: [FieldMixin],
    props: {
        type: {
            type: String,
            default: 'text'
        },
        placeholder: {
            type: String,
            default: null
        }
    }
}
</script>
