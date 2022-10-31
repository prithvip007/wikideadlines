<template>
    <modal ref="modal" :trigger-hash="triggerHash">
        <modal-header-primary
            :lines="
                type === 'edit_deadline'
                    ? ['Edit this deadline rule (and/or best practice) for:', documentTitle]
                    : ['Enter another deadline rule (and best practice) for:', documentTitle]
            ">
        </modal-header-primary>
        <interview-form
            :email-initial-value="initialEmail"
            :deadline-id="deadlineId"
            :calculation-id="calculationId"
            :document-id="documentId"
            v-on:submitted="handleDeadlineRuleSubmitted"
            :type="type"
            :elements="elements"
            :exclude-elements="documentTitle ? ['document-title'] : []"
            :exclude-items="excludeItems ? excludeItems : []"
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
            type: {
                type: String,
                required: false,
                default: 'add_deadline'
            },
            documentTitle: {
                type: String,
                required: true
            },
            calculationId: InterviewForm.props.calculationId,
            deadlineId: InterviewForm.props.deadlineId,
            documentId: InterviewForm.props.documentId,
            triggerHash: {
                type: String,
                required: true
            },
            excludeItems: {
                type: Array,
                required: false
            },
            initialEmail: {
                type: String,
                required: false
            },
            elements: {
                type: Array,
                required: true
            }
        },
        methods: {
            handleDeadlineRuleSubmitted() {
                const message = {
                    edit_deadline: {
                        title: 'Deadline rule updated',
                        body: 'Deadline rule update request has been successfully submitted'
                    },
                    add_deadline: {
                        title: 'New deadline rule',
                        body: 'New deadline rule request has been successfully submitted'  
                    }
                };

                toaster.add(message[this.type].title, message[this.type].body);
                this.$refs.modal.close();
            }
        },
    }
</script>
