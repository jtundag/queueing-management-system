const state = {
    user: null,
    accessToken: null
}
const mutations = {
    LOGIN_SUCCESS(state, res){
        state.user = res.data.user
        state.accessToken = res.data.access_token
        localStorage.setItem('jwt-auth-token', res.data.access_token)
    }
}
const getters = {
    isLoggedIn(){
        return localStorage.getItem('jwt-auth-token')
    },
    user(state){
        return state.user
    },
    accessToken(state){
        return state.accessToken
    }
}
const actions = {
    login(context, data){
        return window.axios.post('/auth/login', data)
    },
    logout(){
        return localStorage.removeItem('jwt-auth-token')
    },
    checkUser(){
        return window.axios.post('/auth/me')
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}