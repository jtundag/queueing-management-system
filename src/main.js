import Vue from 'vue'
import App from './App.vue'
import VueTippy from 'vue-tippy'
import router from './router'
import store from './store/index'
import './registerServiceWorker'
import vClickOutside from 'v-click-outside'
require('vue2-animate/dist/vue2-animate.min.css')
import PerfectScrollbar from 'vue2-perfect-scrollbar'
require('vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css')
import { VueSpinners } from '@saeris/vue-spinners'

import 'vodal/common.css';
import 'vodal/slide-down.css';

import ContentContainer from '@/components/Base/ContentContainer.vue'

Vue.config.productionTip = false

Vue.use(VueTippy)
Vue.use(vClickOutside)
Vue.use(PerfectScrollbar)
Vue.use(VueSpinners)

Vue.component('ContentContainer', ContentContainer)

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
