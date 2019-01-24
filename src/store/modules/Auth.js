const state = {
    user: localStorage.getItem('jwt-auth-user') ? JSON.parse(localStorage.getItem('jwt-auth-user')) : null,
    accessToken: localStorage.getItem('jwt-auth-token')
}
const mutations = {
    LOGIN_SUCCESS(state, { data: {user, access_token} }){
        state.user = user
        state.accessToken = access_token
        localStorage.setItem('jwt-auth-user', JSON.stringify(user))
        localStorage.setItem('jwt-auth-token', access_token)
    },
    LOGOUT_SUCCESS(state){
        state.user = null
        state.accessToken = null
        localStorage.removeItem('jwt-auth-user')
        localStorage.removeItem('jwt-auth-token')
    }
}
const getters = {
    isLoggedIn(state){
        return (state.user && state.accessToken) ? true : false
    },
    user(state){
        return state.user
    },
    accessToken(state){
        return state.accessToken
    },
    isPersonnel(state){
        if(!state.user) return false
        return window._.findIndex(state.user.roles, { name: 'personnel' }) !== -1
    },
    isAdmin(state) {
        if (!state.user) return false
        return window._.findIndex(state.user.roles, {
            name: 'admin'
        }) !== -1
    }
}
const actions = {
    login(context, data){
        return window.axios.post('/auth/login', data)
    },
    logout(context){
        context.commit('LOGOUT_SUCCESS')
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