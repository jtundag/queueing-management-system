<template>
    <ContentContainer title="Students">
        <IconInput icon="fez-search" 
        placeholder="Search students..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>

        <table class="table-auto mt-5 w-full text-sm">
            <thead class="fez123-border-bottom">
                <tr>
                    <th class="px-4 py-5 font-normal text-left">#</th>
                    <th class="px-4 py-5 font-normal text-left">Student ID No.</th>
                    <th class="px-4 py-5 font-normal text-left">First Name</th>
                    <th class="px-4 py-5 font-normal text-left">Last Name</th>
                    <th class="px-4 py-5 font-normal text-left">Email</th>
                    <th class="px-4 py-5 font-normal"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="fez123-border-bottom" 
                    v-for="(user, index) in users"
                    :key="index">
                    <td class="px-4 py-5">
                        {{ user.id }}
                    </td>
                    <td class="px-4 py-5">
                        {{ user.username }}
                    </td>
                    <td class="px-4 py-5">
                        {{ user.first_name }}
                    </td>
                    <td class="px-4 py-5">
                        {{ user.last_name }}
                    </td>
                    <td class="px-4 py-5">
                        {{ user.email }}
                    </td>
                    <td>
                        <Dropdown :items="dropdownItems"
                            @item-click="itemClicked($event, user)"/>
                    </td>
                </tr>
            </tbody>
        </table>
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
import Vodal from 'vodal'
export default {
    components: {
        IconInput,
        Dropdown,
        Pagination,
        Vodal
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
            users: [
                {
                    id: 1,
                    username: '2014-F0089',
                    first_name: 'Test',
                    last_name: 'Last',
                    email: 'test.last@gmail.com'
                },
                {
                    id: 1,
                    username: '2014-F0089',
                    first_name: 'Test',
                    last_name: 'Last',
                    email: 'test.last@gmail.com'
                },
                {
                    id: 1,
                    username: '2014-F0089',
                    first_name: 'Test',
                    last_name: 'Last',
                    email: 'test.last@gmail.com'
                },
                {
                    id: 1,
                    username: '2014-F0089',
                    first_name: 'Test',
                    last_name: 'Last',
                    email: 'test.last@gmail.com'
                }
            ],
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
