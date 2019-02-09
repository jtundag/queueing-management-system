<template>
    <ContentContainer title="Kiosk" class="relative pb-32">
        <Form @submit="pushQueue" ref="kioskQueue" class="mt-16 mx-32">
            <Input label="ID Number" 
                    name="idnum" 
                    placeholder="Enter ID Number"
                    :required="true"
                    v-model="formData.uuid"/>
            <div class="mt-4">
                <InputSuggestions label="Department" 
                    name="department" 
                    placeholder="Enter Department"
                    :text="formData.department.name"
                    v-model="formData.department"
                    :validation-rules="`required`"
                    api-url="/config/departments">
                    <div slot-scope="props">
                        {{ props.suggestion.name }}
                    </div>
                </InputSuggestions>
            </div>
            <div class="mt-4">
                <InputSuggestions v-if="formData.department.name"
                    label="Service" 
                    name="service" 
                    placeholder="Enter Service"
                    :text="formData.service.name"
                    v-model="formData.service"
                    :validation-rules="`required`"
                    :api-url="`/config/services/for-department?department_id=${formData.department.id}`">
                    <div slot-scope="props">
                        {{ props.suggestion.name }}
                    </div>
                </InputSuggestions>
            </div>
            <div class="w-full fez123-border-top px-10 py-4 text-right bg-white mt-8 fixed pin-b pin-l">
                <button class="fez123-button-primary px-4 py-2 text-center leading-normal rounded-sm no-outline">
                    {{ $route.params.id ? 'Save' : 'Create' }}
                </button>
            </div>
        </Form>

        <VodalExt ref="prioNumModal" 
            title="Success" 
            :height="155"
            @hide="clearForm">
            <template slot="body">
                <div class="text-center">
                    Your Priority Number is:
                    <div class="text-5xl mt-5">
                        {{ priorityNumber }}
                    </div>
                </div>
            </template>
        </VodalExt>
        <toast-container/>
    </ContentContainer>
</template>

<script>
import VodalExt from '@/components/Base/Vodal/VodalExt.vue'

export default {
    components: {
        VodalExt
    },
    data(){
        return {
            formData: {
                uuid: null,
                department: {name: null},
                service: {name: null}
            },
            priorityNumber: null
        }
    },
    methods: {
        async pushQueue(){
            this.$store.dispatch('toggleFullLoader', true)
            this.$refs.kioskQueue.validate()
                .then(async (result) => {
                    this.$store.dispatch('toggleFullLoader', false)
                    if(!result) return false
                    let response = await this.$store.dispatch('pushQueue', {
                        ...this.formData,
                        department_id: this.formData.department.id,
                        service_id: this.formData.service.id
                    })
                    this.$store.dispatch('toggleFullLoader', false)
                    if(!response.data.status){
                        this.$vueOnToast.pop('error', 'Failed', response.data.message)
                        return false
                    }
                    this.$refs.prioNumModal.show()
                    this.priorityNumber = response.data.priority_number
                })
        },
        clearForm(){
            this.formData = {
                uuid: null,
                department: {name: null},
                service: {name: null}
            }
            this.priorityNumber = null
        }
    }
}
</script>