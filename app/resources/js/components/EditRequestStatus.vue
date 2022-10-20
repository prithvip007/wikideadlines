<template>
    <div>
        <modal ref="warning" trigger-hash="warning">
            <modal-header-primary :lines="['Review Document Request']"></modal-header-primary>
            <modal-body>
                <section>
                    <h6>The document has not been created.</h6>
                    <p class="alert alert-warning" role="alert">
                        This document for the rule you just approved needs to be approved before 
                        the approved rule can be displayed. Please review the document associated with this rule here: 
                        <br>
                        <a target="_blank" :href="`${documentLink}#edit-status`">Open Request <i class="fa fa-external-link"></i></a>
                    </p>
                </section>
            </modal-body>
        </modal>
        <modal ref="main" :trigger-hash="triggerHash">
            <modal-header-primary :lines="['Edit Status']"></modal-header-primary>
            <form @submit.prevent="edit" method="post">
                <modal-body>
                    <div class="form-group">
                        <label class="font-weight-bold" for="request-status">
                            Status
                            <i
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Status can't be changed once it's set to Approved"
                                class="fa fa-question-circle-o help"
                            ></i>
                        </label>
                    <div
                        :key="status.id"
                        v-for="status in statusList"
                        class="custom-control custom-radio"
                    >
                        <input
                            class="custom-control-input"
                            type="radio"
                            v-model="form.status_id"
                            :id="`status-${status.id}`"
                            name="status"
                            :value="status.id"
                            required="true"
                            :disabled="canBeChanged() === false"
                        >
                        <label
                            :for="`status-${status.id}`"
                            class="custom-control-label"
                        >
                            {{ status.name }}
                        </label>
                    </div>
                    </div>
                    <div v-if="warning" class="alert alert-warning" role="alert">
                        {{ warning }}
                    </div>
                </modal-body>
                <modal-footer-button :disabled="canBeChanged() === false" :loading="isEditing">
                    Save
                </modal-footer-button>
            </form>
        </modal>
    </div>
</template>

<script>
    import Modal from './Modal/Modal';
    import ModalHeaderPrimary from './Modal/ModalHeaderPrimary';
    import ModalFooterButton from './Modal/ModalFooterButton';
    import ModalBody from './Modal/ModalBody';
    import { client } from '../client';

    export default {
        props: {
            triggerHash: Modal.props.triggerHash,
            warning: {
                type: String,
                default: '',
                required: false
            },
            id: {
                type: Number,
                required: true
            },
            initialStatus: {
                type: Number,
                required: false
            },
            statusList: {
                type: Array,
                required: true
            }
        },
        components: {
            Modal,
            ModalBody,
            ModalHeaderPrimary,
            ModalFooterButton
        },
        data() {
            return {
                form: { status_id: this.initialStatus || null },
                currentStatusId: this.initialStatus || null,
                isEditing: false,
                documentLink: null,
                errors: {}
            }
        },
        methods: {
            async edit() {
                this.errors = {};
                this.isEditing = true;

                try {
                    const response = await client.updateRequest(this.id, this.form);

                    this.currentStatusId = this.form.status_id;

                    const message = response?.data?.message || 'Request status has been successfully updated';
                    const delay = response?.data?.message ? 15000 : undefined; 

                    toaster.add('Request status updated', message, delay);

                    if (response?.data?.link_to_document_request) {
                        this.documentLink = response.data.link_to_document_request;
                        setTimeout(() => {
                            this.$refs.main.close();
                            this.$refs.warning.open();
                        });
                    }

                } catch (e) {
                    if (e?.response?.data?.errors) {
                        this.errors = e.response.data.errors;

                        this.displayAllErrors();
                    } else {
                        console.error(e);
                    }
                } finally {
                    this.isEditing = false;
                }
            },
            canBeChanged() {
                return this.currentStatusId !== 1;
            },
            isHighlighted() {
                this.isGray = !this.isGray;
                return this.isGray;
            },
            getOrderNumber() {
                if (!this._orderCache) {
                    this._orderCache = 0;
                }

                return ++this._orderCache;
            },
            getErrors(fieldName) {
                return (this.errors[fieldName]) || [];
            },
            displayAllErrors() {
                const keys = Object.keys(this.errors);

                if (keys.length === 0) {
                    return;
                }

                keys.forEach((key) => {
                    toaster.error(key, this.errors[key]);
                })
            }
        }
    }
</script>
