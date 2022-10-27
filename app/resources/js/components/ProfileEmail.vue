<template>
    <div>
        <modal trigger-hash="email" ref="modal">
            <mail-change :key="key" v-on:changed="handleEmailChanged"></mail-change>
        </modal>
        <input-with-change
            label="Email"
            placeholder="Add an email"
            :value="email"
            link="#email"
        ></input-with-change>
    </div>
</template>

<script>
    import InputWithChange from "./InputWithChange.vue";
    import MailChange from "./MailChange.vue";
    import Modal from './Modal/Modal.vue';

    export default {
        components: {
          InputWithChange,
          MailChange,
          Modal
        },
        props: {
            initialEmail: {
                type: String,
                required: false,
                default: ''
            }
        },
        data() {
            return {
                email: this.initialEmail,
                key: this.getRandomKey(),
                errors: [],
                isSubmitting: false
            }
        },
        methods: {
            getRandomKey() {
                return String(Math.random());
            },
            handleEmailChanged(email) {
                this.email = email;
                this.$refs.modal.close();
                toaster.add('Email has been updated', 'Email has been successfully updated');
                setTimeout(() => this.key = this.getRandomKey(), 1000);
            }
        }
    }
</script>
