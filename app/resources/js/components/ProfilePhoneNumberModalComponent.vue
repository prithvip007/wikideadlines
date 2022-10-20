<template>
    <modal :trigger-hash="triggerHash" ref="modal">
        <phone-number-login v-on:logged-in="onLoggedIn" :key="key"></phone-number-login>
    </modal>
</template>

<script>
    import Modal from './Modal/Modal';
    import PhoneNumberLogin from './PhoneNumberLogin.vue';

    export default {
        components: {
            PhoneNumberLogin,
            Modal,
        },
        props: {
            triggerHash: Modal.props.triggerHash
        },
        data() {
            return {
                key: this.getUniqueKey()
            }
        },
        methods: {
            onLoggedIn() {
                this.close();
                setTimeout(() => this.key = this.getUniqueKey(), 1000)
            },
            show() {
                this.$refs.modal.show();
            },
            close() {
                this.$refs.modal.close();
            },
            getUniqueKey() {
                return String(Math.random());
            }
        }
    }
</script>
