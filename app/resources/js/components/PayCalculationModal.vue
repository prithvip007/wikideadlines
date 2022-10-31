<template>
    <modal :trigger-hash="triggerHash">
        <modal-header-primary :lines="['']"></modal-header-primary>
        <modal-body>
            <section class="text-center">
                <h4>You don't have free searches</h4>
                <p class="px-4 pt-2">You have used all your free searches.
                    <br>
                    In order to proceed you can buy a search for $9 or
                    subscribe to get unlimited acceess.
                </p>
            </section>
        </modal-body>
        <modal-footer>
            <div class="d-flex justify-content-center w-100 align-items-center">
                <button v-on:click="$emit('search')" type="button" class="btn btn-orange-soda rounded-m font-weight-bold">
                    Pay $9 for search
                </button>
                <span class="mx-3">or</span>
                <a :href="subscriptionLink">
                    Select Subscription Plan
                </a>
            </div>
        </modal-footer>
    </modal>
</template>

<script>
    import Modal from './Modal/Modal';
    import ModalHeaderPrimary from './Modal/ModalHeaderPrimary';
    import ModalBody from './Modal/ModalBody';
    import ModalFooter from './Modal/ModalFooter';

    export default {
        props: {
            subscriptionLink: {
                type: String,
                required: true
            },
            triggerHash: {
                type: String,
                required: true
            }
        },
        components: {
            Modal,
            ModalHeaderPrimary,
            ModalBody,
            ModalFooter
        }
    }
</script>
