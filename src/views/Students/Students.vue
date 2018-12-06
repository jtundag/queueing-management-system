<template>
    <ContentContainer title="Students">
        <IconInput icon="fez-search" 
        placeholder="Search students..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>
        
        <Table :columns="tableColumns"
            :data="[{ id: 1, uuid: 1, full_name: 'Test', course: 'Test', department: 'Test' }, { id: 2, uuid: 2, full_name: 'Test 2', course: 'Test 2', department: 'Test' }]">
            <template slot="actions" slot-scope="props">
                <Dropdown :items="dropdownItems"
                        @item-click="itemClicked($event, props.rowData)"/>
            </template>
        </Table>
        
        <div class="mt-5 text-right">
            <Pagination/>
        </div>
        <vodal :show="deleteConfirmationModalShown" animation="slideDown" @hide="deleteConfirmationModalShown = false" :height="185">
            <div class="flex flex-col justify-between text-sm">
                <div class="modal-title fez123-border-bottom pb-3 pt-1 font-bold">
                    Confirm
                </div>
                <div class="modal-body py-3">Are you sure you want to delete this record?</div>
                <div class="modal-footer text-right fez123-border-top pt-4 mt-8">
                    <button type="button" class="fez123-button-default py-2 px-5 no-outline rounded-sm text-sm mr-2" @click="deleteConfirmationModalShown = false">
                        No
                    </button>
                    <button type="button" class="fez123-button-primary py-2 px-5 no-outline rounded-sm text-sm">
                        Yes
                    </button>
                </div>
            </div>
        </vodal>
    </ContentContainer>
</template>

<script>
import IconInput from '@/components/Base/IconInput.vue'
import Dropdown from '@/components/Base/Dropdown.vue'
import Pagination from '@/components/Base/Pagination.vue'
import Table from '@/components/Base/Table.vue'
import Vodal from 'vodal'
export default {
    components: {
        IconInput,
        Dropdown,
        Pagination,
        Vodal,
        Table
    },
    created(){
        this.$store.dispatch('getUsers', {
            role: 'students'
        }).then((response) => {
            this.users = response.data.result
        })
    },
    data(){
        return {
            searchKeyword: null,
            dropdownItems: [
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
                    label: '#',
                },
                {
                    name: 'uuid',
                    label: 'Student ID',
                },
                {
                    name: 'full_name',
                    label: 'Full Name',
                },
                {
                    name: 'course',
                    label: 'Course',
                },
                {
                    name: 'department',
                    label: 'Department',
                },
                {
                    slot: 'actions'
                }
            ],
            users: [],
            deleteConfirmationModalShown: false
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        },
        itemClicked(item, user){
            console.log(user)
            switch(item.title){
                case 'Delete':
                    this.deleteConfirmationModalShown = true
                    break;
            }
        }
    }
}
</script>
