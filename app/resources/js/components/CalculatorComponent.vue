<template>
    <!-- TODO: file too long. refactor it  -->
    <div class="card card-m">
        <div ref="body" class="card-body">
            <county-info
                v-if="getProhibitedText().length > 0 || getCountyLinks().length > 0"
                trigger-hash="county-info"
                :prohibited="getProhibitedText()"
                :links="getCountyLinks()"
            >
            </county-info>
            <add-document-interview
                :document-request="documentRequest"
                :document-elements="documentElements"
                :deadline-rule-elements="deadlineRuleElements"
                :initial-email="initialEmail"
                trigger-hash="document"
            ></add-document-interview>
            <add-jurisdiction-interview
                :document-elements="documentElements"
                :initial-email="initialEmail"
                :deadline-rule-elements="deadlineRuleElements"
                :jurisdiction-elements="jurisdictionElements"
                trigger-hash="jurisdiction"
            ></add-jurisdiction-interview>
            <section class="text-center">
                <div class="mb-4 h4" style="display: flex;flex-direction: column;">
                    <span v-if="showHummerIcon" class="fa fa-gavel" style="margin-bottom: 10px;font-size: 54px;"></span>
                    Find Deadlines &amp; Best Practices
                </div>
            </section>
            <div class="d-flex justify-content-center mb-4 form-border">
                <ul class="document-tabs">
                    <li class="document-tabs__item">
                        <button
                            :tabindex="formData.type === 'document_received' ?  '-1' : '0'"
                            :class="{'document-tabs__button_active': formData.type === 'document_received'}"
                            class="btn document-tabs__button"
                            @click="onDocumentReceivedClick"
                        >
                            Document Received  
                        </button>
                    </li>
                    <li class="document-tabs__item">
                        <button
                            :tabindex="formData.type === 'document_to_send' ?  '-1' : '0'"
                            class="btn document-tabs__button"
                            :class="{'document-tabs__button_active': formData.type === 'document_to_send'}"
                            @click="onDocumentToSendClick"
                        >
                            Document to Send  
                        </button>
                    </li>
                 
                </ul>
            </div>
            <terms-of-use trigger-hash="terms-of-use"></terms-of-use>
            <form @submit="submit" ref="form" method="post">
                <input type="hidden" name="type" :value="formData.type">
                <input type="hidden" name="_token" :value="csrfToken()">

                <case-name-select @input="handleCaseNameInput" v-model="formData.case_name" :dynamic="authenticated"></case-name-select>

                <div @dblclick="onJurisdictionDBClick" class="form-group mb-4">
                    <!-- Its actually not a Jurisdiction. Is a State. We should refactor the whole app to support jurisdictions later when more details become available -->
                    <label class="font-weight-bold" for="state-id">
                        Jurisdiction
                        <i
                            v-if="canChangeJurisdiction === false"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Double click the disabled element in order to change its value"
                            class="fa fa-question-circle-o help ml-1"
                        ></i>
                        <span class="text-muted">(Court or arbitration company where the case is or will be filed)</span>
                        <div class="text-muted"> 
                            (If you don't see your jurisdiction, 
                            <a
                                href="#jurisdiction"
                            >
                            click here to add it</a>)
                        </div>
                    </label>
                    <select v-select2="{placeholder: 'Select a Jurisdiction'}" v-model="formData.state_id" id="state-id"
                            class="form-control"
                            name="state_id" required :readonly="canChangeJurisdiction === false">
                        <option></option>
                        <option v-for="state in states" :value="state.id" :key="state.id">{{ state.name }}</option>
                    </select>
                </div>
                <div @dblclick="onCountyDBClick" v-if="getCountiesForCurrentState().length > 0" class="form-group mb-4">
                    <label class="font-weight-bold" for="county-id">
                        County
                        <i
                            v-if="canChangeCounty === false"
                            data-toggle="tooltip"
                            data-placement="top"
                           
                            class="fa fa-question-circle-o help ml-1"
                        ></i>
                    </label>
                    <select v-select2="{placeholder: 'Select a County'}" v-model="formData.county_id" id="county-id"
                            class="form-control"
                            name="county_id" required :readonly="canChangeCounty === false">
                        <option></option>
                        <option v-for="county in getCountiesForCurrentState()" :value="county.id" :key="county.id">{{ county.name }}</option>
                    </select>
                </div>
                <div v-if="displayWarning()" class="form-group mb-4">
                    <div class="alert border-left-0 border-right-0 alert-wide alert-squared alert-warning">
                        <template v-if="getCountyWarning()">
                            E-Filing is <strong>{{ getCountyWarning().status }}</strong> for the selected county.
                        </template>
                        <a href="#county-info" v-if="getProhibitedText() || getCountyLinks().length > 0">Click here to learn more about the county</a>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold" for="document-type-id">
                        Document or Pleading Title
                        <div class="text-muted"> 
                            (If you don't see a document title, 
                            <a
                                href="#document"
                            >
                            click here to add a new document</a>)
                        </div>
                    </label>
                    <select ref="documentType" v-select2="getDocumentTypeSelect2Options()"
                            v-model="formData.document_type_id"
                            id="document-type-id" class="form-control"
                            name="document_type_id" required>
                        <option></option>
                        <option v-for="type in documentTypes" :value="type.id" :key="type.id"
                                :data-select2-description="type.small_description"
                                :data-select2-keywords="type.keywords">
                            {{ type.name }}
                        </option>
                    </select>
                </div>
                

                <template v-if="getDocumentType() && getDocumentType().requires_delivery_method  && getDeliveryMethods().length > 0">
                    <div class="form-group mb-4">
                        <label class="font-weight-bold" for="delivery-method-id">
                            Delivery Method
                            <small v-if="isRequired(true, 'deliveryMethod') === false" class="text-muted">(optional)</small>
                        </label>
                        <select :key="isRequired(true, 'deliveryMethod')" v-select2="{placeholder: 'Select a Delivery Method', allowClear: isRequired(true, 'deliveryMethod') === false }" v-model="formData.delivery_method_id"
                                id="delivery-method-id" class="form-control"
                                name="delivery_method_id" :required="isRequired(true, 'deliveryMethod')">
                            <option></option>
                            <option v-for="deliveryMethod in getDeliveryMethods()"
                                    :data-select2-description="deliveryMethod.description" :value="deliveryMethod.id" :key="deliveryMethod.id">By {{
                                deliveryMethod.name
                                }}
                            </option>
                        </select>
                        <small class="form-text text-muted">
                            By what means the document was sent or received
                        </small>
                    </div>

                    <div
                        v-if="getDeliveryMethod() && (getDeliveryMethod().has_outside_country_days || getDeliveryMethod().has_outside_state_days)"
                        class="form-group mb-4">
                        <label>I received/sent the document:</label>

                        <div class="custom-control custom-radio">
                            <input v-model="formData.delivery_area" type="radio" id="delivery-area-inside-state"
                                name="delivery_area" class="custom-control-input" value="0">
                            <label class="custom-control-label" for="delivery-area-inside-state">inside the state</label>
                        </div>

                        <div v-if="getDeliveryMethod().has_outside_state_days" class="custom-control custom-radio">
                            <input v-model="formData.delivery_area" type="radio" id="delivery-area-outside-state"
                                name="delivery_area" class="custom-control-input" value="2">
                            <label class="custom-control-label" for="delivery-area-outside-state">outside the state</label>
                        </div>

                        <div v-if="getDeliveryMethod().has_outside_country_days" class="custom-control custom-radio">
                            <input v-model="formData.delivery_area" type="radio" id="delivery-area-outside-country"
                                name="delivery_area" class="custom-control-input" value="1">
                            <label class="custom-control-label" for="delivery-area-outside-country">outside the
                                country</label>
                        </div>
                    </div>
                </template>

                <div v-if="getDeliveryMethod() && getDeliveryMethod().warning" class="form-group mb-4">
                    <div class="alert border-left-0 border-right-0 alert-wide alert-squared alert-warning"
                        v-html="getDeliveryMethod().warning">
                    </div>
                </div>

                <template v-for="question in getDeadlineQuestions()">
                    <div :key="question.modelKey" class="form-group mb-4">
                        <label class="font-weight-bold" :for="question.modelKey">
                            {{ question.question }} 
                            <i
                                v-if="question.help"
                                data-toggle="tooltip"
                                data-placement="top"
                                :title="question.help"
                                class="fa fa-question-circle-o help ml-1"
                            ></i>
                            <small v-if="isRequired(!question.optional) == false" class="text-muted">(optional)</small>
                        </label>
                        <input
                            v-model="formData[question.modelKey]"
                            v-datetimepicker="{ ...question.dateOptions, altInputClass: 'form-control bg-white input flatpickr-input' }"
                            type="text"
                            :name="question.modelKey"
                            :class="{
                                'form-control bg-white': true,
                                'is-invalid': hasError(question.modelKey),
                                'holiday-warning': getHolidayName(formData[question.modelKey]) && getErrors(question.modelKey).length === 0
                            }"
                            :id="question.modelKey"
                            :required="isRequired(!question.optional)"
                        >
                        <span v-if="getHolidayName(formData[question.modelKey]) && getErrors(question.modelKey).length === 0" class="invalid-feedback d-block text-holiday-warning">
                            Selected date falls on {{ getHolidayName(formData[question.modelKey]) }}
                        </span>
                        <span v-for="error, index in getErrors(question.modelKey)" class="invalid-feedback" :key="index">
                            {{ error }}
                        </span>
                    </div>
                </template>
                <div v-for="date_question in getDateQuestions()" 
                    class="form-group mb-4"
                    :key="date_question.id"
                >
                    <label class="font-weight-bold" :for="getDateQuestionKey(date_question.id)">
                        {{ date_question[`question_${formData.type}`] }}
                        <small v-if="isRequired(date_question.required) === false" class="text-muted">(optional)</small>
                    </label>
                    <input
                        v-datetimepicker="getDateQuestionSelect2Options(date_question)"
                        v-model="formData[getDateQuestionKey(date_question.id)]"
                        type="text"
                        :required="isRequired(date_question.required)"
                        :name="getDateQuestionKey(date_question.id)"
                        :class="{
                            'form-control bg-white': true,
                            'is-invalid': hasError(getDateQuestionKey(date_question.id)),
                            'holiday-warning': getHolidayName(formData[getDateQuestionKey(date_question.id)]) && getErrors(getDateQuestionKey(date_question.id)).length === 0
                        }"
                        :id="getDateQuestionKey(date_question.id)"
                    >
                    <span v-if="getHolidayName(formData[getDateQuestionKey(date_question.id)]) && getErrors(getDateQuestionKey(date_question.id)).length === 0" class="invalid-feedback d-block text-holiday-warning">
                        Selected date falls on {{ getHolidayName(formData[getDateQuestionKey(date_question.id)]) }}
                    </span>
                    <span v-for="error, index in getErrors(getDateQuestionKey(date_question.id))" class="invalid-feedback" :key="index">
                        {{ error }}
                    </span>
                </div>
                <div v-if="getDocumentType() && getDocumentType().ask_hearing_courthouse" class="form-group mb-4">
                    <label class="font-weight-bold" for="hearing-courthouse">Hearing Courthouse <small class="text-muted">(optional)</small></label>
                    <input v-model="formData.hearing_courthouse"
                        type="text" name="hearing_courthouse" id="hearing-courthouse"
                        :class="{'form-control bg-white': true, 'is-invalid': hasError('formData.hearing_courthouse')}">
                </div>

                <div v-if="getDocumentType() && getDocumentType().ask_hearing_courtroom" class="form-group mb-4">
                    <label class="font-weight-bold" for="hearing-courtroom">Hearing Courtroom <small class="text-muted">(optional)</small></label>
                    <input v-model="formData.hearing_courtroom"
                        type="text" name="hearing_courtroom" id="hearing-courtroom"
                        :class="{'form-control bg-white': true, 'is-invalid': hasError('formData.hearing_courtroom')}">
                    <span v-for="error, index in getErrors('formData.hearing_courtroom')" class="invalid-feedback" :key="index">
                        {{ error }}
                    </span>
                </div>

                <div v-if="getDocumentType() && getDocumentType().requires_same_judge" class="form-group mb-4">
                    <div class="custom-control custom-checkbox">
                        <input name="same_judge" type="hidden" class="custom-control-input" value="0">
                        <input name="same_judge" type="checkbox" v-model="formData.same_judge" class="custom-control-input" id="same-judge" value="1">
                        <label class="custom-control-label" for="same-judge">This hearing to be conducted by the same judge that is assigned for all purposes
                            to this case</label>
                    </div>
                </div>
                <button ref="btn" type="submit" class="btn btn-orange-soda w-100 font-weight-bold rounded-m">
                    Get Deadlines and Best Practices
                </button>
                <p class="text-muted text-center mt-1">By using WikiDeadlines, 
                    <a href="#terms-of-use">you agree to these terms</a>
                </p>
                <pay-calculation-modal
                    v-if="canCalculate === false"
                    v-on:search="onPayForSearch"
                    :trigger-hash="paymentHash" :subscription-link="pricingLinkPage"
                >
                </pay-calculation-modal>
            </form>
        </div>
    </div>
</template>

  <style scoped> 
    .document-tabs {
        border-radius: 10px;
        display: flex;
        flex-wrap: nowrap;
        list-style-type: none;
        padding: 0;
        margin: 0;
        /* border: 1px solid #343a40; */
    }

    .document-tabs__item {
        display: inline-block;
    }

    .document-tabs .document-tabs__item:last-child {
        margin-left: 2px;
    }

    .document-tabs__button {
        text-decoration: none;
        border-radius: 8px;
        padding: 6px 27.7px !important;
    }

    /* .document-tabs__button:hover, .document-tabs__button:focus  {
        background-color: #343a40;
        color: #fff;
    } */

    .document-tabs__button_active {
    background-color: #fff !important;
    color: #000 !important;
    border: 3px solid #000;
    border-bottom-color: #00000000;
    border-radius: 0;
   
}
ul.document-tabs {
    border-radius: 0px !important;
}
li.document-tabs__item {
    margin-bottom: -3px;
}
button.btn.document-tabs__button {
    background-color: #2d76f9;
    color: #fff;
}
.document-tabs__button {
    border-radius: 5px 5px 0px 0px !important;
}
.form-border {
    border-bottom: 3px solid #000;
}
button.btn.document-tabs__button.document-tabs__button_active:focus {
    display: none;
}
    

</style> 

<script>
    import AddDocumentInterview from "./Interviews/AddDocument";
    import AddJurisdictionInterview from "./Interviews/AddJurisdiction";
    import TermsOfUse from "./TermsOfUse";
    import CountyInfo from './CountyInfo';
    import deadlineQuestions from '../deadlineQuestions';
    import PayCalculationModal from './PayCalculationModal';
    import CaseNameSelect from './CaseNameSelect';

    export default {
        components: {
            CountyInfo,
            TermsOfUse,
            AddDocumentInterview,
            AddJurisdictionInterview,
            PayCalculationModal,
            CaseNameSelect
        },
        props: {
            calculation: {
                required: false,
                type: Object,
            },
            isAttorney: {
                type: Boolean,
                required: false,
                default: false
            },
            authenticated: {
                type: Boolean,
                required: false,
                default: true
            },
            showHummerIcon: {
                type: Boolean,
                required: false,
                default: true
            },
            initialEmail: {
                type: String,
                required: false,
                default: ''
            },
            documentRequest: AddDocumentInterview.props.documentRequest,
            documentElements: AddDocumentInterview.props.documentElements,
            deadlineRuleElements: AddDocumentInterview.props.deadlineRuleElements,
            jurisdictionElements: AddJurisdictionInterview.props.jurisdictionElements,
            pricingLinkPage: {
                type: String,
                required: true
            },
            paymentHash: {
                type: String,
                required: false,
                default: 'payment'
            },
            canCalculate: {
                type: Boolean,
                required: true
            },
            holidays: {
                type: Array,
                required: true,
            },
            documentTypes: {
                type: Array,
                required: true
            },
            locales: {
                type: Object,
                required: true
            },
            states: {
                type: Array,
                required: true
            },
            counties: {
                type: Array,
                required: true
            },
            deliveryMethods: {
                type: Array,
                required: true
            },
            oldFormData: {
                type: Object,
                required: false,
                default: () => {
                    return {};
                }
            },
            errors: {
                type: Object,
                required: false,
                default: () => {
                    return {};
                }
            }
        },
        data() {
            return {
                canChangeJurisdiction: Boolean(this.calculation?.state_id) === false,
                canChangeCounty: Boolean(this.calculation?.county_id) == false,
                ignoreFirstInput: Boolean(this.calculation),
                formData: {
                    type: 'document_received',
                    case_name: this.calculation?.case_name || '',
                    document_type_id: 0,
                    state_id: this.calculation?.state_id || 0, 
                    county_id: this.calculation?.county_id || 0, 
                    delivery_method_id: 0,
                    delivery_area: 0,
                    hearing_courthouse: '',
                    hearing_courtroom: '',
                    same_judge: false
                },
                dateQuestions: []
            };
        },
        watch: {
            'formData.document_type_id': function (documentTypeId) {
                if (typeof documentTypeId !== 'number') {
                    return;
                }

                const documentType = this.getDocumentType();

                documentType.date_questions.forEach(({ id }) => this.ensureDateQuestionModelKeyExists(id));

                window.$data = this.$data;
            }
        },
        methods: {
            onJurisdictionDBClick( ) {
                this.canChangeJurisdiction = true;
            },
            onCountyDBClick( ) {
                this.canChangeCounty = true;
            },
            getProhibitedText() {
                const county = this.counties.find(({ id }) => this.formData.county_id === id);

               return county?.prohibited_e_filing || '';
            },
            getCountyLinks() {
                const county = this.counties.find(({ id }) => this.formData.county_id === id);

               return county?.links || [];
            },
            displayWarning() {
                return Boolean(this.getCountyWarning()) || this.getCountyLinks().length > 0;
            },
            getCountyWarning() {
                const county = this.counties.find(({ id }) => this.formData.county_id === id);

                if (!county) {
                    return null;
                }

                if (['mandatory', 'permissive'].includes(county.e_filing) && this.isAttorney) {
                    return {
                        status: county.e_filing
                    };
                }

                if (['mandatory'].includes(county.e_filing) && this.isAttorney === false) {
                    return {
                        status: 'available'
                    };
                }

                return null;
            },
            getDocumentTypeSelect2Options() {
                return {
                    placeholder: 'Search Pleadings and Documents by Title',
                    language: {
                        noResults: function() {
                            const $container = $('<span>', { text: 'Not found. ' });
                            const $link =  $('<a>', { href: '#document', text: 'Click here to add new document', click: () => {
                                const mouseDownEvent = new MouseEvent('mousedown');
                                document.querySelector('body').dispatchEvent(mouseDownEvent);
                            } });
                            return $container.append($link);
                        }
                    }
                }
            },
            getDateQuestionSelect2Options(date_question) {
                console.log(date_question);
                const options = {
                    onlyDate: date_question.date_question_type.type !== 'datetime',
                    todayMidday: true,
                    autoFillDefaultTime: this.isRequired(date_question.required),
                    altInputClass: 'form-control bg-white input flatpickr-input'
                };

                if (['ftds', 'td'].includes(date_question.reference_key)) {
                    options.defaultHour = 8;
                }

                return options;
            },
            isRequired(defaultValue, caseName) {
                if (
                    caseName === 'deliveryMethod' &&
                    this.formData.type === 'document_received'
                ) {
                    return false;
                }

                if (this.formData.type === 'document_to_send') {
                    return false;
                }

                return defaultValue;

            },
            getHolidayName(date) {
                // TODO: here we don't take into account time zones
                // We assume that users always put datetime in a selected state's time zone
                // but as we keep time if holidays in the database the whole logic seems to be ambiguous
                // it should be redesigned
                const momentDate = moment(date);

                if ([0, 6].includes(momentDate.day())) {
                    return momentDate.format('dddd');
                }

                const state = this.holidays.find((state) => this.formData.state_id === state.id);

                if (!state) {
                    return null;
                }

                const holiday = state.holidays.find(({ date }) => moment(date).isSame(momentDate, 'day'));

                if (holiday) {
                    return holiday.name;
                }


                return null;
            },
            handleCaseNameInput(value, result) {
                this.formData.hearing_courthouse = result?.hearing_courthouse || this.formData.hearing_courthouse;
                this.formData.hearing_courtroom = result?.hearing_courtroom || this.formData.hearing_courtroom;
                this.formData.county_id = result?.county_id || this.formData.county_id;
                this.formData.state_id = result?.state_id || this.formData.state_id; 

                if (this.ignoreFirstInput === true) {
                    this.ignoreFirstInput = false;
                    return;
                }

                this.canChangeJurisdiction = Boolean(!result || result?.isCreateTag) === true;
                this.canChangeCounty = Boolean(!result || result?.isCreateTag) === true;
            },
            getCountiesForCurrentState() {
                return this.counties.filter(({ state_id }) => state_id === this.formData.state_id);
            },
            onDocumentReceivedClick() {
                this.formData.type = 'document_received';
            },
            onDocumentToSendClick() {
                this.formData.type = 'document_to_send';
            },
            onPayForSearch() {
                this.$refs.btn.click();
            },
            isQuestionExcluded(key) {
                // https://app.asana.com/0/0/1202045469529179/1202088827516023/f
                return this.formData.type === 'document_to_send' && ['fcd', 'dps'].includes(key);
            },
            getDeadlineQuestions() {
                const deadlineQeustions = [];

                const document = this.getDocumentType();

                if (!document) {
                    return deadlineQeustions;
                }

                for (const deadlineQuestion of deadlineQuestions) {
                    const deliveryMethod = this.getDeliveryMethod();

                    if (
                        deliveryMethod &&
                        deliveryMethod.reference_key === 'personal_service' &&
                        deadlineQuestion.modelKey === 'dps'
                    ) {
                        continue;
                    }

                    if (this.isQuestionExcluded(deadlineQuestion.modelKey)) {
                        continue;
                    }

                    if (!document[`requires_${deadlineQuestion.modelKey}`]) {
                        continue;
                    }

                    const questionText = this.locales[deadlineQuestion.modelKey][this.formData.type];
                    const help = this.locales[deadlineQuestion.modelKey]['help'];

                    if (!deadlineQuestion.before || document.date_questions.length === 0) {
                        const data = {
                            question: questionText,
                            ...deadlineQuestion
                        };

                        if (!data.dateOptions) {
                            data.dateOptions = {};
                        }

                        data.dateOptions.autoFillDefaultTime = this.isRequired(!data.optional);

                        deadlineQeustions.push({ question: questionText, help, ...deadlineQuestion });
                        continue;
                    }

                    for (const before of deadlineQuestion.before) {
                        const dateQuestion = document.date_questions.find(({ reference_key }) => reference_key === before);

                        if (!dateQuestion) {
                            continue;
                        }
            
                        deadlineQeustions.push({
                            modelKey: this.getDateQuestionKey(dateQuestion.id),
                            question: dateQuestion[`question_${this.formData.type}`],
                            optional: !dateQuestion.required,
                            dateOptions: {
                                onlyDate: dateQuestion.date_question_type.type !== 'datetime',
                                todayMidday: true,
                                autoFillDefaultTime: this.isRequired(dateQuestion.required)
                            }
                        })
                    }

                    deadlineQeustions.push({ question: questionText, help, ...deadlineQuestion });
                }

                return deadlineQeustions;
            },
            getDateQuestions() {
                const dateQuestions = [];
                const document = this.getDocumentType();

                if (!document) {
                    return dateQuestions;
                }

                if (!document.date_questions) {
                    return dateQuestions;
                }

                document.date_questions.forEach((question) => {
                    if (this.isQuestionExcluded(question.reference_key)) {
                        return;
                    }

                    if (!question.reference_key) {
                        dateQuestions.push(question);
                        return;
                    }

                    const deliveryMethod = this.getDeliveryMethod();

                    if (
                        deliveryMethod &&
                        deliveryMethod.reference_key === 'personal_service' &&
                        question.reference_key === 'dps'
                    ) {
                        return;
                    }

                    let shouldPush = true;

                    for (const deadlineQuestion of deadlineQuestions) {
                        if (!deadlineQuestion.before) {
                            continue;
                        }

                        if (deadlineQuestion.before.includes(question.reference_key)) {
                            shouldPush = false;
                            break;
                        }
                    }

                    if (shouldPush) {
                        dateQuestions.push(question);
                    }
                });

                return dateQuestions;
            },
            initializeTooltips() {
                this.$nextTick(() => {
                    $(this.$refs.body).find('.help').tooltip();
                });
            },
            hasError(fieldName) {
                return !!this.errors[fieldName];
            },
            getErrors(fieldName) {
                return (this.errors[fieldName]) || [];
            },
            getDeliveryMethods() {
                const documentType = this.getDocumentType();
                
                if (!documentType) {
                    return [];
                }

                if (this.formData.type === 'document_received' || 'document_to_send') {
                    return this.deliveryMethods;
                }


                return this.deliveryMethods.filter((deliveryMethod) => {
                    return documentType.delivery_method_ids.indexOf(deliveryMethod.id) !== -1;
                });
            },
            getDeliveryMethod() {
                if (!this.getDocumentType() || !this.getDocumentType().requires_delivery_method) {
                    return null;
                }

                return this.deliveryMethods.find((deliveryMethod) => {
                    return deliveryMethod.id === this.formData.delivery_method_id;
                });
            },
            getDocumentType() {
                return this.documentTypes.find((documentType) => {
                    return documentType.id === this.formData.document_type_id;
                });
            },
            applyOldFormData() {
                for (const key in this.formData) {
                    if (key in this.oldFormData) {
                        if (typeof this.formData[key] === 'boolean') {
                            this.formData[key] = !!parseInt(this.oldFormData[key], 10);
                        } else if (typeof this.formData[key] === 'number') {
                            this.formData[key] = parseInt(this.oldFormData[key], 10);
                        } else {
                            this.formData[key] = this.oldFormData[key];
                        }
                    }
                }
            },
            submit(e) {
                if (this.canCalculate) {
                    return;
                }

                if (location.hash === `#${this.paymentHash}`) {
                    return;
                }

                e.preventDefault();
                location.hash = this.paymentHash;
            },
            getDateQuestionKey(id) {
                return `date_question_${id}`;
            },
            ensureDateQuestionModelKeyExists(id) {
                const key = this.getDateQuestionKey(id);

                if (this.formData[key] !== undefined) {
                    return;
                }

                this.$set(this.formData, key, '');
            },
            applyDefault() {
                const defaultState = this.states.find(state => state.preselected);
                this.formData.state_id = defaultState ? defaultState.id : 0;

                // const defaultDeliveryMethod = this.deliveryMethods.find(deliveryMethod => deliveryMethod.preselected);
                // this.formData.delivery_method_id = defaultDeliveryMethod ? defaultDeliveryMethod.id : 0;

                const hearingDate = moment()
                    .add(25, 'days')
                    .hours(8)
                    .minutes(30)
                    .seconds(0)
                    .format('YYYY-MM-DD\\\\THH:mm:ss.SSSZ');

                this.$set(this.formData, 'hd', hearingDate);
         
                deadlineQuestions.forEach(({ modelKey }) => {
                    this[modelKey] = '';
                })
            }
        },
        created() {
            this.applyDefault();
            this.applyOldFormData();
            this.initializeTooltips();
        },
        mounted() {
            this.$forceUpdate();
        },
        updated: function () {
            this.initializeTooltips();
        }
    }
</script>
