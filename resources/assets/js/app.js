require('./bootstrap');
require('./sb-admin-2');
require('./metisMenu');
require('./wits-ui');

$.ajaxSetup({
  headers: {
    Authorization: 'Bearer:' + $('meta[name="api-token"]').attr("content")
  }
});


Vue.component('example', require('./components/Example.vue'));
Vue.component('user-table', require('./components/wits/UserTable.vue'));
Vue.component('passport-clients', require('./components/passport/Clients.vue') );
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue') );
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue') );

const app = new Vue({
    el: '#app'
});


