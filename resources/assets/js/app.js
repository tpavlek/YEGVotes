require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');

Vue.component('council-member', require('./components/CouncilMember.vue'));

let app = new Vue({
    el: '#app'
});
