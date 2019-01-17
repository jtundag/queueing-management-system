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

        <Table ref="groupsTable"
            :columns="tableColumns"
            api="/config/departments"
            @before-load="$store.dispatch('toggleFullLoader', true)"
            @after-load="$store.dispatch('toggleFullLoader', false)">
            <template slot="group" slot-scope="props">
                {{ props.rowData.group.name }}
            </template>
            
            <template slot="actions" slot-scope="props">
                <Dropdown :actions="dropdownActions"
                        @action-click="actionClicked($event, props.rowData)"/>
            </template>
        </Table>

        <VodalExt ref="addDepartmentModal" 
            :title="isEditing ? 'Update Department' : 'Add a Department'"
            :width="500"
            :height="300"
            @hide="clearFields">
            <template slot="body">
                <Input label="Department Name" 
                        name="departmentName" 
                        placeholder="Enter Department Name"
                        :required="true"
                        :validation-rules="`required`"
                        v-model="formData.name"/>
                <Input label="Numbering Prefix" 
                    name="number_prefix" 
                    placeholder="Enter Numbering Prefix (IT, EMT, etc...)"
                    :validation-rules="`required`"
                    v-model="formData.prefix"/>
                <InputSuggestions label="Group" 
                    name="group" 
                    placeholder="Enter Group"
                    :text="formData.group.name"
                    v-model="formData.group"
                    :validation-rules="`required`"
                    api-url="/config/groups"
                    @selected="selectGroup">
                    <div slot-scope="props">
                        {{ props.suggestion.name }}
                    </div>
                </InputSuggestions>
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
                    slot: 'group',
                    label: 'Department',
                },
                {
                    slot: 'actions'
                }
            ],
            readyForActionItem: null,
            isEditing: false,
            formData: {
                name: null,
                prefix: null,
                group: {name: null},
                group_id: null
            }
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        },
        clearFields(){
            this.formData = {
                name: null,
                group: {name: null},
                group_id: null
            }
        },
        hideAddDepartmentModal(){
            this.clearFields()
            this.$refs.addDepartmentModal.hide()
        },
        showAddDepartmentModal(){
            this.$refs.addDepartmentModal.show()
        },
        saveDepartment(){
            this.$store.dispatch('toggleFullLoader', true)
            if(this.isEditing) return this.updateDepartment()
            this.$store.dispatch('createDepartment', this.formData)
                .then((response) => {
                    if(response.data.status) this.hideAddDepartmentModal()
                    this.$refs.groupsTable.loadData()
                })
        },
        updateDepartment(){
            let data = Object.assign(this.readyForActionItem, this.formData)
            this.$store.dispatch('updateDepartment', data)
                .then((response) => {
                    if(response.data.status) this.hideAddDepartmentModal()
                    this.$refs.groupsTable.loadData()
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
                    this.formData = {
                        name: data.name,
                        prefix: data.prefix,
                        group_id: data.group_id,
                        group: data.group.name
                    }
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
                    this.$refs.groupsTable.loadData()
                })
        },
        selectGroup(group){
            this.formData.group_id = group.id
        }
    }
}
</script>
