require('./bootstrap');
require('datatables.net-bs4');
require('datatables.net-buttons-bs4');
window.Vue = require('vue');
window.axios = require('axios');


Vue.component('v-input', require('./components/Form/Input').default)
Vue.component('v-checkbox', require('./components/Form/Checkbox').default)
Vue.component('v-button', require('./components/Button/Button').default)
Vue.component('v-dropdown', require('./components/Form/Dropdown').default)

const app = new Vue({
  el: '#app',
});
