<template>
    <div class="flex">
        <div class="flex-none fez123-bg-grey-lightest">
            <span class="align-middle text-4xl inline-block pt-1" :class="icon"></span>
        </div>
        <div class="flex-grow">
            <input type="text" 
            :name="name" 
            :id="name" 
            class="block fez123-bg-grey-lightest no-outline py-3 pr-5 w-full tracking-wide leading-normal" 
            :placeholder="placeholder"
            v-model="val"
            @input="$emit('input', val)">
        </div>
        <div class="flex-none fez123-bg-grey-lightest" 
            v-if="tailingIcon"
            @click="tailingIconClicked">
            <span class="align-middle text-4xl inline-block pt-1 cursor-pointer" 
            :class="tailingIcon"></span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        icon: {
            required: true
        },
        placeholder: {
            required: true
        },
        tailingIcon: {
            default: 'fez-close'
        },
        name: {
            required: true
        },
        value: {
            required: false
        }
    },
    data(){
        return {
            val: this.value
        }
    },
    methods: {
        tailingIconClicked(){
            this.$emit('tailing-icon-clicked')
        },
        clearInput(){
            this.val = null
        }
    }
}
</script>

