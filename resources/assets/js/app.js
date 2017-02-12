import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'

// importing custom components
import SidebarCollapse from './components/SidebarCollapse'
import ImageUpload from './components/ImageUpload'

// Adding the X-CSRF-Token to all axios request
axios.interceptors.request.use(function(config){
  config.headers['X-CSRF-TOKEN'] = window.Laravel.csrfToken
  return config
})

// Making axios available as $http 
// so that the ajax calls are not axios dependent
Vue.prototype.$http = axios

Vue.use(VueAxios, axios)
Vue.use(VueRouter)

Vue.component('sidebar-collapse', SidebarCollapse)
Vue.component('image-upload', ImageUpload)

const app = new Vue({
  el: '#app',
  data: {
    message: 'Hello World!'
  }
})