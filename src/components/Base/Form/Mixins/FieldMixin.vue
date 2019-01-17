<script>
import ValidationMessage from './ValidationMessage.vue'

export default {
    inject: ['$validator'],
    components: {
        ValidationMessage
    },
    props: {
        label: {
            type: String,
            default: ''
        },
        name: {
            type: String,
            default: ''
        },
        required: {
            type: Boolean,
            default: false
        },
        value: {
            required: false
        },
        validationRules: {
            required: false
        }
    },
    data(){
        return {
            model: this.value
        }
    },
    watch: {
        value(to){
            this.model = to
        }
    }
}
</script>
