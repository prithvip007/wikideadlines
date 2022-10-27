<template>
    <modal v-on:hide="handleModalHide" ref="modal" :trigger-hash="triggerHash">
        <modal-header-primary
            :lines="
                isDocumentSubmitted && isAddingRule
                    ? ['Enter a deadline rule (and best practice) for:', this.documentTitle]
                    : isDocumentSubmitted
                        ? ['Enter a new deadline rule']
                        : ['Add a new pleading, notice, or other document']
            "
        >
        </modal-header-primary>
        <template v-if="isDocumentSubmitted">
            <interview-form
                :request-id="documentRequestId"
                v-if="isAddingRule"
                :email-initial-value="email"
                v-on:submitted="handleDeadlineRuleSubmitted"
                type="add_deadline"
                :elements="deadlineRuleElementsWithDefaultValues"
                :exclude-items="this.excludeRuleItems"
                :exclude-elements="['document-title']"
            ></interview-form>
            <template v-else>
                <modal-body>
                    <div class="text-center">
                        <p>
                            {{
                                isRuleAdded
                                    ? 'Thanks for adding a deadline rule!'
                                    : 'Thanks for adding a new document type!'
                            }}
                        </p>
                        <p>
                            Would you like to add {{ isRuleAdded ? 'another' : 'a' }} deadline rule to 
                            <span class="d-block"> {{ documentTitle || 'the suggested document' }}</span>
                        </p>
                    </div>
                </modal-body>
                <modal-footer-button v-on:click="handleAddDeadlineRuleClick" type="button">
                    Add a deadline rule
                </modal-footer-button>
            </template>
        </template>
        <interview-form
            v-else
            :email-initial-value="email"
            v-on:submitted="handleDocumentSubmitted"
            type="document_type"
            :elements="documentElements"
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
            documentRequest: {
                type: Object,
                required: false
            },
            triggerHash: {
                type: String,
                required: true
            },
            documentElements: {
                type: Array,
                required: true
            },
            initialEmail: {
                type: String,
                required: false,
                default: ''
            },
            deadlineRuleElements: {
                type: Array,
                required: true
            }
        },
        data() {
            if (this.documentRequest) {
                return Object.assign(this.getInitialState(), {
                    documentRequestId: this.documentRequest['documentRequestId'],
                    isDocumentSubmitted: true,
                    isAddingRule: true,
                    documentTitle: this.documentRequest['documentTitle']
                });
            } else {
                return this.getInitialState();
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
            }
        },
        methods: {
            handleDocumentSubmitted(fields, email, documentRequestId) {
                this.documentTitle = fields['document-title'];
                this.email = email;
                this.documentRequestId = documentRequestId;

                this.handleRuleExcludedItems(fields);

                this.isDocumentSubmitted = true;
            },
            handleDeadlineRuleSubmitted(fields, email) {
                this.documentTitle = fields['document-title'];
                this.email = email;

                this.isAddingRule = false;
                this.isRuleAdded = true;
            },
            handleAddDeadlineRuleClick() {
                this.isAddingRule = true;
            },
            handleModalHide() {
                setTimeout(() => {
                    Object.assign(this, this.getInitialState());
                }, 1000);
            },
            handleRuleExcludedItems(fields) {
                const selectedJurisdiction = fields['jurisdiction'];
                const jurisdictionElement = this.documentElements.find(({ key }) => key === 'jurisdiction');

                if (!jurisdictionElement) {
                    return;
                }

                const stateItem = jurisdictionElement.data.items.find(({ key }) => key === 'jurisdiction-state');

                if (!stateItem) {
                    return;
                }

                const stateTitle = stateItem.title;

                if (selectedJurisdiction === stateTitle) {
                    this.excludeRuleItems.push('authority-source-frcp');
                }
    
            },
            getInitialState() {
                return {
                    documentRequestId: null,
                    isDocumentSubmitted: false,
                    isAddingRule: false,
                    isRuleAdded: false,
                    documentTitle: '',
                    excludeRuleItems: [],
                    email: this.initialEmail
                }
            }
        },
    }
</script>
