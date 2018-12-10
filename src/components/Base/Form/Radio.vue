<template>
    <div>
        <label :for="name" class="block text-sm mb-2">
            {{ label }}
            <span class="text-red" v-if="required">
                *
            </span>
        </label>
        <div v-for="(option, index) in options"
            :key="index">
            <label :for="`${name}_${option.value}`" class="text-sm">
                <input type="radio" 
                    :name="name" 
                    :id="`${name}_${option.value}`"
                    v-model="model"
                    :value="option.value"
                    @change="$emit('change', model)"
                    :data-vv-as="label"
                    v-validate="validationRules"><span class="ml-1">{{ option.label }}</span>
            </label>
        </div>
        <ValidationMessage :name="name"/>
    </div>
</template>

<script>
import FieldMixin from './Mixins/FieldMixin.vue'

export default {
    mixins: [FieldMixin],
    props: {
        options: {
            type: Array,
            required: true
        }
    }
}
</script>