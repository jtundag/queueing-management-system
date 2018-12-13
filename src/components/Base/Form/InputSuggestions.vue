<template>
    <div class="relative">
        <Input :label="label" 
                :name="name"
                :placeholder="placeholder"
                :validation-rules="validationRules"
                v-model="model"
                :autocomplete="false"/>
        <div class="absolute bg-white shadow-lg w-full suggestions-dropdown"
            v-if="suggestions.length">
            <div class="item p-4 cursor-pointer hover:bg-grey-lighter"
                v-for="(suggestion, index) in suggestions"
                :key="index">
                <slot :suggestion="suggestion"/>
            </div>
        </div>
    </div>
</template>

<script>
import FieldMixin from './Mixins/FieldMixin.vue'
import Input from './Input.vue'

export default {
    mixins: [FieldMixin],
    props: {
        placeholder: {
            type: String,
            default: null
        },
        suggestions: {
            type: Array,
            default: () => []
        }
    },
    components: {
        Input
    }
}
</script>
