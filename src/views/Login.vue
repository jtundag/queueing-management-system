<template>
    <div class="container mx-auto h-full flex justify-center items-center mt-16">
        <div class="w-1/3">
            <h1 class="font-hairline mb-6 text-center primary-text">Login to QMS</h1>
            <Form @submit="login" 
                class="p-6 border-t-12 bg-white mb-6 shadow-lg"
                ref="loginForm">
                <div class="mb-4">
                    <Input label="Username" 
                        name="username" 
                        placeholder="Enter Username"
                        :required="true"
                        v-model="formData.username"/>
                </div>

                <div class="mb-4">
                    <Input label="Password" 
                        name="password" 
                        type="password"
                        placeholder="Enter Password"
                        :required="true"
                        v-model="formData.password"/>
                </div>

                <div class="text-right">
                    <Button type="primary" 
                        text="Login"
                        :submit="true"/>
                </div>
            </Form>
        </div>
        <toast-container></toast-container>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    name: 'login',
    mounted(){
        if(this.$route.query.message){
            this.$vueOnToast.pop('error', 'Login Failed', this.$route.query.message)
        }
    },
    data(){
        return {
            formData: {
                username: null,
                password: null
            }
        }
    },
    computed: {
        ...mapGetters({
            'user': 'user',
            'isPersonnel': 'isPersonnel'
        })
    },
    methods: {
        login(){
            this.$store.dispatch('toggleFullLoader', true)
            this.$refs.loginForm.validate()
                .then((result) => {
                    this.$store.dispatch('toggleFullLoader', false)
                    if(!result) return false
                    this.$store.dispatch('login', this.formData)
                        .then((response) => {
                            if(response.data && response.data.error){
                                this.$vueOnToast.pop('error', 'Login Failed', response.data.error)
                                return false
                            }
                            this.$store.commit('LOGIN_SUCCESS', response)
                            this.$vueOnToast.pop('success', 'Login Success', "Redirecting...")
                            if(this.isPersonnel){
                                this.$store.commit('SERVER_ID', null)
                                return this.$router.replace('/server')
                            }
                            this.$router.replace('/dashboard')
                        })
                        .catch((response) => {
                            this.$store.dispatch('toggleFullLoader', false)
                            this.$vueOnToast.pop('error', 'Login Failed', response.data.error)
                        })
                })
        }
    }
}
</script>
