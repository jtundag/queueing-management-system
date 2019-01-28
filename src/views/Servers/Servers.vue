<template>
    <ContentContainer title="Servers">
        <IconInput icon="fez-search" 
        placeholder="Search server..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>

        <Table ref="serversTable"
            :columns="tableColumns"
            api="/servers"
            @before-load="$store.dispatch('toggleFullLoader', true)"
            @after-load="$store.dispatch('toggleFullLoader', false)">
            <template slot="department" slot-scope="props">
                {{ props.rowData.department.name }}
            </template>
            <template slot="actions" slot-scope="props">
                <Dropdown :actions="dropdownActions"
                        @action-click="actionClicked($event, props.rowData)"/>
            </template>
        </Table>
        
        <VodalExt ref="delModal" 
            title="Confirm" 
            :height="155">
            <template slot="body">
                Are you sure you want to delete this record?
            </template>
            <template slot="footer">
                <Button type="default" 
                    text="No"
                    @click="clearReadyForActionItem"/>
                <Button type="primary" 
                    text="Yes"
                    @click="deleteServer"/>
            </template>
        </VodalExt>

    </ContentContainer>
</template>

<script>
import IconInput from '@/components/Base/IconInput.vue'
import Dropdown from '@/components/Base/Dropdown.vue'
import Table from '@/components/Base/Table.vue'
import VodalExt from '@/components/Base/Vodal/VodalExt.vue'

export default {
    components: {
        IconInput,
        Dropdown,
        Table,
        VodalExt
    },
    data(){
        return {
            searchKeyword: null,
            dropdownActions: [
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
                    slot: 'department',
                    label: 'Department',
                },
                {
                    slot: 'actions'
                }
            ],
            servers: [],
            readyForActionItem: null
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        },
        clearReadyForActionItem(){
            this.readyForActionItem = null
            this.$refs.delModal.hide()
        },
        deleteServer(){
            this.$store.dispatch('toggleFullLoader', true)
            this.$store.dispatch('deleteServer', this.readyForActionItem.id)
                .then((response) => {
                    this.$store.dispatch('toggleFullLoader', false)
                    if(response.data.status) this.$refs.delModal.hide()
                    this.$refs.serversTable.loadData()
                })
        },
        actionClicked(action, server){
            this.readyForActionItem = server
            switch(action.title){
                case 'Delete':
                    this.$refs.delModal.show()
                    break;
                case 'Reports':
                    this.$router.push(`/servers/${server.id}/reports`)
                    break;
                case 'Edit':
                    this.$router.push(`/servers/${server.id}/edit`)
                    break;
            }
        }
    }
}
</script>
