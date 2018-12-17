<template>
    <ContentContainer title="Students">
        <IconInput icon="fez-search" 
        placeholder="Search students..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>
        
        <Table ref="studentsTable"
            :columns="tableColumns"
            api="/users"
            @before-load="$store.dispatch('toggleFullLoader', true)"
            @after-load="$store.dispatch('toggleFullLoader', false)">
            <template slot="full_name" slot-scope="props">
                {{ props.rowData.first_name }} {{ props.rowData.last_name }}
            </template>

            <template slot="department" slot-scope="props">
                {{ props.rowData.department.name }}
            </template>
            
            <template slot="actions" slot-scope="props">
                <Dropdown :actions="actionAction"
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
        VodalExt,
        Table
    },
    created(){
        this.$store.dispatch('getUsers', {
            role: 'students'
        }).then((response) => {
            console.log(response)
            // this.users = response.data.result
        })
    },
    data(){
        return {
            searchKeyword: null,
            actionAction: [
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
                    label: 'Student ID',
                },
                {
                    slot: 'full_name',
                    label: 'Full Name',
                },
                {
                    name: 'course',
                    label: 'Course',
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
            readyForActionUser: null
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        },
        actionClicked(action, user){
            this.readyForActionUser = user
            switch(action.title){
                case 'Delete':
                    this.$refs.delModal.show()
                    break;
            }
        },
        clearReadyForActionUser(){
            this.readyForActionUser = null
            this.$refs.delModal.hide()
        },
        deleteUser(){
            console.log('delete', this.readyForActionUser)
        }
    }
}
</script>
