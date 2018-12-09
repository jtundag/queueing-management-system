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
                    :name="`${name}_${option.value}`" 
                    :id="`${name}_${option.value}`"
                    v-model="model"
                    :value="option.value"
                    @change="$emit('change', model)"> <span class="ml-1">{{ option.label }}</span>
            </label>
        </div>
    </div>
</template>

<script>
import FieldMixin from './FieldMixin.vue'

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