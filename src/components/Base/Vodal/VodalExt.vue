<template>
    <vodal :show="isShown" 
        animation="slideDown" 
        @hide="hide" 
        :height="height"
        :width="width"
        :close-button="closable"
        :close-on-esc="closable"
        :close-on-click-mask="closable">
        <div class="flex flex-col justify-between text-sm">
            <div class="modal-title fez123-border-bottom pb-3 pt-1 font-bold">
                {{ title }}
            </div>
            <div class="modal-body py-3">
                <slot name="body"/>
            </div>
            <div class="modal-footer text-right fez123-border-top pt-4">
                <slot name="footer"/>
            </div>
        </div>
    </vodal>
</template>

<script>
import Vodal from 'vodal'

export default {
    components: {
        Vodal
    },
    props: {
        title: {
            default: ''
        },
        height: {
            type: Number,
            default: 185
        },
        width: {
            type: Number
        },
        closable: {
            type: Boolean,
            default: true
        }
    },
    data(){
        return {
            isShown: false
        }
    },
    methods: {
        show(){
            this.isShown = true
        },
        hide(){
            this.isShown = false
            this.$emit('hide')
        }
    }
}
</script>
