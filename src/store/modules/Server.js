const state = {
    'queues': [],
    'serverId': localStorage.getItem('server_id'),
    'currentlyServing': null
}
const mutations = {
    QUEUES(state, queues){
        state.queues = queues
    },
    CURRENTLY_SERVING(state, queue){
        state.currentlyServing = queue
    },
    SERVER_ID(state, id){
        state.serverId = id
        if(!id) return localStorage.removeItem('server_id')
        localStorage.setItem('server_id', id)
    }
}
const getters = {
    queues(state){
        return state.queues
    },
    currentlyServing(state){
        return state.currentlyServing
    },
    serverId(){
        return state.serverId
    }
}
const actions = {
    getQueues(context, data = {}) {
        return window.axios.get('/server/queues', { params: {...data, server_id: context.state.serverId} })
                    .then((response) => {
                        context.commit('QUEUES', response.data.result)
                        context.commit('CURRENTLY_SERVING', response.data.currently_serving)
                    })
    },
    serveNext(context, data = {}){
        return window.axios.post('/server/next', {...data, server_id: context.state.serverId})
                    .then((response) => {
                        context.commit('CURRENTLY_SERVING', response.data.currently_serving)
                    })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}