const state = {}
const mutation = {}
const getters = {}
const actions = {
    createCourse(context, data) {
        return window.axios.post('/config/courses/create', data)
    },
    updateCourse(context, data) {
        return window.axios.patch(`/config/courses/${data.id}/update`, data)
    },
    getCourses(context, data) {
        return window.axios.get('/config/courses', data)
    },
    deleteCourse(context, id) {
        return window.axios.delete('/config/courses/delete', {
            params: {
                id
            }
        })
    }
}

export default {
    state,
    mutation,
    getters,
    actions
}