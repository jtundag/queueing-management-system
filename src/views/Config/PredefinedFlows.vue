<template>
    <ContentContainer title="Predefined Flows">
        <div class="mb-4">
            <router-link class="py-2 px-5 no-outline rounded-sm text-sm mr-2 fez123-button-primary no-underline" to="/config/predefined-flows/create">
                Add a New Flow
            </router-link>
        </div>
        
        <IconInput icon="fez-search" 
        placeholder="Search flows..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>

        <Table ref="flowsTable"
            :columns="tableColumns"
            api="/config/predefined-flows"
            @before-load="$store.dispatch('toggleFullLoader', true)"
            @after-load="$store.dispatch('toggleFullLoader', false)">
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
                    @click="deleteItem"/>
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
                    slot: 'actions'
                }
            ],
            readyForActionItem: null,
            isEditing: false
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        },
        actionClicked(action, data){
            this.readyForActionItem = data
            this.isEditing = false
            switch(action.title){
                case 'Delete':
                    this.$refs.delModal.show()
                    break;
                case 'Edit':
                    this.$router.push(`/config/predefined-flows/${data.id}/edit`)
                    break;
            }
        },
        clearReadyForActionItem(){
            this.readyForActionItem = null
            this.$refs.delModal.hide()
        },
        deleteItem(){
            this.$store.dispatch('toggleFullLoader', true)
            this.$store.dispatch('deletePredefinedFlow', this.readyForActionItem.id)
                .then((response) => {
                    this.$store.dispatch('toggleFullLoader', false)
                    if(response.data.status) this.$refs.delModal.hide()
                    this.$refs.flowsTable.loadData()
                })
        }
    }
}
</script>
