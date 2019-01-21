<template>
    <ContentContainer title="Personnels">
        <IconInput icon="fez-search" 
        placeholder="Search personnels..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>
        
        <Table ref="personnelsTable"
            :columns="tableColumns"
            api="/users"
            @before-load="$store.dispatch('toggleFullLoader', true)"
            @after-load="$store.dispatch('toggleFullLoader', false)"
            :custom-params="{ 'role': 'personnel' }">
            <template slot="full_name" slot-scope="props">
                {{ props.rowData.first_name }} {{ props.rowData.last_name }}
            </template>

            <template slot="department" v-if="props.rowData.department" slot-scope="props">
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
    data(){
        return {
            searchKeyword: null,
            actionAction: [
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
                    label: 'Personnel ID',
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
            readyForActionItem: null
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
                    this.$router.push(`/users/personnels/${user.id}/edit`)
                    break;
            }
        },
        clearReadyForActionUser(){
            this.readyForActionItem = null
            this.$refs.delModal.hide()
        },
        deleteUser(){
            this.$store.dispatch('toggleFullLoader', true)
            console.log(this.readyForActionItem)
            this.$store.dispatch('deleteUser', this.readyForActionItem.id)
                .then((response) => {
                    this.$store.dispatch('toggleFullLoader', false)
                    if(response.data.status) this.$refs.delModal.hide()
                    this.$refs.personnelsTable.loadData()
                })
        }
    }
}
</script>
