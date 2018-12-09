<template>
    <ContentContainer title="Personnels">
        <IconInput icon="fez-search" 
        placeholder="Search personnels..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>

        <Table :columns="tableColumns"
            :data="users">
            <template slot="actions" slot-scope="props">
                <Dropdown :items="dropdownItems"
                        @item-click="itemClicked($event, props.rowData)"/>
            </template>
        </Table>

    </ContentContainer>
</template>

<script>
import IconInput from '@/components/Base/IconInput.vue'
import Dropdown from '@/components/Base/Dropdown.vue'
import Table from '@/components/Base/Table.vue'
export default {
    components: {
        IconInput,
        Dropdown,
        Table
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
            tableColumns: [
                {
                    name: 'id',
                    label: '#'
                },
                {
                    name: 'uuid',
                    label: 'Personnel ID',
                },
                {
                    name: 'full_name',
                    label: 'Full Name',
                },
                {
                    name: 'department',
                    label: 'Department',
                },
                {
                    slot: 'actions'
                }
            ],
            users: []
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        },
        itemClicked(item, user){
            console.log(item, user)
        }
    }
}
</script>
