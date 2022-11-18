<template>
    <modal :trigger-hash="triggerHash">
        <modal-header-primary
            :lines="typeof id === 'number' ? ['Edit Deadline Rule'] : ['Add Deadline Rule']">
        </modal-header-primary>
        <form @submit.prevent="save" method="post">
            <modal-body>
                <div ref="body">
                    <div class="form-group">
                        <label for="deadline-rule-title" class="font-weight-bold">
                            Title of Deadline Rule
                            <small class="text-muted">
                                (optional)
                            </small>
                        </label>
                        <input
                            id="deadline-rule-title"
                            v-model="form.title"
                            type="text"
                            class="form-control"
                            :class="{'is-invalid': hasError('title')}"
                        >
                        <span v-for="error, index in getErrors('title')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="document-type-id">
                            Document or Pleading Title uu
                        </label>
                        <select ref="documentType" v-select2="{placeholder: 'Search Pleadings and Documents by Title'}"
                                v-model="form.document_type_id"
                                id="document-type-id"
                                class="form-control"
                                name="document_type_id" required>
                            <option></option>
                            <option v-for="type in documentTypes" :value="type.id" :key="type.id"
                                    :data-select2-description="type.small_description"
                                    :data-select2-keywords="type.keywords">
                                {{ type.name }}
                            </option>
                        </select>
                        <span v-for="error, index in getErrors('document_type_id')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="event">
                            Triggering Event
                        </label>
                        <select
                            v-select2="{placeholder: 'Search Triggering Events by Title'}"
                            v-model="form.add_to"
                            id="event"
                            class="form-control"
                            required
                        >
                            <option></option>
                            <option
                                v-for="key in Object.keys(events)"
                                :value="key"
                                :key="key"
                                :data-select2-description="getDescription(key)"
                            >
                                {{ events[key].document_received }}
                            </option>
                        </select>
                        <span v-for="error, index in getErrors('add_to')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="description" class="font-weight-bold">
                            Description
                        </label>
                        <textarea
                            id="description"
                            maxlength="2000"
                            class="form-control"
                            :class="{'is-invalid': hasError('name')}"
                            rows="3"
                            v-model="form.name"
                            required
                        ></textarea>
                        <span v-for="error, index in getErrors('name')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="bestPractices" class="font-weight-bold">
                            Best Practices
                            <small class="text-muted">
                                (optional)
                            </small>
                        </label>
                        <textarea
                            id="bestPractices"
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
                        <label for="days" class="font-weight-bold">
                            Days
                        </label>
                        <input
                            id="days"
                            v-model="form.days"
                            type="number"
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
                        <label class="font-weight-bold">
                            Check "Date on Proof of Service" Preciseness
                        </label>
                        <div
                            :key="radio.label"
                            v-for="radio in [{ label: 'Yes', value: true }, { label: 'No', value: false }]"
                            class="custom-control custom-radio"
                        >
                            <input
                                class="custom-control-input"
                                type="radio"
                                v-model="form.check_dps_preciseness"
                                :id="`dps-${radio.label}`"
                                name="dps"
                                :value="radio.value"
                                required
                            >
                            <label
                                :for="`dps-${radio.label}`"
                                class="custom-control-label"
                            >
                                {{ radio.label }}
                            </label>
                        </div>
                        <span v-for="error, index in getErrors('check_dps_preciseness')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Calculate If The Same Judge
                            <i
                                data-toggle="tooltip"
                                data-placement="top"
                                title="If 'Yes' is selected users will be asked “This hearing to be conducted by the same judge that is assigned for all purposes to this case” on the input page. The rule will be calculated only if users positively answer the question"
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
                                v-model="form.calculate_if_same_judge"
                                :id="`judge-${radio.label}`"
                                name="judge"
                                :value="radio.value"
                                required
                            >
                            <label
                                :for="`judge-${radio.label}`"
                                class="custom-control-label"
                            >
                                {{ radio.label }}
                            </label>
                        </div>
                        <span v-for="error, index in getErrors('calculate_if_same_judge')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Does the Rule add a number of days to the deadline based on how the document is delivered or served (the Method of Delivery or Service)? 
                            <i
                                data-toggle="tooltip"
                                data-placement="top"
                                title="If 'Yes' is selected and a document associated with this rule has delivery methods then delivery days are subtracted from (added to) this deadline rule"
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
                                v-model="form.subtract_delivery_days"
                                :id="`substractDeliveryDays-${radio.label}`"
                                name="substractDeliveryDays"
                                :value="radio.value"
                                required
                            >
                            <label
                                :for="`substractDeliveryDays-${radio.label}`"
                                class="custom-control-label"
                            >
                                {{ radio.label }}
                            </label>
                        </div>
                        <span v-for="error, index in getErrors('subtract_delivery_days')" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                    <div class="form-group">
                            <label class="font-weight-bold">
                                How should it be filtered?
                            </label>
                                <div
                                    v-for="item, index in [
                                        { title: 'No Display - Doc Received', value: 'no_display:document_received' },
                                        { title: 'No Check - Doc Received', value: 'no_check:document_received' },
                                        { title: 'No Display - Doc to Send', value: 'no_display:document_to_send' },
                                        { title: 'No Check - Doc to Send', value: 'no_check:document_to_send' }
                                    ]"
                                    :key="index"
                                    class="custom-control custom-checkbox"
                                >
                                    <input
                                        v-model="form.visibility_scopes"
                                        type="checkbox"
                                        class="custom-control-input"
                                        :value="item.value"
                                        :id="item.value"
                                        name="visibility-scope"
                                    >
                                    <label
                                        :for="item.value"
                                        class="custom-control-label"
                                    >
                                        {{ item.title }}
                                    </label>
                                </div>
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
            documentTypes: {
                type: Array,
                required: true
            },
            initialData: {
                type: Object,
                required: false,
            },
            id: {
                type: Number,
                required: false,
            },
            events: {
                type: Object,
                required: true
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
                        ? await client.editDeadline(this.id, this.form)
                        : await client.createDeadline(this.form);

                    toaster.add('Deadline rule saved', 'Deadline rule has been successfully saved');

                    if (isEditing === false) {
                        this.form = this.getFormData();

                        // This is done to reset selects
                        this.$nextTick(() => {
                            this.$forceUpdate();
                        });
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
            initializeTooltips() {
                this.$nextTick(() => {
                    $(this.$refs.body).find('.help').tooltip();
                });
            },
            getFormData() {
                return {
                    title: '',
                    document_type_id: '',
                    visibility_scopes: [],
                    name: '',
                    best_practices: '',
                    days: '',
                    add_to: '',
                    days_type: '',
                    check_dps_preciseness: false,
                    calculate_if_same_judge: false,
                    subtract_delivery_days: false,
                };
            },
            hasError(fieldName) {
                return !!this.errors[fieldName];
            },
            getErrors(fieldName) {
                return (this.errors[fieldName]) || [];
            },
            getDescription(key) {
                if (key === 'tdreq') {
                    return 'Required';
                }

                if (key === 'td') {
                    return 'Optional';
                }

                return '';
            }
        },
        created: function () {
            this.initializeTooltips();
        },
        updated: function () {
            this.initializeTooltips();
        }
    }
</script>
