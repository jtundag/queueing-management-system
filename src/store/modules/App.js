const state = {
    isFullLoading: false,
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
            subnav: {
                "Student": [
                    {
                        name: 'users',
                        title: 'All Students',
                        icon: 'fez-team',
                        link: '/users/students/'
                    }, {
                        name: 'users',
                        title: 'Create Student',
                        icon: 'fez-user',
                        link: '/users/students/create'
                    }
                ],
                "Personnel": [
                    {
                        name: 'users',
                        title: 'All Personnels',
                        icon: 'fez-team',
                        link: '/users/personnels/'
                    }, {
                        name: 'users',
                        title: 'Create Personnel',
                        icon: 'fez-user',
                        link: '/users/personnels/create'
                    }
                ]
            }
        }, {
            name: 'servers',
            title: 'Servers',
            icon: 'fez-desktop',
            subnav: {
                "Servers": [{
                    name: 'servers',
                    title: 'All Servers',
                    icon: 'fez-desktop',
                    link: '/servers/'
                }, {
                    name: 'servers',
                    title: 'Create Server',
                    icon: 'fez-add-to-collection',
                    link: '/servers/create'
                }]
            }
        }, {
            name: 'config',
            title: 'Config',
            icon: 'fez-setting_cog',
            subnav: {
                "Config": [{
                    name: 'config',
                    title: 'General',
                    icon: 'fez-desktop',
                    link: '/config/'
                }, {
                    name: 'config',
                    title: 'Services',
                    icon: 'fez-add-to-collection',
                    link: '/config/services'
                }, {
                    name: 'config',
                    title: 'Groups',
                    icon: 'fez-warehouse',
                    link: '/config/groups'
                }, {
                    name: 'config',
                    title: 'Departments',
                    icon: 'fez-flag',
                    link: '/config/departments'
                }, {
                    name: 'config',
                    title: 'Predefined Flows',
                    icon: 'fez-flag',
                    link: '/config/predefined-flows'
                }]
            }
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