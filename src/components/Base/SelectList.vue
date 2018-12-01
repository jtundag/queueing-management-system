<template>
    <perfect-scrollbar class="fez123-select-list px-3 pt-1 pb-3 fez123-border rounded-sm select-none" :style="{ maxHeight }">
        <div v-for="(item, index) in list" 
            :key="index" 
            class="item px-4 py-5 fez123-border w-full relative mt-2 cursor-pointer hover:border-grey-light rounded-sm"
            :class="{ 'border-grey': isSelected(index) }"
        @click="select(index)">
            <slot :item="item"/>
            <div class="absolute pin-r pin-t h-full">
                <span class="fez-choose text-5xl mt-3 block text-grey-light" :class="{ 'primary-text': isSelected(index) }"></span>
            </div>
        </div>
    </perfect-scrollbar>
</template>

<script>
export default {
    props: {
        list: {
            type: Array,
            required: true
        },
        maxHeight: {
            default: 'none'
        }
    },
    data(){
        return {
            selectedIndices: []
        }
    },
    methods: {
        select(index){
            if(this.selectedIndices.includes(index)) return this.selectedIndices.splice(this.selectedIndices.indexOf(index), 1)
            this.selectedIndices.push(index)
        },
        isSelected(index){
            console.log(this.selectedIndices.includes(index))
            return this.selectedIndices.includes(index)
        }
    }
}
</script>

