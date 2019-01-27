<template>
    <div>
        <label :for="name" class="block mb-2">
            {{ label }}
            <span class="text-red" v-if="required">
                *
            </span>
        </label>
        <input :type="type" 
            :name="name" 
            :id="name" 
            class="block border rounded-sm leading-normal p-3 text-sm no-outline w-full" 
            :placeholder="placeholder"
            v-model="model"
            @input="$emit('input', $event.target.value)"
            @keyup="$emit('keyup', $event)"
            :data-vv-as="label"
            v-validate="validationRules"
            :class="{ 'border-red': errors.has(name), 'focus:border-grey fez123-border': !errors.has(name) }"
            :autocomplete="autocomplete ? 'on' : 'off'">
        <ValidationMessage :name="name"/>
    </div>
</template>

<script>
import FieldMixin from './Mixins/FieldMixin.vue'

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
        },
        autocomplete: {
            type: Boolean,
            default: true
        }
    }
}
</script>
