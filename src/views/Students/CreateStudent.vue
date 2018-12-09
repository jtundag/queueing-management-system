<template>
    <ContentContainer title="Create Student" class-names="relative pb-0">
        <Form @submit="create">
            <div class="text-lg mb-5 mt-4">
                Account Information
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <Input label="Username" 
                        name="username" 
                        placeholder="Username"
                        :required="true"
                        v-model="formData.username"/>
                </div>
                <div class="flex-grow px-2">
                    <Input label="Password" 
                        name="password" 
                        placeholder="Password"
                        type="password"
                        :required="true"
                        v-model="formData.password"/>
                </div>
            </div>
            <div class="text-lg mb-5 mt-4">
                Student Information
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <Input label="Student ID" 
                        name="student_id" 
                        placeholder="Enter Student ID"
                        :required="true"
                        v-model="formData.uuid"/>
                </div>
                <div class="flex-grow px-2">
                    <Input label="Course" 
                        name="course" 
                        placeholder="Enter Course"
                        :required="true"
                        v-model="formData.course"/>
                </div>
                <div class="flex-grow px-2">
                    <Input label="Department" 
                        name="department" 
                        placeholder="Enter Department"
                        :required="true"
                        v-model="formData.department"/>
                </div>
            </div>
            <div class="text-lg mb-5 mt-4">
                Personal Information
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
                        :required="true"
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
            <div class="flex mb-2">
                <div class="px-2">
                    <Radio :options="[{ label: 'Male', value: 'male' }, { label: 'Female', value: 'female' }]"
                        :required="true"
                        label="Gender"
                        name="gender"
                        v-model="formData.gender"
                        @change="formData.gender = $event"/>
                </div>
            </div>
            <div class="text-lg mb-5 mt-4">
                Contact Information
            </div>
            <div class="flex mb-2">
                <div class="px-2">
                    <Input label="Mobile No." 
                        name="mobile_no" 
                        placeholder="Enter Mobile No."
                        :required="true"
                        v-model="formData.mobile_no"/>
                </div>
                <div class="px-2">
                    <Input label="Phone No." 
                        name="phone_no" 
                        placeholder="Enter Phone Number"
                        :required="true"
                        v-model="formData.phone_no"/>
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
import { Form, Input, Radio } from '@/components/Base/Form'

export default {
    components: {
        Form,
        Input,
        Radio
    },
    data(){
        return {
            formData: {
                username: null,
                password: null,
                uuid: null,
                course: null,
                department: null,
                first_name: null,
                middle_name: null,
                last_name: null,
                gender: 'male',
                mobile_no: null,
                phone_no: null,
                role: 'student'
            }
        }
    },
    methods: {
        create(){
            this.$store.dispatch('toggleFullLoader', true)
            this.$store.dispatch('createUser', this.formData)
                .then((response) => {
                    console.log(response)
                    this.$store.dispatch('toggleFullLoader', false)
                    this.$router.replace('/users/students')
                })
        }
    }
}
</script>
