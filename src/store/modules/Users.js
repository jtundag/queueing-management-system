const state = {
    users: []
}
const mutations = {}
const getters = {}
const actions = {
    createUser(context, data){
        return window.axios.post('/users/create', data)
    },
    getUsers(context, data) {
        return window.axios.get('/users', data)
    },
    deleteUser(context, id) {
        return window.axios.delete('/users/delete', { params: { id } })
    },
    findUser(context, id){
        return window.axios.get('/users/find', { params: { id } })
    },
    updateUser(context, data){
        return window.axios.patch('/users/update', data)
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}