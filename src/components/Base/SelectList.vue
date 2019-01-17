<template>
    <div class="fez123-select-list-container">
        <IconInput icon="fez-search" 
        :placeholder="placeholder" 
        name="search_input" 
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
                <slot :item="_combineItem(item, index)"/>
                <div class="absolute item-checked-indicator">
                    <span class="fez-choose text-5xl block text-grey-light" :class="{ 'primary-text': isSelected(item) }"></span>
                </div>
            </div>
            <div v-if="!items.length" class="text-center pt-2 text-sm">
                Empty List.
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
            default: () => []
        },
        maxHeight: {
            default: 'none'
        },
        filterWith: {
            default: ''
        },
        fullWidth: {
            default: true
        },
        value: {
            default: null
        },
        placeholder: {
            type: String,
            default: ''
        },
        single: {
            type: Boolean,
            default: false
        },
        primaryKey: {
            type: String,
            required: true
        },
        apiUrl: {
            default: null
        }
    },
    created(){
        this.refresh()
    },
    data(){
        return {
            items: this.list,
            selectedItems: this.value || [],
            searchKeyword: null,
            singleSelectedItem: null
        }
    },
    methods: {
        _refreshItems(){
            this.$http.get(this.apiUrl)
                .then((response) => {
                    this.items = response.data.result
                    this._setValue(this.value)
                })
        },
        refresh(){
            if(this.apiUrl){
                this._refreshItems()
                return
            }
            this._setValue(this.value)
        },
        select(item){
            if(this.single){
                this.singleSelectedItem = this.singleSelectedItem == item ? null : item
                return this.$emit('input', item)
            }
            this.singleSelectedItem = null
            if(window._.find(this.selectedItems, { [this.primaryKey]: item[this.primaryKey] })) return this.selectedItems.splice(this.selectedItems.indexOf(item), 1)
            this.selectedItems.push(item)
            return this.$emit('input', this.selectedItems)
        },
        isSelected(item){
            if(this.single) return this.primaryKey ? (item[this.primaryKey] == this.singleSelectedItem[this.primaryKey]) : (window.isEqual(item, this.singleSelectedItem))
            return this.primaryKey ? window._.map(this.selectedItems, this.primaryKey).includes(item[this.primaryKey]) : (this.selectedItems.includes(item))
        },
        clearKeyword(){
            this.searchKeyword = null
            this.$refs.inputSearch.clearInput()
        },
        _combineItem(item, index){
            return {
                ...item,
                index
            }
        },
        _setValue(val){
            if(this.single) return this.singleSelectedItem = val
            this.selectedItems = val || []
        }
    },
    computed: {
        filteredList(){
            if(!this.searchKeyword) return this.items
            return this.items.filter((item) => item[this.filterWith].match(this.searchKeyword))
        }
    },
    watch: {
        value(to){
            this._setValue(to)
        },
        list(to){
            this.items = to
        },
        apiUrl(){
            this.refresh()
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
