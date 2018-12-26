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
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <Input label="Arrival Rate" 
                        name="arrival_rate" 
                        placeholder="Enter Arrival Rate"
                        :validation-rules="`required`"
                        v-model="formData.arrival_rate"/>
                </div>
                <div class="flex-grow px-2">
                    <Input label="Service Rate" 
                        name="service_rate" 
                        placeholder="Enter Service Rate"
                        :validation-rules="`required`"
                        v-model="formData.service_rate"/>
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
                                arrival_rate: server.arrival_rate,
                                service_rate: server.service_rate,
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
                arrival_rate: null,
                service_rate: null,
                department: null,
                department_id: null,
                personnels: [],
                services: []
            }
        }
    },
    methods: {
        selectDepartment(department){
            this.$store.dispatch('toggleFullLoader', true)
            this.formData.department_id = department.id
            this.$store.dispatch('getUsers', { params: { role: 'personnel' } })
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
                        this.$store.dispatch('updateServer', this.formData)
                        .then((response) => {
                            this.$router.replace('/servers')
                        })
                        return true
                    }
                    
                    this.$store.dispatch('createServer', this.formData)
                        .then((response) => {
                            this.$router.replace('/servers')
                        })
                })
        }
    }
}
</script>
