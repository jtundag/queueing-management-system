<template>
    <ContentContainer title="Servers">
        <IconInput icon="fez-search" 
        placeholder="Search server..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>

        <Table :columns="tableColumns"
            :data="servers">
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
                    title: 'Reports',
                    icon: 'fez-file'
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
                    name: 'name',
                    label: 'Name',
                },
                {
                    name: 'department',
                    label: 'Department',
                },
                {
                    slot: 'actions'
                }
            ],
            servers: []
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        },
        itemClicked(item, server){
            console.log(item, server)
        }
    }
}
</script>
