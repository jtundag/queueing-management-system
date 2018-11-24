<template>
    <div class="inline-block rounded-lg overflow-hidden">
        <div v-for="(choice, index) in choices" 
            :key="index"
            class="px-2 py-1 inline-block cursor-pointer text-sm select-none"
            :class="{ 'fez123-bg-primary text-white': (selected == choice.key), 'bg-grey-lighter': (selected != choice.key) }"
            @click="select(choice.key)"
            :style="{ backgroundColor: (selected == choice.key ? choice.activeBgColor : inactiveBgColor), color: (selected == choice.key ? choice.activeTextColor : inactiveTextColor) }">
            {{ choice.label }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        choices: {
            type: Array,
            default: () => { return [
                {
                    key: 'on',
                    label: 'On',
                    activeBgColor: '#12d9a9',
                    activeTextColor: 'white'
                },
                {
                    key: 'off',
                    label: 'Off',
                    activeBgColor: '#12d9a9',
                    activeTextColor: 'white'
                }
            ] }
        },
        value: {
            required: true
        },
        inactiveBgColor: {
            type: String,
            default: '#F0F5F8'
        },
        inactiveTextColor: {
            type: String,
            default: '#3d3d3d'
        }
    },
    data(){
        return {
            selected: this.value
        }
    },
    methods: {
        select(key){
            this.selected = key
            this.$emit('change', key)
        }
    }
}
</script>

