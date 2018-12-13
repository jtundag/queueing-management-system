import Form from './Form.vue'
import Button from './Button.vue'
import Input from './Input.vue'
import InputSuggestions from './InputSuggestions.vue'
import Radio from './Radio.vue'

export default {
    install(Vue){
        Vue.component('Form', Form)
        Vue.component('Button', Button)
        Vue.component('Input', Input)
        Vue.component('InputSuggestions', InputSuggestions)
        Vue.component('Radio', Radio)
    }
}