import Vue from 'vue'
import VueX from 'vuex'

Vue.use(VueX);


//modules 
import currentUser from './modules/currentUser.js'


export default new VueX.Store({
    modules:{
        currentUser
    }
})
