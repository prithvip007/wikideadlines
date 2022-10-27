<template>
    <modal ref="modal" :trigger-hash="triggerHash">
        <modal-header-primary :lines="['Confirm deleting']"></modal-header-primary>
        <modal-body>
            <slot></slot>
        </modal-body>
        <modal-footer>
            <button :disabled="loading" type="button" v-on:click="close" class="btn btn-primary ml-4">No</button>
            <button :disabled="loading" v-on:click="$emit('confirm')" type="button" class="btn btn-danger">
                <template v-if="!loading">
                    Yes
                </template>
                <i v-else class="fa fa-spinner fa-spin"></i>
            </button>
        </modal-footer>
    </modal>
</template>

<script>
    import Modal from './Modal';
    import ModalHeaderPrimary from './ModalHeaderPrimary';
    import ModalFooter from './ModalFooter';
    import ModalBody from './ModalBody';

    export default {
        props: {
            triggerHash: Modal.props.triggerHash,
            loading: {
                type: Boolean,
                required: false,
                default: false
            }
        },
        components: {
            Modal,
            ModalBody,
            ModalHeaderPrimary,
            ModalFooter
        },
        methods: {
            close() {
                this.$refs.modal.close();
            }
        }
    }
</script>
