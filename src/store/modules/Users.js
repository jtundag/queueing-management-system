const state = {
    users: []
}
const mutation = {}
const getters = {}
const actions = {
    createUser(context, data){
        console.log(data)
        return window.axios.get('/sample')
    }
}

export default {
    state,
    mutation,
    getters,
    actions
}