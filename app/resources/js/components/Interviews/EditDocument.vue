<template>
    <modal ref="modal" :trigger-hash="triggerHash">
        <modal-header-primary
            :lines="['Suggest Edits for This Document']"
        >
        </modal-header-primary>
        <interview-form
            :document-id="documentId"
            :email-initial-value="email"
            v-on:submitted="handleDocumentSubmitted"
            type="edit_document_type"
            :elements="documentElements"
            :exclude-elements="['standard-motion-briefing']"
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
            documentId: {
                type: Number,
                required: true
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
            }
        },
        data() {
            return {
                email: this.initialEmail
            };
        },
        methods: {
            handleDocumentSubmitted(fields, email) {
                toaster.add('Edit Document', 'Edit document request has been successfully submitted');
                this.$refs.modal.close();
            }
        },
    }
</script>
