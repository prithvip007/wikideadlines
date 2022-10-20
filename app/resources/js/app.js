/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('calculator', require('./components/CalculatorComponent.vue').default);
Vue.component('shareable-link', require('./components/ShareableLinkComponent.vue').default);
Vue.component('feedback', require('./components/FeedbackComponent.vue').default);
Vue.component('login', require('./components/LoginComponent.vue').default);
Vue.component('profile-update', require('./components/ProfileRequiredUpdate.vue').default);
Vue.component('login-email', require('./components/LoginEmail.vue').default);
Vue.component('profile-settings', require('./components/ProfileSettingsComponent.vue').default);
Vue.component('invest-settings', require('./components/InvestorSettings.vue').default);
Vue.component('profile-phone-number', require('./components/ProfilePhoneNumber.vue').default);
Vue.component('profile-phone-number-modal', require('./components/ProfilePhoneNumberModalComponent.vue').default);
Vue.component('pricing', require('./components/PricingComponent.vue').default);
Vue.component('services-settings', require('./components/ServicesSettingsComponent.vue').default);
Vue.component('calculations', require('./components/Calculations.vue').default);
Vue.component('add-deadline-rule', require('./components/Interviews/AddDeadlineRule.vue').default);
Vue.component('login-modal', require('./components/LoginModal.vue').default);
Vue.component('edit-deadline-request', require('./components/EditDeadlineRequest.vue').default);
Vue.component('edit-county', require('./components/EditCounty.vue').default);
Vue.component('my-deadlines', require('./components/MyDeadlines/index.vue').default);

Vue.prototype.document = window.document;
Vue.prototype.window = window.window;

require('./directives');
require('./mixin');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.app = new Vue({
    el: '#app',
});
