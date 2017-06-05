require('./bootstrap');
require('./sb-admin-2');
require('metisMenu');
require('./wits-ui');

$.ajaxSetup({
  headers: {
    Authorization: 'Bearer:' + $('meta[name="api-token"]').attr("content")
  }
});


import KeenUI from 'keen-ui';
import 'keen-ui/src/bootstrap';
import UiButton from 'keen-ui/src/UiButton.vue';

Vue.use(KeenUI);

import Multiselect from 'vue-multiselect/dist/vue-multiselect.min.js'
Vue.component('multiselect',Multiselect)




// Vue.component('example', require('./components/Example.vue'));

Vue.component('users', require('./components/wits/Users.vue'));
Vue.component('locations', require('./components/wits/Locations.vue'));
Vue.component('departments', require('./components/wits/Departments.vue'));


Vue.component('passport-clients', require('./components/passport/Clients.vue') );
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue') );
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue') );



const app = new Vue({
    el: '#app'
});


