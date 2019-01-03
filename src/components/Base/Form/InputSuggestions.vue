<template>
    <div class="relative"
            v-click-outside="hideSuggestions">
        <Input :label="label" 
                :name="name" 
                :placeholder="placeholder" 
                v-model="model"
                :autocomplete="false"
                @focus="getSuggestions"
                @input="getSuggestions"
                :validation-rules="validationRules"/>
        <div class="absolute bg-white shadow-lg w-full suggestions-dropdown z-10"
            v-if="list.length">
            <div class="item p-4 cursor-pointer hover:bg-grey-lighter"
                v-for="(suggestion, index) in list"
                :key="index"
                @click="select(suggestion)">
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
        },
        apiUrl: {
            type: String
        }
    },
    components: {
        Input
    },
    data(){
        return {
            list: this.suggestions
        }
    },
    methods: {
        select(suggestion){
            this.model = suggestion.name
            this.list = []
            this.$emit('selected', suggestion)
        },
        getSuggestions(val){
            this.$http.get(this.apiUrl)
                .then((response) => {
                    this.list = response.data.result
                })
        },
        hideSuggestions(){
            this.list = []
        }
    }
}
</script>
