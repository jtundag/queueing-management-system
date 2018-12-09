<template>
    <vodal :show="isShown" 
        animation="slideDown" 
        @hide="isShown = false" 
        :height="height"
        :width="width">
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
        }
    }
}
</script>
