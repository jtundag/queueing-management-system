import Vue from 'vue'
import store from '@/store'
import Router from 'vue-router'
import Home from '@/views/Home.vue'
import Login from '@/views/Login.vue'
import Middlewares from './middlewares'

import NestedRouteView from '@/views/NestedRouteView.vue'

import Students from '@/views/Students/Students.vue'
import StudentForm from '@/views/Students/StudentForm.vue'
import Personnels from '@/views/Personnels/Personnels.vue'
import PersonnelForm from '@/views/Personnels/PersonnelForm.vue'

import Servers from '@/views/Servers/Servers.vue'
import ServerForm from '@/views/Servers/ServerForm.vue'

import ConfigGeneral from '@/views/Config/General.vue'
import ConfigServices from '@/views/Config/Services.vue'
import ConfigGroups from '@/views/Config/Groups.vue'
import ConfigDepartments from '@/views/Config/Departments.vue'
import ConfigPredefinedFlows from '@/views/Config/PredefinedFlows.vue'
import ConfigPredefinedFlowForm from '@/views/Config/PredefinedFlowForm.vue'

import Guest from '@/views/Guest/Guest.vue'
import Kiosk from '@/views/Kiosk/Kiosk.vue'
import Server from '@/views/Server/Server.vue'

Vue.use(Router)

const router = new Router({
	mode: 'history',
	routes: [{
		path: '/login',
		component: Login,
		beforeEnter: Middlewares.userNotAuth,
		meta: {
			title: 'Login'
		}
	}, {
		path: '/',
		alias: '/dashboard',
		component: Home,
		beforeEnter: Middlewares.userAuth,
		meta: {
			title: 'Dashboard'
		}
	}, {
		path: '/users',
		component: NestedRouteView,
		beforeEnter: Middlewares.userAuth,
		children: [{
				path: '/users/students',
				component: Students,
				meta: {
					title: 'Students'
				}
			},
			{
				path: '/users/students/create',
				component: StudentForm,
				meta: {
					title: 'Create Student'
				}
			}, {
				path: '/users/students/:id/edit',
				component: StudentForm,
				meta: {
					title: 'Edit Student'
				}
			},
			{
				path: '/users/personnels',
				component: Personnels,
				meta: {
					title: 'Personnels'
				}
			}, {
				path: '/users/personnels/create',
				component: PersonnelForm,
				meta: {
					title: 'Create Personnel'
				}
			}, {
				path: '/users/personnels/:id/edit',
				component: PersonnelForm,
				meta: {
					title: 'Edit Personnel'
				}
			}
		]
	}, {
		path: '/servers',
		component: NestedRouteView,
		beforeEnter: Middlewares.userAuth,
		children: [{
				path: '/',
				component: Servers,
				meta: {
					title: 'Servers'
				}
			},
			{
				path: '/servers/create',
				component: ServerForm,
				meta: {
					title: 'Create Server'
				}
			}, {
				path: '/servers/:id/edit',
				component: ServerForm,
				meta: {
					title: 'Edit Server'
				}
			}
		]
	}, {
		path: '/config',
		component: NestedRouteView,
		beforeEnter: Middlewares.userAuth,
		children: [{
				path: '/',
				component: ConfigGeneral,
				meta: {
					title: 'General'
				}
			},
			{
				path: '/config/services',
				component: ConfigServices,
				meta: {
					title: 'Services'
				}
			}, {
				path: '/config/groups',
				component: ConfigGroups,
				meta: {
					title: 'Groups'
				}
			}, {
				path: '/config/departments',
				component: ConfigDepartments,
				meta: {
					title: 'Departments'
				}
			}, {
				path: '/config/predefined-flows',
				component: ConfigPredefinedFlows,
				meta: {
					title: 'Predefined Flows'
				}
			}, {
				path: '/config/predefined-flows/create',
				component: ConfigPredefinedFlowForm,
				meta: {
					title: 'Create New Flow'
				}
			}, {
				path: '/config/predefined-flows/:id/edit',
				component: ConfigPredefinedFlowForm,
				meta: {
					title: 'Edit Flow'
				}
			}
		]
	}, {
		path: '/guest',
		component: Guest,
		beforeEnter: Middlewares.userAuth,
		meta: {
			title: 'Guest'
		}
	}, {
		path: '/kiosk',
		component: Kiosk,
		meta: {
			title: 'Kiosk'
		}
	}, {
		path: '/server',
		component: Server,
		meta: {
			title: 'Server'
		}
	}]
})

router.beforeEach(async (to, from, next) => {
	if(localStorage.getItem('jwt-auth-token')){
		// store.dispatch('checkUser')
		// 	.then((response) => {
		// 		if(!response.data) return next()
		// 		return router.replace('/login')
		// 	}).catch((response) => {
		// 		return router.replace('/login')
		// 	})
		return next()
	}
	return next()
})

export default router