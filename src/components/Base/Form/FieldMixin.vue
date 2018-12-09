<script>
export default {
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
        }
    },
    data(){
        return {
            model: this.value
        }
    }
}
</script>
