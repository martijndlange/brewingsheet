// require('./bootstrap');

window.Vue = require('vue');

Vue.component('buk', require('./components/Buk.vue').default);
Vue.component('tabs', require('./components/Tabs.vue').default);
Vue.component('tab', require('./components/Tab.vue').default);

// Thanks to @megapctr
new Vue({
  el: '#app',
  data() {
    return {
      date: new Date(),
    }
  },
});
