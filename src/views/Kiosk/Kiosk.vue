<template>
    <ContentContainer title="Kiosk">
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
            <div class="mt-5 text-right">
                <button type="submit" 
                    class="py-2 px-5 no-outline rounded-sm text-sm mr-2 fez123-button-primary">
                    Submit
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
            this.$refs.prioNumModal.show()
            this.$store.dispatch('toggleFullLoader', true)
            let response = await this.$store.dispatch('pushQueue', {
                ...this.formData,
                department_id: this.formData.department.id,
                service_id: this.formData.service.id
            })
            this.$store.dispatch('toggleFullLoader', false)
            this.priorityNumber = response.data.priority_number
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