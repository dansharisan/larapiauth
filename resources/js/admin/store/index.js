import Vue from 'vue'
import Vuex from 'vuex'
import EasyAccess from 'vuex-easy-access'

import state from './state'
import mutations from './mutations'
import modules from './modules'

Vue.use(Vuex)

export default new Vuex.Store({
  state,
  mutations,
  modules,
  plugins: [EasyAccess()],
})
