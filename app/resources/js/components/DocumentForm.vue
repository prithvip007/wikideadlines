<template>
    <modal :trigger-hash="triggerHash">
        <modal-header-primary
            :lines="typeof id === 'number' ? ['Edit Document'] : ['Add Document']">
        </modal-header-primary>
        <form @submit.prevent="save" method="post">
            <modal-body>
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
                            :class="{'is-invalid': hasError('small_description')}"
                            rows="3"
                            v-model="form.small_description"
                        ></textarea>
                        <span v-for="error, index in getErrors('small_description')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="keywords" class="font-weight-bold">
                            Keywords
                            <small class="text-muted">
                                (optional)
                            </small>
                        </label>
                        <textarea
                            id="keywords"
                            maxlength="2000"
                            class="form-control"
                            :class="{'is-invalid': hasError('keywords')}"
                            rows="3"
                            v-model="form.keywords"
                        ></textarea>
                        <span v-for="error, index in getErrors('keywords')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <div class="mb-2 font-weight-bold">
                            Delivery Methods
                            <small class="text-muted">
                                (optional)
                            </small>
                        </div>
                        <multiselect
                            :multiple="true"
                            v-model="form.delivery_methods"
                            label="name"
                            track-by="id"
                            :options="deliveryMethods"></multiselect>
                        <span v-for="error, index in getErrors('name')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="best_practices" class="font-weight-bold">
                            Best Practices
                            <small class="text-muted">
                                (optional)
                            </small>
                        </label>
                        <textarea
                            id="best_practices"
                            maxlength="2000"
                            class="form-control"
                            :class="{'is-invalid': hasError('best_practices')}"
                            rows="3"
                            v-model="form.best_practices"
                        ></textarea>
                        <span v-for="error, index in getErrors('best_practices')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Ask Hearing Courthouse
                        </label>
                        <div
                            :key="radio.label"
                            v-for="radio in [{ label: 'Yes', value: true }, { label: 'No', value: false }]"
                            class="custom-control custom-radio"
                        >
                            <input
                                class="custom-control-input"
                                type="radio"
                                v-model="form.ask_hearing_courthouse"
                                :id="`courthouse-${radio.label}`"
                                name="courthouse"
                                :value="radio.value"
                                required
                            >
                            <label
                                :for="`courthouse-${radio.label}`"
                                class="custom-control-label"
                            >
                                {{ radio.label }}
                            </label>
                        </div>
                        <span v-for="error, index in getErrors('ask_hearing_courthouse')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Ask Hearing Courtroom
                        </label>
                        <div
                            :key="radio.label"
                            v-for="radio in [{ label: 'Yes', value: true }, { label: 'No', value: false }]"
                            class="custom-control custom-radio"
                        >
                            <input
                                class="custom-control-input"
                                type="radio"
                                v-model="form.ask_hearing_courtroom"
                                :id="`courtroom-${radio.label}`"
                                name="courtroom"
                                :value="radio.value"
                                required
                            >
                            <label
                                :for="`courtroom-${radio.label}`"
                                class="custom-control-label"
                            >
                                {{ radio.label }}
                            </label>
                        </div>
                        <span v-for="error, index in getErrors('ask_hearing_courtroom')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div v-if="id === undefined" class="form-group">
                        <label class="font-weight-bold">
                            Add standard 16-9-5 motion deadline rules?
                        <i
                            data-toggle="tooltip"
                            data-placement="top"
                            title="When checked, deadline rules for the motion, opposition and reply filing and service, along with the hearing date, are automatically created."
                            class="fa fa-question-circle-o help ml-1"
                        ></i>
                        </label>
                        <div
                            :key="radio.label"
                            v-for="radio in [{ label: 'Yes', value: true }, { label: 'No', value: false }]"
                            class="custom-control custom-radio"
                        >
                            <input
                                class="custom-control-input"
                                type="radio"
                                v-model="form.standard_motion_briefing"
                                :id="`standard-motion-briefing-${radio.label}`"
                                name="standard_motion_briefing"
                                :value="radio.value"
                                required
                            >
                            <label
                                :for="`standard-motion-briefing-${radio.label}`"
                                class="custom-control-label"
                            >
                                {{ radio.label }}
                            </label>
                        </div>
                        <span v-for="error, index in getErrors('standard_motion_briefing')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
            </modal-body>
            <modal-footer-button :loading="isSaving">
                Save
            </modal-footer-button>
        </form>
    </modal>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import Modal from './Modal/Modal';
    import ModalHeaderPrimary from './Modal/ModalHeaderPrimary';
    import ModalFooterButton from './Modal/ModalFooterButton';
    import ModalBody from './Modal/ModalBody';
    import { client } from '../client';

    export default {
        props: {
            triggerHash: Modal.props.triggerHash,
            deliveryMethods: {
                type: Array,
                required: true,
            },
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
            ModalFooterButton,
            Multiselect
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

                const form = this.getHandledFormData();

                try {
                    isEditing
                        ? await client.updateDocument(this.id, form)
                        : await client.createDocument(form);

                    toaster.add('Document saved', 'Document has been successfully saved');

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
            getHandledFormData() {
                const { delivery_methods, ...rest } = this.form;
                const deliveryMethods = delivery_methods.map(({ id }) => id);

                return { ...rest, delivery_methods: deliveryMethods };
            },
            getFormData() {
                return {
                    name: '',
                    small_description: '',
                    best_practices: '',
                    keywords: '',
                    ask_hearing_courthouse: false,
                    ask_hearing_courtroom: false,
                    standard_motion_briefing: false,
                    delivery_methods: []
                };
            },
            hasError(fieldName) {
                return !!this.errors[fieldName];
            },
            getErrors(fieldName) {
                return (this.errors[fieldName]) || [];
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
