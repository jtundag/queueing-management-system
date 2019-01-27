<template>
    <ContentContainer title="Students">
        <div class="text-right">
            <Button type="primary" 
                    text="Import CSV"
                    @click="showImportCSVModal"/>
        </div>
        <IconInput icon="fez-search" 
        placeholder="Search students..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>
        <Table ref="studentsTable"
            :columns="tableColumns"
            api="/users"
            @before-load="$store.dispatch('toggleFullLoader', true)"
            @after-load="$store.dispatch('toggleFullLoader', false)"
            :custom-params="{ 'role': 'student' }">
            <template slot="full_name" slot-scope="props">
                {{ props.rowData.first_name }} {{ props.rowData.last_name }}
            </template>

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
                    @click="clearReadyForActionUser"/>
                <Button type="primary" 
                    text="Yes"
                    @click="deleteUser"/>
            </template>
        </VodalExt>
        
        <VodalExt ref="importCSVModal" 
            title="Import data from CSV">
            <template slot="body">
                <file-upload
                    ref="importCSVUpload"
                    v-model="files"
                    :post-action="`${axiosBaseURL}users/import/csv?role=student`"
                    @input-file="importCSVSuccess"
                    class="upload-container text-center w-full h-48 fez123-border m-auto inline-block relative border-dashed cursor-pointer hover:border-grey">
                    <span class="center-float text-2xl">
                        Click to Upload
                    </span>
                </file-upload>
            </template>
            <template slot="footer">
                <Button type="primary" 
                    text="Import"
                    @click="importCSV"/>
            </template>
        </VodalExt>

    </ContentContainer>
</template>

<script>
import IconInput from '@/components/Base/IconInput.vue'
import Dropdown from '@/components/Base/Dropdown.vue'
import Table from '@/components/Base/Table.vue'
import VodalExt from '@/components/Base/Vodal/VodalExt.vue'
import VueUploadComponent from 'vue-upload-component'

export default {
    components: {
        IconInput,
        Dropdown,
        VodalExt,
        Table,
        'file-upload': VueUploadComponent
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
                    name: 'uuid',
                    label: 'Student ID',
                },
                {
                    slot: 'full_name',
                    label: 'Full Name',
                },
                {
                    slot: 'department',
                    label: 'Department',
                },
                {
                    slot: 'actions'
                }
            ],
            users: [],
            readyForActionItem: null,
            files: [],
            axiosBaseURL: window.axios.defaults.baseURL
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        },
        actionClicked(action, user){
            this.readyForActionItem = user
            switch(action.title){
                case 'Delete':
                    this.$refs.delModal.show()
                    break;
                case 'Edit':
                    this.$router.push(`/users/students/${user.id}/edit`)
                    break;
            }
        },
        clearReadyForActionUser(){
            this.readyForActionItem = null
            this.$refs.delModal.hide()
        },
        deleteUser(){
            this.$store.dispatch('toggleFullLoader', true)
            this.$store.dispatch('deleteUser', this.readyForActionItem.id)
                .then((response) => {
                    this.$store.dispatch('toggleFullLoader', false)
                    if(response.data.status) this.$refs.delModal.hide()
                    this.$refs.studentsTable.loadData()
                })
        },
        showImportCSVModal(){
            this.$refs.importCSVModal.show()
        },
        hideImportCSVModal(){
            this.$refs.importCSVModal.hide()
        },
        importCSV(){
            this.$store.dispatch('toggleFullLoader', true)
            this.$refs.importCSVUpload.active = true
            this.hideImportCSVModal()
        },
        importCSVSuccess(newFile, oldFile){
            if(newFile && newFile.response.status){
                this.$store.dispatch('toggleFullLoader', false)
                this.hideImportCSVModal()
                this.$refs.studentsTable.loadData()
            }
        }
    }
}
</script>
