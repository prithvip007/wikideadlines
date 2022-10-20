<template>
    <modal :trigger-hash="triggerHash">
            <modal-header-primary :lines="['County Information']"></modal-header-primary>
            <modal-body>
                <section class="mb-4" v-if="prohibited">
                    <h6 class="mb-3">Prohibited Document From E-Filing:</h6>
                    <p class="text-muted">
                        <pre style="white-space: pre-wrap;font-size: inherit;font-family: inherit;">{{ prohibited }}</pre>
                    </p>
                </section>
                <section v-if="links.length > 0">
                    <h6 class="mb-3">Useful links:</h6>
                    <a target="_blank" rel="noopener noreferrer" class="d-block" v-for="(link, index) in links" :key="index" :href="link.url">{{ link.title }}</a>
                </section>
            </modal-body>
            <modal-footer-button v-on:click="onReturnClick">
                Return
            </modal-footer-button>
    </modal>
</template>
<style></style>
<script>
import Modal from './Modal/Modal';
import ModalHeaderPrimary from './Modal/ModalHeaderPrimary';
import ModalBody from './Modal/ModalBody';
import ModalFooterButton from './Modal/ModalFooterButton';

export default {
    components: {
        Modal,
        ModalHeaderPrimary,
        ModalFooterButton,
        ModalBody
    },
    props: {
        triggerHash: {
            type: String
        },
        prohibited: {
            type: String,
            required: false,
            default: null
        },
        links: {
            type: Array,
            required: false,
            default: () => []
        }
    },
    methods: {
        onReturnClick() {
            location.hash = '';
        }
    }
};
</script>
