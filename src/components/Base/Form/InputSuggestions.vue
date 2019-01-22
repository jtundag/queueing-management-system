<template>
    <div class="relative"
            v-click-outside="hideSuggestions">
        <Input :label="label" 
                :name="name" 
                :placeholder="placeholder" 
                v-model="textModel"
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
        },
        text: {
            type: String,
            default: null
        }
    },
    components: {
        Input
    },
    created(){
        if(this.model){
            this.$emit('selected', this.model)
        }
    },
    data(){
        return {
            list: this.suggestions,
            model: this.value,
            textModel: this.text
        }
    },
    methods: {
        select(suggestion){
            this.model = suggestion
            this.list = []
            this.$emit('input', suggestion)
            this.$emit('selected', suggestion)
        },
        async getSuggestions(){
            let response = await this.$http.get(this.apiUrl, { params: { keyword: this.textModel } })
            this.list = response.data.result
        },
        hideSuggestions(){
            this.list = []
        }
    },
    watch: {
        text(to){
            this.textModel = to
        }
    }
}
</script>
