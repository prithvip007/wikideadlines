<template>
    <form ref="body" method="post" @submit.prevent="send">
        <modal-body>
            <interview-fields :errors="errors" ref="interview" :elements="elements" :excludeItems="excludeItems" :excludeElements="excludeElements"></interview-fields>
            <div class="form-group">
                <label class="font-weight-bold">Your Email</label>
                <input
                    v-model="email"
                    required
                    type="email"
                    :class="{'form-control': true, 'is-invalid': hasError('data.email')}"
                >
                <span :key="error" v-for="error in getErrors('data.email')" class="invalid-feedback">
                    {{ error }}
                </span>
            </div>
        </modal-body>
        <modal-footer-button :loading="sending">Submit</modal-footer-button>
    </form>
</template>

<script>
    import ModalFooterButton from './ModalFooterButton';
    import InterviewFields from '../InterviewFields.vue';
    import ModalBody from './ModalBody';
    import { client } from '../../client';

    export default {
        components: {
            ModalFooterButton,
            ModalBody,
            InterviewFields
        },
        props: {
            documentId: {
                type: Number,
                required: false
            },
            requestId: {
                type: Number,
                required: false
            },
            type: {
                type: String,
                required: true
            },
            emailInitialValue: {
                type: String,
                required: false,
                defaultValue: ''
            },
            calculationId: {
                type: Number,
                required: false
            },
            deadlineId: {
                type: Number,
                required: false
            },
            excludeItems: {
                type: Array,
                required: false
            },
            excludeElements: {
                type: Array,
                required: false
            },
            elements: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                errors: {},
                email: this.emailInitialValue,
                sending: false,
            }
        },
        methods: {
            hasError(fieldName) {
                return !!this.errors[fieldName];
            },
            getErrors(fieldName) {
                return (this.errors[fieldName]) || [];
            },
            getDataByPath(object, path) {
                const keys = path.split('.');

                let data = object;
                for (let i = 0; i < keys.length; i++) {
                    const key = keys[i];

                    if (Array.isArray(data)) {
                        data = data[Number(key)];
                    } else if (data && data.hasOwnProperty(key)) {
                        data = data[key];
                    } else {
                        throw Error(`Path ${path} doesn't exist`);
                    }
                }

                return data;
            },
            send() {
                if (this.sending) {
                    return;
                }

                this.sending = true;

                const data = {
                    type: this.type,
                    data: {
                        request_id: this.requestId,
                        document_id: this.documentId,
                        email: this.email,
                        deadlines: this.$refs.interview.generateOutput(),
                        calculation_id: this.calculationId,
                        deadline_id: this.deadlineId
                    }
                };

                this.errors = {};

                client.sendRequest(data).then((response) => {
                    this.$emit(
                        'submitted',
                        this.$refs.interview.fields,
                        this.email,
                        response.data.data.id
                    );
                }).catch((error) => {
                    if (error?.response?.data?.errors) {
                        const { errors } = error.response.data;

                        this.errors = errors;

                        Object.keys(errors).forEach((path) => {
                            const match = path.match(/data\.deadlines\.\d+/);

                            if (!match) {
                                return;
                            }

                            const deadline = this.getDataByPath(data, match[0]);

                            if (deadline.meta.key) {
                                this.errors[deadline.meta.key] = errors[path];
                            }
                        });
                    }
                }).finally(() => {
                    this.sending = false;
                });
            }
        }
    }
</script>
