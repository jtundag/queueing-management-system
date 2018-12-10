const state = {
    users: []
}
const mutation = {}
const getters = {}
const actions = {
    createUser(context, data){
        return window.axios.post('/users/create', data)
    },
    getUsers(context, data){
        return window.axios.get('/users', data)
    }
}

export default {
    state,
    mutation,
    getters,
    actions
}