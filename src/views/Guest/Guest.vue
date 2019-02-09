<template>
    <ContentContainer title="Guest" class-names="relative pb-32">
        <Form @submit="pushQueue" ref="guestQueue" class="mt-16 mx-32">
            <div class="text-lg mb-5 mt-4">
                Guest Information
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <Input label="First Name" 
                        name="first_name" 
                        placeholder="Enter First Name"
                        :required="true"
                        v-model="formData.first_name"/>
                </div>
                <div class="flex-grow px-2">
                    <Input label="Middle Name (Optional)" 
                        name="middle_name" 
                        placeholder="Enter Middle Name (Optional)"
                        v-model="formData.middle_name"/>
                </div>
                <div class="flex-grow px-2">
                    <Input label="Last Name" 
                        name="last_name" 
                        placeholder="Enter Last Name"
                        :required="true"
                        v-model="formData.last_name"/>
                </div>
            </div>
            <div class="text-lg mb-5 mt-4">
                Contact Information
            </div>
            <div class="flex px-2">
                <Input label="Mobile No." 
                    name="mobile_no" 
                    placeholder="Enter Mobile No."
                    v-model="formData.mobile_no"/>
            </div>
            <div class="text-lg mb-5 mt-4 font-bold fez123-border-top pt-4">
                <span class="ribbon-title">
                    <span class="text">GET PRIORITY NUMBER</span>
                </span>
            </div>
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
                <button type="reset" class="mr-3 px-4 py-2 text-center leading-normal rounded-sm hover:bg-grey-lighter no-outline">
                    Reset
                </button>
                <button class="fez123-button-primary px-4 py-2 text-center leading-normal rounded-sm no-outline" @click="pushQueue">
                    Create
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
                first_name: null,
                middle_name: null,
                last_name: null,
                mobile_no: null,
                department: {name: null},
                service: {name: null}
            },
            priorityNumber: null
        }
    },
    methods: {
        async pushQueue(){
            this.$store.dispatch('toggleFullLoader', true)
            this.$refs.guestQueue.validate()
                .then(async (result) => {
                    this.$store.dispatch('toggleFullLoader', false)
                    if(!result) return false
                    let response = await this.$store.dispatch('pushQueue', {
                        ...this.formData,
                        guest: true,
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
                first_name: null,
                middle_name: null,
                last_name: null,
                mobile_no: null,
                department: {name: null},
                service: {name: null}
            }
            this.priorityNumber = null
        }
    }
}
</script>

