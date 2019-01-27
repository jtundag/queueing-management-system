<template>
    <ContentContainer title="Create Flow" class-names="relative pb-0">
        <Form @submit="save" ref="createForm">
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <Input label="Flow Name" 
                        name="flow_name" 
                        placeholder="Enter Flow Name"
                        :validation-rules="`required`"
                        v-model="formData.name"/>
                </div>
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <VueTagsInput
                        v-model="tag"
                        :tags="formData.tags"
                        :autocomplete-items="autocompleteItems"
                        @tags-changed="newTags => formData.tags = newTags"/>
                </div>
            </div>  
            <div>
                <div class="text-lg mb-5 mt-4 fez123-border-bottom pb-3 px-2">
                    Steps
                </div>
                <draggable v-model="formData.steps" 
                @start="drag=true" 
                @end="drag=false"
                class="inline-block">
                    <transition-group>
                        <div class="cursor-pointer bg-grey-lighter inline-block w-32 h-32 align-top mr-4 relative hover:bg-grey-light" 
                        v-for="(step, index) in formData.steps"
                        :key="index"
                        title="Click to Edit" 
                        v-tippy="{arrow: true}"
                        @click="showStepInfo(step, index)">
                            <span class="absolute pin flex items-center justify-center text-center">
                                {{ step.name }}
                            </span>
                        </div>
                    </transition-group>
                </draggable>
                <div class="cursor-pointer bg-grey-lighter inline-block hover:bg-grey-light w-32 h-32 align-top relative" title="Add a Step" v-tippy="{arrow: true}" @click="showStepInfo({ name: null, department: {name: null}, service: {name: null} })">
                    <span class="fez-plus text-5xl absolute pin flex items-center justify-center text-center"></span>
                </div>
            </div>
            <div class="w-full fez123-border-top px-10 py-4 text-right bg-white mt-8 fixed pin-b pin-l">
                <button type="reset" class="mr-3 px-4 py-2 text-center leading-normal rounded-sm hover:bg-grey-lighter no-outline">
                    Reset
                </button>
                <Button type="primary" 
                    :text="$route.params.id ? 'Save' : 'Create'"
                    submit/>
            </div>
        </Form>

        <VodalExt ref="stepInfo" 
            title="Step Info"
            :width="500"
            :height="210">
            <template slot="body" v-if="activeStep">
                <Input label="Step Name" 
                        name="stepName" 
                        placeholder="Enter Step Name"
                        :required="true"
                        v-model="activeStep.name"/>

                <InputSuggestions label="Department" 
                    name="department" 
                    placeholder="Enter Department"
                    :text="activeStep.department.name"
                    v-model="activeStep.department"
                    :validation-rules="`required`"
                    api-url="/config/departments">
                    <div slot-scope="props">
                        {{ props.suggestion.name }}
                    </div>
                </InputSuggestions>
                <InputSuggestions v-if="activeStep.department.name"
                    label="Service" 
                    name="service" 
                    placeholder="Enter Service"
                    :text="activeStep.service.name"
                    v-model="activeStep.service"
                    :validation-rules="`required`"
                    :api-url="`/config/services/for-department?department_id=${activeStep.department.id}`">
                    <div slot-scope="props">
                        {{ props.suggestion.name }}
                    </div>
                </InputSuggestions>
            </template>
            <template slot="footer">
                <Button type="default" 
                    text="Delete"
                    v-if="activeStepIndex !== -1"
                    @click="deleteStep"/>
                <Button type="primary" 
                    text="Save"
                    @click="saveStepInfo"/>
            </template>
        </VodalExt>
    </ContentContainer>
</template>

<script>
import VodalExt from '@/components/Base/Vodal/VodalExt.vue'
import draggable from 'vuedraggable'
import VueTagsInput from '@johmun/vue-tags-input';

export default {
    components: {
        VodalExt,
        draggable,
        VueTagsInput
    },
    async created(){
        this.$store.dispatch('toggleFullLoader', true)
        let response = await this.$store.dispatch('getTags')
        this.availableTags = response.data.result
    
        response = await this.$store.dispatch('getDepartments')
        this.$store.dispatch('toggleFullLoader', false)
        this.availableDepartments = response.data.result
        if(this.$route.params.id){
            this.$store.dispatch('toggleFullLoader', true)
            let { data } = await this.$store.dispatch('findPredefinedFlow', this.$route.params.id)
            this.$store.dispatch('toggleFullLoader', false)
            if(!data.status){
                return false
            }

            let flow = data.flow
            this.formData = {
                name: flow.name,
                steps: flow.steps,
                tags: flow.tags
            }
        }
            
    },
    data(){
        return {
            availableDepartments: [],
            formData: {
                name: null,
                steps: [],
                tags: []
            },
            tag: "",
            activeStep: null,
            activeStepIndex: -1,
            drag: false,
            availableTags: []
        }
    },
    methods: {
        deleteStep(){
            this.formData.steps.splice(this.activeStepIndex, 1)
            this.hideStepInfoModal()
        },
        showStepInfo(step, index = -1){
            this.$refs.stepInfo.show()
            this.activeStepIndex = index
            this.activeStep = step
        },
        hideStepInfoModal(){
            this.activeStep = null
            this.activeStepIndex = -1
            this.$refs.stepInfo.hide()
        },
        saveStepInfo(){
            if(this.activeStepIndex === -1){
                this.formData.steps.push(this.activeStep)
                this.hideStepInfoModal()
                return
            }
            this.formData.steps[this.activeStepIndex] = this.activeStep
            this.hideStepInfoModal()
        },
        save(){
            this.$store.dispatch('toggleFullLoader', true)
            this.$refs.createForm.validate()
                .then((result) => {
                    if(!result) return false
                    if(this.$route.params.id){
                        if(!this.formData.password) delete this.formData.password
                        this.$store.dispatch('updatePredefinedFlow', {
                            ...this.formData,
                            id: this.$route.params.id
                        })
                        .then(() => {
                            this.$store.dispatch('toggleFullLoader', false)
                            this.$router.replace('/config/predefined-flows')
                        })
                        return true
                    }
                    
                    this.$store.dispatch('createPredefinedFlow', this.formData)
                        .then(() => {
                            this.$store.dispatch('toggleFullLoader', false)
                            this.$router.replace('/config/predefined-flows')
                        })
                })
        }
    },
    computed: {
        autocompleteItems(){
            return this.availableTags.filter(i => i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1)
        }
    }
}
</script>
