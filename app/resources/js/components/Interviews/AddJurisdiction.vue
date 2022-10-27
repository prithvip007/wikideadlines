<template>
    <modal v-on:hide="handleModalHide" ref="modal" :trigger-hash="triggerHash">
        <modal-header-primary :lines="step === STEPS.JURISDICTION
                ? ['Enter a new jurisdiction']
                : (
                    step === STEPS.DOCUMENT || step === STEPS.DOCUMENT_QUESTION
                        ? ['Add a new pleading, notice, or other document']
                        : STEPS.RULE_QUESTION === step
                            ? ['Enter a new deadline rule']
                            : ['Enter a deadline rule (and best practice) for:', documentTitle]
                )">
        </modal-header-primary>
        <template
            v-if="step === STEPS.DOCUMENT_QUESTION || step === STEPS.RULE_QUESTION"
        >
            <modal-body>
                <div class="text-center">
                    <p>
                        {{
                            step === STEPS.DOCUMENT_QUESTION
                                ? 'Thanks for adding a jurisdiction!'
                                : !isRuleAdded ? 'Thanks for adding a new document type!' : 'Thanks for adding a new deadline rule!'
                        }}
                    </p>
                    <p>
                        Would you like to add {{ step === STEPS.RULE_QUESTION && isRuleAdded ? 'another' : 'a' }}
                        {{
                            step === STEPS.DOCUMENT_QUESTION
                                ? 'document to the suggested jurisdiction?'
                                : 'deadline rule to the suggested document?'
                        }}
                    </p>
                </div>
            </modal-body>
            <modal-footer-button v-on:click="handleNextStep" type="button">
                {{
                    step === STEPS.DOCUMENT_QUESTION ? 'Add a document' : 'Add a deadline rule'
                }}
            </modal-footer-button>
        </template>
        <interview-form
            v-else-if="step === STEPS.DOCUMENT"
            :email-initial-value="email"
            v-on:submitted="handleNextStep"
            type="document_type"
            :elements="documentElementsWithDefaultValues"
        ></interview-form>
        <interview-form
            v-else-if="step === STEPS.RULE"
            :email-initial-value="email"
            v-on:submitted="handleNextStep"
            :exclude-elements="['document-title']"
            type="add_deadline"
            :elements="deadlineRuleElementsWithDefaultValues"
        ></interview-form>
        <interview-form
            v-else
            v-on:submitted="handleNextStep"
            :email-initial-value="email"
            type="jurisdiction"
            :elements="jurisdictionElements"
        ></interview-form>
    </modal>
</template>

<script>
    import Modal from '../Modal/Modal';
    import ModalHeaderPrimary from '../Modal/ModalHeaderPrimary';
    import ModalFooterButton from '../Modal/ModalFooterButton';
    import ModalBody from '../Modal/ModalBody';
    import InterviewForm from '../Modal/InterviewForm';

    export default {
        components: {
            Modal,
            ModalHeaderPrimary,
            ModalBody,
            InterviewForm,
            ModalFooterButton,
            ModalBody
        },
        props: {
            initialEmail: {
                type: String,
                required: false,
                default: ''
            },
            triggerHash: {
                type: String,
                required: true
            },
            documentElements: {
                type: Array,
                required: true
            },
            deadlineRuleElements: {
                type: Array,
                required: true
            },
            jurisdictionElements: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                step: 'jurisdiction_form',
                isRuleAdded: false,
                email: this.initialEmail,
                jurisdictionName: '',
                documentTitle: '', 
                STEPS: {
                    DOCUMENT: 'document_form',
                    JURISDICTION: 'jurisdiction_form',
                    RULE: 'rule_form',
                    RULE_QUESTION: 'rule_question',
                    DOCUMENT_QUESTION: 'document_question',
                }
            }
        },
        computed: {
            deadlineRuleElementsWithDefaultValues: function() {
                const elements = JSON.parse(
                    JSON.stringify(
                        this.deadlineRuleElements
                    )
                );

                const element = elements.find(({ key }) => key === 'document-title');

                element.data.defaultValue = this.documentTitle;

                return elements;
            },
            documentElementsWithDefaultValues: function() {
                const elements = JSON.parse(
                    JSON.stringify(
                        this.documentElements
                    )
                );

                const element = elements.find(({ key }) => key === 'jurisdiction-name');

                element.data.defaultValue = this.jurisdictionName;

                const jurisdictionElement = elements.find(({ key }) => key === 'jurisdiction');
                jurisdictionElement.data.defaultValue = jurisdictionElement.data.items.find(({ key }) => key === 'add-court-system').title;

                return elements;
            }
        },
        methods: {
            handleNextStep(fields, email) {
                if (this.step === this.STEPS.JURISDICTION) {
                    this.jurisdictionName = fields['jurisdiction-name'];
                    this.email = email;
                    this.step = this.STEPS.DOCUMENT_QUESTION;
                } else if (this.step === this.STEPS.DOCUMENT_QUESTION) {
                    this.step = this.STEPS.DOCUMENT;
                } else if (this.step === this.STEPS.DOCUMENT) {
                    this.documentTitle = fields['document-title'];
                    this.email = email;
                    this.step = this.STEPS.RULE_QUESTION;
                } else if (this.step === this.STEPS.RULE_QUESTION) {
                    this.step = this.STEPS.RULE;
                } else if (this.step === this.STEPS.RULE) {
                    this.email = email;
                    this.isRuleAdded = true;
                    this.step = this.STEPS.RULE_QUESTION;
                }
            },
            getInitialState() {
                return {
                    step: 'jurisdiction_form',
                    isRuleAdded: false,
                    email: '',
                    jurisdictionName: '',
                    documentTitle: '', 
                    STEPS: {
                        DOCUMENT: 'document_form',
                        JURISDICTION: 'jurisdiction_form',
                        RULE: 'rule_form',
                        RULE_QUESTION: 'rule_question',
                        DOCUMENT_QUESTION: 'document_question',
                    }
                }
            },
            handleModalHide() {
                setTimeout(() => {
                    Object.assign(this, this.getInitialState());
                }, 1000);
            },
        },
    }
</script>
