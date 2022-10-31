<template>
    <modal :trigger-hash="triggerHash">
        <form method="post" @submit.prevent="send">
            <modal-header-primary :lines="['Feedback']"></modal-header-primary>
            <modal-body>
                <div class="form-group">
                    <label for="feedback">
                        Please tell us any suggestions you have for WikiDeadlines so we can provide you a better service:
                    </label>
                    <textarea
                        required
                        id="feedback"
                        placeholder="Tell us your thoughts"
                        rows="6"
                        v-model="formData.text"
                        maxlength="2000"
                        :class="{
                            'form-control': true,
                            'is-invalid': hasError('data.text')
                        }"
                    >
                    </textarea>
                    <span
                        v-for="error in getErrors('data.text')"
                        :key="error"
                        class="invalid-feedback"
                    >
                        {{ error }}
                    </span>
                </div>
                <div class="form-group">
                    <label for="email-id">
                        Enter your email if you'd like us to respond
                    </label>
                    <input
                        v-model="formData.email"
                        type="email"
                        maxlength="100"
                        name="email"
                        required
                        id="email-id"
                        :class="{
                            'form-control': true,
                            'is-invalid': hasError('data.email')
                        }"
                    />
                    <span
                        v-for="error in getErrors('data.email')"
                        class="invalid-feedback"
                        :key="error"
                    >
                        {{ error }}
                    </span>
                </div>
                <div>
                    We really appreciate your feedback!<br />
                    Thank you!
                </div>
            </modal-body>
            <modal-footer-button :loading="sending">
                Send Feedback
            </modal-footer-button>
        </form>
    </modal>
</template>
<style></style>
<script>
import Modal from './Modal/Modal';
import ModalHeaderPrimary from './Modal/ModalHeaderPrimary';
import ModalBody from './Modal/ModalBody';
import ModalFooterButton from './Modal/ModalFooterButton';
import { client } from '../client';

export default {
    components: {
        Modal,
        ModalHeaderPrimary,
        ModalFooterButton,
        ModalBody
    },
    props: {
        triggerHash: {
            type: String
        },
        initialEmail: {
            type: String,
            required: false,
            default: ''
        }
    },
    data() {
        return {
            formData: {
                text: "",
                email: this.initialEmail
            },
            errors: {},
            sending: false
        };
    },
    methods: {
        hasError(fieldName) {
            return !!this.errors[fieldName];
        },
        getErrors(fieldName) {
            return this.errors[fieldName] || [];
        },
        clear() {
            this.formData = {
                text: "",
                email: ""
            };
        },
        send() {
            if (this.sending) {
                return;
            }

            this.sending = true;

            this.errors = {};

            client.sendRequest({
                    type: "feedback",
                    data: this.formData
                })
                .then(() => {
                    toaster.add("Feedback sent", "Thank you!");
                    this.clear();
                    this.close();
                })
                .catch(error => {
                    if (error?.response?.data?.errors) {
                        this.errors = error.response.data.errors;
                    }
                })
                .finally(() => {
                    this.sending = false;
                });
        },
    }
};
</script>
