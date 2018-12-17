<template>
    <ContentContainer title="Courses">
        <div class="mb-4">
            <Button type="primary" 
                text="Add Course"
                @click="showAddCourseModal"/>
        </div>
        
        <IconInput icon="fez-search" 
        placeholder="Search course..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>

        <Table ref="coursesTable"
            :columns="tableColumns"
            api="/config/courses"
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

        <VodalExt ref="addCourseModal" 
            :title="isEditing ? 'Update Course' : 'Add a Course'"
            :width="500"
            :height="300">
            <template slot="body">
                <Input label="Course Name" 
                        name="courseName" 
                        placeholder="Enter Course Name"
                        :required="true"
                        v-model="formData.name"/>
                
                <InputSuggestions label="Department" 
                        name="department" 
                        placeholder="Enter Department"
                        v-model="formData.department"
                        :validation-rules="`required`"
                        api-url="/config/departments"
                        @selected="selectDepartment">
                        <div slot-scope="props">
                            {{ props.suggestion.name }}
                        </div>
                    </InputSuggestions>
            </template>
            <template slot="footer">
                <Button type="default" 
                    text="Cancel"
                    @click="hideAddCourseModal"/>
                <Button type="primary" 
                    text="Save"
                    @click="saveCourse"/>
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
                    slot: 'department',
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
                department: null,
                department_id: null
            }
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        },
        hideAddCourseModal(){
            this.formData = {
                name: null,
                department: null,
                department_id: null
            }
            this.$refs.addCourseModal.hide()
        },
        showAddCourseModal(){
            this.$refs.addCourseModal.show()
        },
        saveCourse(){
            this.$store.dispatch('toggleFullLoader', true)
            if(this.isEditing) return this.updateCourse()
            this.$store.dispatch('createCourse', this.formData)
                .then((response) => {
                    if(response.data.status) this.hideAddCourseModal()
                    this.$refs.coursesTable.loadData()
                })
        },
        updateCourse(){
            let data = Object.assign(this.readyForActionItem, this.formData)
            this.$store.dispatch('updateCourse', data)
                .then((response) => {
                    if(response.data.status) this.hideAddCourseModal()
                    this.$refs.coursesTable.loadData()
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
                        department_id: data.department_id,
                        department: data.department
                    }
                    this.$refs.addCourseModal.show()
                    break;
            }
        },
        clearReadyForActionItem(){
            this.readyForActionItem = null
            this.$refs.delModal.hide()
        },
        deleteItem(){
            this.$store.dispatch('deleteCourse', this.readyForActionItem.id)
                .then((response) => {
                    if(response.data.status) this.$refs.delModal.hide()
                    this.$refs.coursesTable.loadData()
                })
        },
        selectDepartment(department){
            console.log(department)
            this.formData.department_id = department.id
        }
    }
}
</script>
