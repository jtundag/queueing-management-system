<template>
    <ContentContainer title="Servers">
        <IconInput icon="fez-search" 
        placeholder="Search server..." 
        name="search_field" 
        v-model="searchKeyword"
        @tailing-icon-clicked="clearKeyword"/>

        <table class="table-auto mt-5 w-full">
            <thead class="fez123-border-bottom">
                <tr>
                    <th class="px-4 py-5 font-normal text-left">#</th>
                    <th class="px-4 py-5 font-normal text-left">Server ID</th>
                    <th class="px-4 py-5 font-normal text-left">Derpartment</th>
                    <th class="px-4 py-5 font-normal"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="fez123-border-bottom" 
                    v-for="(server, index) in servers"
                    :key="index">
                    <td class="px-4 py-5">
                        {{ server.id }}
                    </td>
                    <td class="px-4 py-5">
                        {{ server.server_id }}
                    </td>
                    <td class="px-4 py-5">
                        {{ server.department.name }}
                    </td>
                    <td>
                        <Dropdown :items="dropdownItems"
                            @item-click="itemClicked($event, server)"/>
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
                    title: 'Reports',
                    icon: 'fez-file'
                },
                {
                    title: 'Delete',
                    icon: 'fez-close'
                }
            ],
            servers: [
                {
                    id: 1,
                    server_id: '2014-F0089',
                    department: {
                        id: 1,
                        name: 'IT'
                    }
                },
                {
                    id: 2,
                    server_id: '2014-F0089',
                    department: {
                        id: 1,
                        name: 'IT'
                    }
                }
            ]
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        },
        itemClicked(item, server){
            console.log(item, server)
        }
    }
}
</script>
