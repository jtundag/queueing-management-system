<template>
    <div class="fez123-select-list-container">
        <IconInput icon="fez-search" 
        placeholder="Search personnel..." 
        name="search_field" 
        @tailing-icon-clicked="clearKeyword"
        @input="searchKeyword = $event"
        ref="inputSearch"
        v-if="filterWith"/>
        <perfect-scrollbar class="fez123-select-list px-3 pt-1 pb-3 fez123-border select-none" 
            :style="{ maxHeight }"
            :class="{ 'flex': !fullWidth }">
            <div v-for="(item, index) in filteredList" 
                :key="index" 
                class="item pr-4 pl-12 py-5 relative mt-2 cursor-pointer hover:border-grey-light"
                :class="{ 'border border-grey': isSelected(item), 'fez123-border': !isSelected(item), 'w-full': fullWidth, 'flex-grow': !fullWidth, 'border-r-0': (!fullWidth && (index < (filteredList.length - 1))) }"
            @click="select(item)">
                <slot :item="item"/>
                <div class="absolute item-checked-indicator">
                    <span class="fez-choose text-5xl block text-grey-light" :class="{ 'primary-text': isSelected(item) }"></span>
                </div>
            </div>
        </perfect-scrollbar>
    </div>
</template>

<script>
import IconInput from '@/components/Base/IconInput.vue'
export default {
    components: {
        IconInput
    },
    props: {
        list: {
            type: Array,
            required: true
        },
        maxHeight: {
            default: 'none'
        },
        filterWith: {
            default: ''
        },
        fullWidth: {
            default: true
        }
    },
    data(){
        return {
            selectedItems: [],
            searchKeyword: null
        }
    },
    methods: {
        select(item){
            if(this.selectedItems.includes(item)) return this.selectedItems.splice(this.selectedItems.indexOf(item), 1)
            this.selectedItems.push(item)
        },
        isSelected(index){
            return this.selectedItems.includes(index)
        },
        clearKeyword(){
            this.searchKeyword = null
            this.$refs.inputSearch.clearInput()
        }
    },
    computed: {
        filteredList(){
            if(!this.searchKeyword) return this.list
            return this.list.filter((item) => item[this.filterWith].match(this.searchKeyword))
        }
    }
}
</script>

<style lang="scss" scoped>
    .item-checked-indicator {
        left: 0;
        top: 50%;
        transform: translateY(-50%);
    }
</style>
