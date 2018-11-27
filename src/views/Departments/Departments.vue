<template>
    <ContentContainer title="Departments">
        <IconInput icon="fez-search" 
        placeholder="Search department..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>

        <table class="table-auto mt-5 w-full">
            <thead class="fez123-border-bottom">
                <tr>
                    <th class="px-4 py-5 font-normal text-left">#</th>
                    <th class="px-4 py-5 font-normal text-left">Name</th>
                    <th class="px-4 py-5 font-normal"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="fez123-border-bottom" 
                    v-for="(department, index) in departments"
                    :key="index">
                    <td class="px-4 py-5">
                        {{ department.id }}
                    </td>
                    <td class="px-4 py-5">
                        {{ department.name }}
                    </td>
                    <td>
                        <Dropdown :items="dropdownItems"
                            @item-click="itemClicked($event, department)"/>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="mt-5 text-right">
            <Pagination/>
        </div>
    </ContentContainer>
</template>

<script>
import IconInput from '@/components/Base/IconInput.vue'
import Dropdown from '@/components/Base/Dropdown.vue'
import Pagination from '@/components/Base/Pagination.vue'
export default {
    components: {
        IconInput,
        Dropdown,
        Pagination
    },
    data(){
        return {
            searchKeyword: null,
            dropdownItems: [
                {
                    title: 'More',
                    icon: 'fez-zoom-in'
                },
                {
                    title: 'Edit',
                    icon: 'fez-setting_edit'
                },
                {
                    title: 'Delete',
                    icon: 'fez-close'
                }
            ],
            departments: [
                {
                    id: 1,
                    name: '2014-F0089'
                },
                {
                    id: 2,
                    name: '2014-F0089'
                },
                {
                    id: 3,
                    name: '2014-F0089'
                },
                {
                    id: 4,
                    name: '2014-F0089'
                }
            ]
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        },
        itemClicked(item, department){
            console.log(item, department)
        }
    }
}
</script>
