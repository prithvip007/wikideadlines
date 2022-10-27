<template>
    <modal :trigger-hash="triggerHash">
            <modal-header-primary :lines="['Terms of Use']"></modal-header-primary>
            <modal-body>
                <section>
                    <h6 class="mb-4">By using WikiDeadlines, you agree to all of the following:</h6>
                    <div class="text-muted" style="font-size: 13px">
                        <p>By using WikiDeadlines, you agree to these terms and understand the deadlines rules being calculated are in process of being validated (by the user community) and that there is no guarantee the rules are valid.</p>
                        <p>We do not recommend you rely on the calculated deadlines at this time and you agree you are using all features of WikiDeadlines at your own risk and with no liability of any kind, whether for general, consequential, or punitive damages or any other type of damages and that you will indemnify and hold WikiDeadlines, and all its shareholders, members, managers, directors, officers, employees, contractors, or agents harmless if you bring any legal action of any kind against WikiDeadlines.</p>
                        <p>You further agree that in any action you may bring against WikiDeadlines, your total damages shall be limited to one U.S. dollar ($1.00) or the total amount you have paid to WikiDeadlines, whichever is less.  In no event shall any party bringing any action against WikiDeadlines, or any of its shareholders, members, managers, directors, officers, employees, contractors, or agents be entitled to any costs or legal fees of any kind, incurred for any purpose.</p>
                        <p>Any action brought for any purpose must be brought in the California Superior Court located in Vista, California.</p>
                    </div>





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
        }
    },
    data() {
        return {
            'f': 1
        };
    },
    methods: {
        onReturnClick() {
            location.hash = '';
        }
    }
};
</script>
