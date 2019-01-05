const state = {}
const mutations = {}
const getters = {}
const actions = {
    createDepartment(context, data) {
        return window.axios.post('/config/departments/create', data)
    },
    updateDepartment(context, data) {
        return window.axios.patch(`/config/departments/${data.id}/update`, data)
    },
    getDepartments(context, data) {
        return window.axios.get('/config/departments', data)
    },
    deleteDepartment(context, id) {
        return window.axios.delete('/config/departments/delete', {
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