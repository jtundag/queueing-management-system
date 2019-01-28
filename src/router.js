import Vue from 'vue'
import store from '@/store'
import Router from 'vue-router'
import Home from '@/views/Home.vue'
import Login from '@/views/Login.vue'

import NestedRouteView from '@/views/NestedRouteView.vue'

import Students from '@/views/Students/Students.vue'
import StudentForm from '@/views/Students/StudentForm.vue'
import Personnels from '@/views/Personnels/Personnels.vue'
import PersonnelForm from '@/views/Personnels/PersonnelForm.vue'

import Servers from '@/views/Servers/Servers.vue'
import ServerReports from '@/views/Servers/ServerReports.vue'
import ServerForm from '@/views/Servers/ServerForm.vue'

import ConfigGeneral from '@/views/Config/General.vue'
import ConfigServices from '@/views/Config/Services.vue'
import ConfigGroups from '@/views/Config/Groups.vue'
import ConfigDepartments from '@/views/Config/Departments.vue'
import ConfigPredefinedFlows from '@/views/Config/PredefinedFlows.vue'
import ConfigPredefinedFlowForm from '@/views/Config/PredefinedFlowForm.vue'

import Guest from '@/views/Guest/Guest.vue'
import Kiosk from '@/views/Kiosk/Kiosk.vue'
import ServiceScreen from '@/views/ServiceScreen/ServiceScreen.vue'
import Server from '@/views/Server/Server.vue'

Vue.use(Router)

const router = new Router({
	mode: 'history',
	routes: [{
		path: '/login',
		component: Login,
		meta: {
			title: 'Login',
			requireAuth: false
		}
	}, {
		path: '/',
		alias: '/dashboard',
		component: Home,
		meta: {
			title: 'Dashboard',
			requireAuth: true
		}
	}, {
		path: '/users',
		component: NestedRouteView,
		children: [{
				path: '/users/students',
				component: Students,
				meta: {
					title: 'Students',
					requireAuth: true
				}
			},
			{
				path: '/users/students/create',
				component: StudentForm,
				meta: {
					title: 'Create Student',
					requireAuth: true
				}
			}, {
				path: '/users/students/:id/edit',
				component: StudentForm,
				meta: {
					title: 'Edit Student',
					requireAuth: true
				}
			},
			{
				path: '/users/personnels',
				component: Personnels,
				meta: {
					title: 'Personnels',
					requireAuth: true
				}
			}, {
				path: '/users/personnels/create',
				component: PersonnelForm,
				meta: {
					title: 'Create Personnel',
					requireAuth: true
				}
			}, {
				path: '/users/personnels/:id/edit',
				component: PersonnelForm,
				meta: {
					title: 'Edit Personnel',
					requireAuth: true
				}
			}
		]
	}, {
		path: '/servers',
		component: NestedRouteView,
		children: [{
				path: '/',
				component: Servers,
				meta: {
					title: 'Servers',
					requireAuth: true
				}
		}, {
				path: '/servers/:id/reports',
				component: ServerReports,
				meta: {
					title: 'Server Reports',
					requireAuth: true
				}
			},
			{
				path: '/servers/create',
				component: ServerForm,
				meta: {
					title: 'Create Server',
					requireAuth: true
				}
			}, {
				path: '/servers/:id/edit',
				component: ServerForm,
				meta: {
					title: 'Edit Server',
					requireAuth: true
				}
			}
		]
	}, {
		path: '/config',
		component: NestedRouteView,
		children: [{
				path: '/',
				component: ConfigGeneral,
				meta: {
					title: 'General',
					requireAuth: true
				}
			},
			{
				path: '/config/services',
				component: ConfigServices,
				meta: {
					title: 'Services',
					requireAuth: true
				}
			}, {
				path: '/config/groups',
				component: ConfigGroups,
				meta: {
					title: 'Groups',
					requireAuth: true
				}
			}, {
				path: '/config/departments',
				component: ConfigDepartments,
				meta: {
					title: 'Departments',
					requireAuth: true
				}
			}, {
				path: '/config/predefined-flows',
				component: ConfigPredefinedFlows,
				meta: {
					title: 'Predefined Flows',
					requireAuth: true
				}
			}, {
				path: '/config/predefined-flows/create',
				component: ConfigPredefinedFlowForm,
				meta: {
					title: 'Create New Flow',
					requireAuth: true
				}
			}, {
				path: '/config/predefined-flows/:id/edit',
				component: ConfigPredefinedFlowForm,
				meta: {
					title: 'Edit Flow',
					requireAuth: true
				}
			}
		]
	}, {
		path: '/guest',
		component: Guest,
		meta: {
			title: 'Guest',
			requireAuth: false
		}
	}, {
		path: '/kiosk',
		component: Kiosk,
		meta: {
			title: 'Kiosk',
			requireAuth: false
		}
	}, {
		path: '/service-screen',
		component: ServiceScreen,
		meta: {
			title: 'Service Screen',
			requireAuth: false
		}
	}, {
		path: '/server',
		component: Server,
		meta: {
			title: 'Server',
			requireAuth: true
		}
	}]
})

router.beforeEach(async (to, from, next) => {
	if(!to.meta.requireAuth) return next()
	if (!localStorage.getItem('jwt-auth-token')) return router.replace(`/login`)
	store.dispatch('toggleFullLoader', true)
	let response = await store.dispatch('checkUser')
	store.dispatch('toggleFullLoader', false)
	if(!response.data.status){
		await store.dispatch('logout')
		return router.replace(`/login/?message=${response.data.message}`)
	}
	store.commit('LOGIN_SUCCESS', response)
	return next()
})

export default router