const state = {
    users: []
}
const mutation = {}
const getters = {}
const actions = {
    createUser(context, data){
        console.log(process.env.API_BASE_URL)
        return axios.get('/sample')
    }
}

export default {
    state,
    mutation,
    getters,
    actions
}