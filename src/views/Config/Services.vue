<template>
    <ContentContainer title="Services">
        <div class="mb-4">
            <Button type="primary" 
                text="Add a Service"
                @click="showAddServiceModal"/>
        </div>
        
        <IconInput icon="fez-search" 
        placeholder="Search services..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>

        <Table ref="servicesTable"
            :columns="tableColumns"
            api="/config/services"
            @before-load="$store.dispatch('toggleFullLoader', true)"
            @after-load="$store.dispatch('toggleFullLoader', false)">
            <template slot="actions" slot-scope="props">
                <Dropdown :actions="dropdownActions"
                        @action-click="actionClicked($event, props.rowData)"/>
            </template>
        </Table>

        <VodalExt ref="addServiceModal" 
            :title="isEditing ? 'Update Service' : 'Add a Service'"
            :width="500"
            :height="210">
            <template slot="body">
                <Input label="Service Name" 
                        name="serviceName" 
                        placeholder="Enter Service Name"
                        :required="true"
                        v-model="serviceName"/>
            </template>
            <template slot="footer">
                <Button type="default" 
                    text="Cancel"
                    @click="hideAddServiceModal"/>
                <Button type="primary" 
                    text="Save"
                    @click="saveService"/>
            </template>
        </VodalExt>

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
            serviceName: null,
            readyForActionItem: null,
            isEditing: false
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        },
        hideAddServiceModal(){
            this.serviceName = null
            this.$refs.addServiceModal.hide()
        },
        showAddServiceModal(){
            this.$refs.addServiceModal.show()
        },
        saveService(){
            this.$store.dispatch('toggleFullLoader', true)
            if(this.isEditing) return this.updateService()
            this.$store.dispatch('createService', { name: this.serviceName })
                .then((response) => {
                    if(response.data.status) this.hideAddServiceModal()
                    this.$refs.servicesTable.loadData()
                })
        },
        updateService(){
            let data = Object.assign(this.readyForActionItem, { new_name: this.serviceName })
            this.$store.dispatch('updateService', data)
                .then((response) => {
                    if(response.data.status) this.hideAddServiceModal()
                    this.$refs.servicesTable.loadData()
                })
        },
        actionClicked(action, data){
            this.readyForActionItem = data
            this.isEditing = false
            switch(action.title){
                case 'Delete':
                    this.$refs.delModal.show()
                    break;
                case 'Edit':
                    this.isEditing = true
                    this.serviceName = data.name
                    this.$refs.addServiceModal.show()
                    break;
            }
        },
        clearReadyForActionItem(){
            this.readyForActionItem = null
            this.$refs.delModal.hide()
        },
        deleteItem(){
            this.$store.dispatch('toggleFullLoader', true)
            this.$store.dispatch('deleteService', this.readyForActionItem.id)
                .then((response) => {
                    this.$store.dispatch('toggleFullLoader', false)
                    if(response.data.status) this.$refs.delModal.hide()
                    this.$refs.servicesTable.loadData()
                })
        }
    }
}
</script>
