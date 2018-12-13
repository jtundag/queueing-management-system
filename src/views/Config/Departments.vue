<template>
    <ContentContainer title="Departments">
        <div class="mb-4">
            <Button type="primary" 
                text="Add Department"
                @click="showAddDepartmentModal"/>
        </div>
        
        <IconInput icon="fez-search" 
        placeholder="Search department..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>

        <Table ref="departmentsTable"
            :columns="tableColumns"
            api="/config/departments"
            @before-load="$store.dispatch('toggleFullLoader', true)"
            @after-load="$store.dispatch('toggleFullLoader', false)">
            <template slot="actions" slot-scope="props">
                <Dropdown :actions="dropdownActions"
                        @action-click="actionClicked($event, props.rowData)"/>
            </template>
        </Table>

        <VodalExt ref="addDepartmentModal" 
            :title="isEditing ? 'Update Department' : 'Add a Department'"
            :width="500"
            :height="210">
            <template slot="body">
                <Input label="Department Name" 
                        name="departmentName" 
                        placeholder="Enter Department Name"
                        :required="true"
                        v-model="departmentName"/>
            </template>
            <template slot="footer">
                <Button type="default" 
                    text="Cancel"
                    @click="hideAddDepartmentModal"/>
                <Button type="primary" 
                    text="Save"
                    @click="saveDepartment"/>
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
            departmentName: null,
            readyForActionItem: null,
            isEditing: false
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        },
        hideAddDepartmentModal(){
            this.departmentName = null
            this.$refs.addDepartmentModal.hide()
        },
        showAddDepartmentModal(){
            this.$refs.addDepartmentModal.show()
        },
        saveDepartment(){
            this.$store.dispatch('toggleFullLoader', true)
            if(this.isEditing) return this.updateDepartment()
            this.$store.dispatch('createDepartment', { name: this.departmentName })
                .then((response) => {
                    if(response.data.status) this.hideAddDepartmentModal()
                    this.$refs.departmentsTable.loadData()
                })
        },
        updateDepartment(){
            let data = Object.assign(this.readyForActionItem, { new_name: this.departmentName })
            this.$store.dispatch('updateDepartment', data)
                .then((response) => {
                    if(response.data.status) this.hideAddDepartmentModal()
                    this.$refs.departmentsTable.loadData()
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
                    this.departmentName = data.name
                    this.$refs.addDepartmentModal.show()
                    break;
            }
        },
        clearReadyForActionItem(){
            this.readyForActionItem = null
            this.$refs.delModal.hide()
        },
        deleteItem(){
            this.$store.dispatch('deleteDepartment', this.readyForActionItem.id)
                .then((response) => {
                    if(response.data.status) this.$refs.delModal.hide()
                    this.$refs.departmentsTable.loadData()
                })
        }
    }
}
</script>
