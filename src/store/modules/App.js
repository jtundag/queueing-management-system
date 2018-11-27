const state = {
    isFullLoading: true,
    navLinks: [
        {
            name: 'dashboard',
            title: 'Dashboard',
            icon: 'fez-application',
            link: '/'
        },
        {
            name: 'users',
            title: 'Users',
            icon: 'fez-team',
            subnav: [
                {
                    name: 'users',
                    title: 'All Users',
                    icon: 'fez-team',
                    link: '/users'
                },
                {
                    name: 'users',
                    title: 'Create New',
                    icon: 'fez-user',
                    link: '/users/create'
                }
            ]
        }, {
            name: 'departments',
            title: 'Departments',
            icon: 'fez-warehouse',
            subnav: [{
                    name: 'departments',
                    title: 'All Departments',
                    icon: 'fez-warehouse',
                    link: '/departments'
                },
                {
                    name: 'departments',
                    title: 'Create New',
                    icon: 'fez-setting_wrench',
                    link: '/departments/create'
                }
            ]
        }, {
            name: 'config',
            title: 'Config',
            icon: 'fez-setting_cog'
        }
    ],
    subnavLinks: null
}
const getters = {
    isFullLoading(state){
        return state.isFullLoading
    },
    navLinks(state){
        return state.navLinks
    },
    subnavLinks(state) {
        return state.subnavLinks
    }
}
const mutations = {
    IS_FULL_LOADING(state, isFullLoading){
        state.isFullLoading = isFullLoading
    },
    SUBNAV_LINKS(state, links){
        state.subnavLinks = links
    }
}
const actions = {
    toggleFullLoader(context, isFullLoading){
        context.commit('IS_FULL_LOADING', isFullLoading)
    },
    showSubnavLinksOf(context, link){
        context.commit('SUBNAV_LINKS', link.subnav)
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}