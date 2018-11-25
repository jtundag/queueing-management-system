<template>
    <ContentContainer>
        <div class="text-3xl">Users</div>
        <div class="mt-2">
            <IconInput icon="fez-search" 
            placeholder="Search people..." 
            name="search_field" 
            v-model="searchKeyword"
            @tailing-icon-clicked="clearKeyword"/>
        </div>

        <table class="table-auto mt-5">
            <thead class="fez123-border-bottom">
                <tr>
                    <th class="p-4">ID</th>
                    <th class="p-4">Username</th>
                    <th class="p-4">First Name</th>
                    <th class="p-4">Last Name</th>
                    <th class="p-4">Email</th>
                    <th class="p-4"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>
                            123-A45
                        </strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </ContentContainer>
</template>

<script>
import IconInput from '@/components/Base/IconInput.vue'
export default {
    components: {
        IconInput
    },
    data(){
        return {
            searchKeyword: null
        }
    },
    methods: {
        clearKeyword(){
            this.searchKeyword = null
        }
    }
}
</script>
