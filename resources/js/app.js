// require('./bootstrap');

window.Vue = require('vue');

Vue.component('buk', require('./components/Buk.vue').default);

Vue.component('tabs', {
  template: `
  <div>
    <div class="tabs">
      <ul>
        <li v-for="tab in tabs" v-bind:class="{'is-active': tab.isActive}">
          <a @click="selectTab(tab)">
            {{ tab.name }}
          </a>
         </li>
      </ul>
    </div>
    <div class="tab-details">
      <slot></slot>
    </div>
  </div>
`,
  data() {
    return {
      tabs: [],
    }
  },
  created() {
    this.tabs = this.$children;
  },
  methods: {
    selectTab(selectedTab) {
      this.tabs.forEach(
        function(tab){
          tab.isActive = (selectedTab.name == tab.name)
        }
      )
    }
  }
});

Vue.component('tab', {
  template: `
    <div v-show="isActive">
      <slot>
      </slot>
    </div>
`,
  props: {
    name: {
      required: true,
    },
    selected: {
      default: false
    }
  },
  data() {
    return {
      isActive: false
    }
  },
  mounted() {
    this.isActive = this.selected;
  }
});

const app = new Vue({
  el: '#app',
});
