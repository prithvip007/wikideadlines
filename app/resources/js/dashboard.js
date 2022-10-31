require('./bootstrap');

window.Vue = require('vue');

Vue.component('edit-deadline', require('./components/EditDeadline.vue').default);
Vue.component('rule-form', require('./components/RuleForm.vue').default);
Vue.component('edit-request-status', require('./components/EditRequestStatus.vue').default);
Vue.component('document-form', require('./components/DocumentForm.vue').default);
Vue.component('delete-deadline-modal', require('./components/DeleteDeadlineModal.vue').default);
Vue.component('delete-document-modal', require('./components/DeleteDocumentModal.vue').default);
Vue.component('delivery-method-form', require('./components/DeliveryMethodForm.vue').default);
Vue.component('delete-delivery-method', require('./components/DeleteDeliveryMethod.vue').default);


Vue.prototype.document = window.document;
Vue.prototype.window = window.window;

require('./directives');
require('./mixin');

window.app = new Vue({
    el: 'main',
});

document
    .querySelectorAll('.side-collapse-btn')
    .forEach((element) => element.addEventListener('click', onMenuButtonClick));

function onMenuButtonClick() {
    document.querySelectorAll('.sidebar-collapse').forEach((element) => element.classList.toggle("toggle-md-flex"));
}

$('.help').tooltip();

