<template>
    <ContentContainer title="Create Server" class-names="relative pb-0">
        <Form @submit="save" ref="createForm">
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <Input label="Server Name" 
                        name="server_name" 
                        placeholder="Enter Server Name"
                        :validation-rules="`required`"
                        v-model="formData.name"/>
                </div>
                <div class="flex-grow px-2">
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
                </div>
                <div class="flex-grow px-2">
                    <Input label="Numbering Prefix" 
                        name="number_prefix" 
                        placeholder="Enter Numbering Prefix (IT, EMT, etc...)"
                        :validation-rules="`required`"
                        v-model="formData.prefix"/>
                </div>
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <label class="pl-1 block text-sm mb-2">
                        Server Personnels
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <SelectList :list="availablePersonnels" 
                        max-height="450px"
                        filter-with="name"
                        placeholder="Search personnels..."
                        v-model="formData.personnels">
                        <div slot-scope="props">
                            <div class="font-bold">
                                {{ props.item.first_name }}
                                {{ props.item.last_name }}
                            </div>
                            <div class="text-xs block">
                                {{ props.item.department.name }}
                            </div>
                            <div class="text-xs block">
                                {{ props.item.position }}
                            </div>
                        </div>
                    </SelectList>
                </div>
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <label class="pl-1 block text-sm mb-2">
                        Services
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <SelectList :list="availableServices" 
                        max-height="450px"
                        filter-with="name"
                        placeholder="Search services..."
                        v-model="formData.services">
                        <div slot-scope="props">
                            <div class="font-bold">
                                {{ props.item.name }}
                            </div>
                            <div class="duration" v-if="formData.services[_indexOf(props.item)]">
                                <span class="text-xs">
                                    Duration in minute(s)
                                </span>
                                <input type="number" 
                                    class="fez123-border no-outline text-xs w-16 p-2 text-center"
                                    v-model="formData.services[_indexOf(props.item)].pivot.duration"
                                    @click.stop>
                            </div>
                        </div>
                    </SelectList>
                </div>
            </div>
            <div class="w-full fez123-border-top px-10 py-4 text-right bg-white mt-8">
                <button type="reset" class="mr-3 px-4 py-2 text-center leading-normal rounded-sm hover:bg-grey-lighter no-outline">
                    Reset
                </button>
                <button class="fez123-button-primary px-4 py-2 text-center leading-normal rounded-sm no-outline">
                    Create
                </button>
            </div>
        </Form>
    </ContentContainer>
</template>

<script>
import SelectList from '@/components/Base/SelectList.vue'
export default {
    components: {
        SelectList
    },
    created(){
        this.$store.dispatch('toggleFullLoader', true)
        this.$store.dispatch('getServices')
            .then((response) => {
                this.$store.dispatch('toggleFullLoader', false)
                window._.map(response.data.result, (service) => service.pivot = { duration: 0 })
                this.availableServices = response.data.result
                if(this.$route.params.id){
                    this.$store.dispatch('toggleFullLoader', true)
                    this.$store.dispatch('findServer', this.$route.params.id)
                        .then(({ data }) => {
                            this.$store.dispatch('toggleFullLoader', false)

                            if(!data.status){
                                return false
                            }

                            let server = data.server

                            this.formData = {
                                name: server.name,
                                prefix: server.prefix,
                                department: server.department.name,
                                department_id: server.department.id,
                                personnels: server.personnels,
                                services: server.services
                            }
                        })
                }
            })
            
    },
    data(){
        return {
            availablePersonnels: [],
            availableServices: [],
            formData: {
                name: null,
                prefix: null,
                department: null,
                department_id: null,
                personnels: [],
                services: []
            }
        }
    },
    methods: {
        _indexOf(item){
            return window._.findIndex(this.formData.services, { id: item.id })
        },
        selectDepartment(department){
            this.$store.dispatch('toggleFullLoader', true)
            this.formData.department_id = department.id
            this.$store.dispatch('getUsers', { params: { role: 'personnel', department_id: department.id } })
                .then((response) => {
                    this.$store.dispatch('toggleFullLoader', false)
                    this.availablePersonnels = response.data.result
                })
        },
        save(){
            this.$store.dispatch('toggleFullLoader', true)
            this.$refs.createForm.validate()
                .then((result) => {
                    this.$store.dispatch('toggleFullLoader', false)
                    if(!result) return false
                    if(this.$route.params.id){
                        if(!this.formData.password) delete this.formData.password
                        this.$store.dispatch('updateServer', {
                            ...this.formData,
                            id: this.$route.params.id
                        })
                        .then(() => {
                            this.$router.replace('/servers')
                        })
                        return true
                    }
                    
                    this.$store.dispatch('createServer', this.formData)
                        .then(() => {
                            this.$router.replace('/servers')
                        })
                })
        }
    }
}
</script>
