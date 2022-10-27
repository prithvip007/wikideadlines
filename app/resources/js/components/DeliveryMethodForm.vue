<template>
    <modal :trigger-hash="triggerHash">
        <modal-header-primary
            :lines="typeof id === 'number' ? ['Edit Delivery Method'] : ['Add Delivery Method']">
        </modal-header-primary>
        <form @submit.prevent="save" method="post">
            <modal-body>
                <div ref="body">
                    <div class="form-group">
                        <label for="name" class="font-weight-bold">
                            Name
                        </label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            class="form-control"
                            :class="{'is-invalid': hasError('name')}"
                        >
                        <span v-for="error, index in getErrors('name')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="days" class="font-weight-bold">
                            Days
                        </label>
                        <input
                            id="days"
                            v-model="form.days"
                            type="number"
                            min="0"
                            required
                            class="form-control"
                            :class="{'is-invalid': hasError('days')}"
                        >
                        <span v-for="error, index in getErrors('days')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Days Type
                        </label>
                        <div
                            :key="label"
                            v-for="label in ['court', 'calendar']"
                            class="custom-control custom-radio"
                        >
                            <input
                                class="custom-control-input"
                                type="radio"
                                v-model="form.days_type"
                                :id="`daysType-${label}`"
                                name="daysType"
                                :value="label"
                                required
                            >
                            <label
                                :for="`daysType-${label}`"
                                class="custom-control-label text-capitalize"
                            >
                                {{ label }}
                            </label>
                        </div>
                        <span v-for="error, index in getErrors('days_type')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="description" class="font-weight-bold">
                            Description
                            <small class="text-muted">
                                (optional)
                            </small>
                        </label>
                        <textarea
                            id="description"
                            maxlength="2000"
                            class="form-control"
                            :class="{'is-invalid': hasError('description')}"
                            rows="3"
                            v-model="form.description"
                        ></textarea>
                        <span v-for="error, index in getErrors('description')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="warning" class="font-weight-bold">
                            Warning
                            <small class="text-muted">
                                (optional)
                            </small>
                        </label>
                        <textarea
                            id="warning"
                            maxlength="2000"
                            class="form-control"
                            :class="{'is-invalid': hasError('warning')}"
                            rows="3"
                            v-model="form.warning"
                        ></textarea>
                        <span v-for="error, index in getErrors('warning')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="outside_state_days" class="font-weight-bold">
                            Outside State Days
                            <small class="text-muted">
                                (optional)
                            </small>
                        </label>
                        <input
                            id="outside_state_days"
                            v-model="form.outside_state_days"
                            type="number"
                            class="form-control"
                            :class="{'is-invalid': hasError('outside_state_days')}"
                        >
                        <span v-for="error, index in getErrors('outside_state_days')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="outside_country_days" class="font-weight-bold">
                            Outside Country Days
                            <small class="text-muted">
                                (optional)
                            </small>
                        </label>
                        <input
                            id="outside_country_days"
                            v-model="form.outside_country_days"
                            type="number"
                            class="form-control"
                            :class="{'is-invalid': hasError('outside_country_days')}"
                        >
                        <span v-for="error, index in getErrors('outside_country_days')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                </div>
            </modal-body>
            <modal-footer-button :loading="isSaving">
                Save
            </modal-footer-button>
        </form>
    </modal>
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
            initialData: {
                type: Object,
                required: false,
            },
            id: {
                type: Number,
                required: false,
            }
        },
        components: {
            Modal,
            ModalHeaderPrimary,
            ModalBody,
            ModalFooterButton
        },
        data() {
            const data = {
                form: this.getFormData(),
                isSaving: false,
                errors: {}
            };

            return this.initialData ? Object.keys(data.form).reduce((accumulator, key) => {
                if ((key in this.initialData) === false) {
                    return accumulator;
                }

                accumulator.form[key] = this.initialData[key];

                return accumulator;
            }, data) : data;
        },
        methods: {
            async save() {
                const isEditing = typeof this.id === 'number';
                this.errors = {};
                this.isSaving = true;

                try {
                    isEditing
                        ? await client.updateDeliveryMethod(this.id, this.form)
                        : await client.createDeliveryMethod(this.form);

                    toaster.add('Delivery method saved', 'Delivery method has been successfully saved');

                    if (isEditing === false) {
                        this.form = this.getFormData();
                    }
                } catch (e) {
                    if (e?.response?.data?.errors) {
                        this.errors = e.response.data.errors;
                    } else {
                        console.error(e);
                    }
                } finally {
                    this.isSaving = false;
                }
            },
            getFormData() {
                return {
                    name: '',
                    description: '',
                    warning: '',
                    days: '',
                    days_type: '',
                    outside_state_days: '',
                    outside_country_days: ''
                };
            },
            hasError(fieldName) {
                return !!this.errors[fieldName];
            },
            getErrors(fieldName) {
                return (this.errors[fieldName]) || [];
            },
            initializeTooltips() {
                this.$nextTick(() => {
                    $(this.$refs.body).find('.help').tooltip();
                });
            },
        },
        created: function () {
            this.initializeTooltips();
        },
        updated: function () {
            this.initializeTooltips();
        }
    }
</script>
