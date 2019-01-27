<template>
    <ContentContainer title="Create Student" class-names="relative pb-32 mb-24">
        <Form @submit="save" ref="createForm">
            <div class="text-lg mb-5 mt-4 fez123-border-bottom pb-3 px-2">
                Account Information
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <Input label="Username" 
                        name="username" 
                        placeholder="Username"
                        :validation-rules="`required`"
                        v-model="formData.username"/>
                </div>
                <div class="flex-grow px-2">
                    <Input label="Password" 
                        name="password" 
                        placeholder="Password"
                        type="password"
                        :validation-rules="!this.$route.params.id ? `required` : ''"
                        v-model="formData.password"/>
                </div>
            </div>
            <div class="text-lg mb-5 mt-4 fez123-border-bottom pb-3 px-2">
                Student Information
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <Input label="Student ID" 
                        name="student_id" 
                        placeholder="Enter Student ID"
                        :validation-rules="`required`"
                        v-model="formData.uuid"/>
                </div>
                <div class="flex-grow px-2">
                    <InputSuggestions label="Department" 
                        name="department" 
                        placeholder="Enter Department"
                        :text="formData.department.name"
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
            <div class="text-lg mb-5 mt-4 fez123-border-bottom pb-3 px-2">
                Personal Information
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <Input label="First Name" 
                        name="first_name" 
                        placeholder="Enter First Name"
                        :validation-rules="`required`"
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
                        :validation-rules="`required`"
                        v-model="formData.last_name"/>
                </div>
            </div>
            <div class="flex mb-2">
                <div class="px-2">
                    <Radio :options="[{ label: 'Male', value: 'male' }, { label: 'Female', value: 'female' }]"
                        :validation-rules="`required`"
                        label="Gender"
                        name="gender"
                        v-model="formData.gender"
                        @change="formData.gender = $event"/>
                </div>
            </div>
            <div class="text-lg mb-5 mt-4 fez123-border-bottom pb-3 px-2">
                Contact Information
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <Input label="Mobile No." 
                        name="mobile_no" 
                        placeholder="Enter Mobile No."
                        v-model="formData.mobile_no"/>
                </div>
                <div class="flex-grow px-2">
                    <Input label="Phone No." 
                        name="phone_no" 
                        placeholder="Enter Phone Number"
                        v-model="formData.phone_no"/>
                </div>
                <div class="flex-grow px-2">
                    <Input label="Email Address" 
                        name="email" 
                        placeholder="Enter Email Address"
                        validation-rules="required|email"
                        v-model="formData.email"/>
                </div>
            </div>
            <div class="w-full fez123-border-top px-10 py-4 text-right bg-white mt-8 fixed pin-b pin-l">
                <button type="reset" class="mr-3 px-4 py-2 text-center leading-normal rounded-sm hover:bg-grey-lighter no-outline">
                    Reset
                </button>
                <button class="fez123-button-primary px-4 py-2 text-center leading-normal rounded-sm no-outline">
                    {{ $route.params.id ? 'Save' : 'Create' }}
                </button>
            </div>
        </Form>
    </ContentContainer>
</template>

<script>
export default {
    data(){
        return {
            formData: {
                username: null,
                password: null,
                uuid: null,
                department: {name: null},
                department_id: null,
                first_name: null,
                middle_name: null,
                last_name: null,
                gender: null,
                mobile_no: null,
                phone_no: null,
                email: null,
                role: 'student'
            },
            departments: []
        }
    },
    created(){
        if(this.$route.params.id){
            this.$store.dispatch('toggleFullLoader', true)
            this.$store.dispatch('findUser', this.$route.params.id)
                .then(({ data }) => {
                    this.$store.dispatch('toggleFullLoader', false)

                    if(!data.status){
                        return false
                    }

                    let user = data.user

                    this.formData = {
                        id: this.$route.params.id,
                        username: user.username,
                        password: null,
                        uuid: user.uuid,
                        department: user.department,
                        department_id: user.department_id,
                        first_name: user.first_name,
                        middle_name: user.middle_name,
                        last_name: user.last_name,
                        gender: user.gender,
                        mobile_no: user.mobile_no,
                        phone_no: user.phone_no,
                        email: user.email,
                        role: 'student'
                    }
                })
        }
    },
    methods: {
        save(){
            this.$store.dispatch('toggleFullLoader', true)
            this.$refs.createForm.validate()
                .then((result) => {
                    this.$store.dispatch('toggleFullLoader', false)
                    if(!result) return false
                    if(this.$route.params.id){
                        if(!this.formData.password) delete this.formData.password
                        this.$store.dispatch('updateUser', this.formData)
                        .then(() => {
                            this.$router.replace('/users/students')
                        })
                        return true
                    }
                    
                    this.$store.dispatch('createUser', this.formData)
                        .then(() => {
                            this.$router.replace('/users/students')
                        })
                })
        },
        selectDepartment(department){
            this.formData.department_id = department.id
        }
    }
}
</script>
