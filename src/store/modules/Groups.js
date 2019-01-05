const state = {
    users: []
}
const mutations = {}
const getters = {}
const actions = {
    createGroup(context, data) {
        return window.axios.post('/config/groups/create', data)
    },
    updateGroup(context, data) {
        return window.axios.patch(`/config/groups/${data.id}/update`, data)
    },
    getGroups(context, data) {
        return window.axios.get('/config/groups', data)
    },
    deleteGroup(context, id) {
        return window.axios.delete('/config/groups/delete', {
            params: {
                id
            }
        })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}