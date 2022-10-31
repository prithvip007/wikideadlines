<template>
    <modal ref="modal" :triggerHash="triggerHash" :keyboard="false" backdrop="static">
        <login-component
            :hide-registration-alert="false"
            :initial-step="0"
            :facebook-link="facebookLink"
            :google-link="googleLink"
        ></login-component>
    </modal>
</template>

<script>
    import LoginComponent from './LoginComponent.vue';
    import Modal from './Modal/Modal.vue';

    export default {
        props: {
            triggerHash: {
                type: String,
                required: true
            },
            facebookLink: {
                type: String,
                required: true
            },
            googleLink: {
                type: String,
                required: true
            },
        },
        components: {
            LoginComponent,
            Modal
        },
        methods: {
            init() {
                this.$refs.modal.open();
            },
        },
        mounted() {
            this.init();
        }
    }
</script>
