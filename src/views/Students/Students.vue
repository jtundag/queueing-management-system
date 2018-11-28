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
    </ContentContainer>
</template>

<script>
import IconInput from '@/components/Base/IconInput.vue'
import Dropdown from '@/components/Base/Dropdown.vue'
import Pagination from '@/components/Base/Pagination.vue'
export default {
    components: {
        IconInput,
        Dropdown,
        Pagination
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
            ]
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        },
        itemClicked(item, user){
            console.log(item, user)
        }
    }
}
</script>
