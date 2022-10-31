<template>
    <modal-question ref="modal" v-on:confirm="confirm" :trigger-hash="triggerHash" :loading="loading">
        Do you want to delete this delivery method?
    </modal-question>
</template>

<script>
    import ModalQuestion from './Modal/ModalQuestion';
    import { client } from '../client';

    export default {
        props: {
            triggerHash: ModalQuestion.props.triggerHash,
            id: {
                type: Number,
                required: true
            }
        },
        components: {
            ModalQuestion
        },
        data() {
            return {
                loading: false
            };
        },
        methods: {
            async confirm() {
                this.loading = true;
                const response = await client.deleteDeliveryMethod(this.id);
                toaster.add('Delivery method deleted', 'Delivery method has been successfully deleted');
                this.loading = false;
                this.$refs.modal.close();

                location.href = response.data.redirect_to;
            }
        }
    }
</script>
