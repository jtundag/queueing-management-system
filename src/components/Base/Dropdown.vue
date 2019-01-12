<template>
    <div class="relative inline-block">
        <button type="button" 
            class="w-auto text-center h-auto no-outline"
            :class="[{ 'fez123-button-primary z-20 relative': isDropdownShown }, customClass]"
            @click="toggleDropdown">
            <span :class="[`text-${iconSize}xl`, (!isDropdownShown ? icon : 'fez-close')]"></span>
        </button>
        <ul class="absolute w-64 bg-white list-reset z-10 shadow-lg rounded-lg dropdown-menu pin-r" v-if="isDropdownShown" v-click-outside="hideDropdown">
            <li class="px-4 py-2 fez123-border-bottom cursor-pointer"
                v-for="(action, index) in actions"
                :key="index"
                @click="$emit('action-click', action)">
                <span class="text-4xl align-middle"
                    :class="action.icon"></span>
                <span class="align-middle">
                    {{ action.title }}
                </span>
            </li>
        </ul>
    </div>
</template>


<script>
export default {
    props: {
        actions: {
            type: Array,
            default: () => []
        },
        iconSize: {
            type: String,
            default: '3'
        },
        icon: {
            type: String,
            default: 'fez-arrow_down'
        },
        customClass: {
            type: String,
            default: 'rounded-full fez123-border'
        }
    },
    data(){
        return {
            isDropdownShown: false
        }
    },
    methods: {
        toggleDropdown(){
            this.isDropdownShown = !this.isDropdownShown
        },
        hideDropdown(){
            this.isDropdownShown = false
        }
    }
}
</script>
