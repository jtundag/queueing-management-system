<template>
    <ContentContainer title="Groups">
        <div class="mb-4">
            <Button type="primary" 
                text="Add Group"
                @click="showAddGroupModal"/>
        </div>
        
        <IconInput icon="fez-search" 
        placeholder="Search department..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>

        <Table ref="departmentsTable"
            :columns="tableColumns"
            api="/config/groups"
            @before-load="$store.dispatch('toggleFullLoader', true)"
            @after-load="$store.dispatch('toggleFullLoader', false)">
            <template slot="actions" slot-scope="props">
                <Dropdown :actions="dropdownActions"
                        @action-click="actionClicked($event, props.rowData)"/>
            </template>
        </Table>

        <VodalExt ref="addGroupModal" 
            :title="isEditing ? 'Update Group' : 'Add a Group'"
            :width="500"
            :height="210">
            <template slot="body">
                <Input label="Group Name" 
                        name="departmentName" 
                        placeholder="Enter Group Name"
                        :required="true"
                        v-model="departmentName"/>
            </template>
            <template slot="footer">
                <Button type="default" 
                    text="Cancel"
                    @click="hideAddGroupModal"/>
                <Button type="primary" 
                    text="Save"
                    @click="saveGroup"/>
            </template>
        </VodalExt>

        <VodalExt ref="delModal" 
            title="Confirm">
            <template slot="body" v-if="readyForActionItem">
                <div>
                    Are you sure you want to delete this record?
                </div>
                <div class="mt-4">
                    <strong class="text-red">
                        The following departments will also get deleted:
                    </strong>
                    <ul>
                        <li v-for="(department, index) in readyForActionItem.departments"
                        :key="index">
                            {{ department.name }}
                        </li>
                    </ul>
                </div>
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
        hideAddGroupModal(){
            this.departmentName = null
            this.$refs.addGroupModal.hide()
        },
        showAddGroupModal(){
            this.$refs.addGroupModal.show()
        },
        saveGroup(){
            this.$store.dispatch('toggleFullLoader', true)
            if(this.isEditing) return this.updateGroup()
            this.$store.dispatch('createGroup', { name: this.departmentName })
                .then((response) => {
                    if(response.data.status) this.hideAddGroupModal()
                    this.$refs.departmentsTable.loadData()
                })
        },
        updateGroup(){
            let data = Object.assign(this.readyForActionItem, { new_name: this.departmentName })
            this.$store.dispatch('updateGroup', data)
                .then((response) => {
                    if(response.data.status) this.hideAddGroupModal()
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
                    this.$refs.addGroupModal.show()
                    break;
            }
        },
        clearReadyForActionItem(){
            this.readyForActionItem = null
            this.$refs.delModal.hide()
        },
        deleteItem(){
            this.$store.dispatch('deleteGroup', this.readyForActionItem.id)
                .then((response) => {
                    if(response.data.status) this.$refs.delModal.hide()
                    this.$refs.departmentsTable.loadData()
                })
        }
    }
}
</script>
