<template>
    <modal-question ref="modal" v-on:confirm="confirm" :trigger-hash="triggerHash" :loading="loading">
        Do you want to delete this deadline rule?
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
                const response = await client.deleteDeadline(this.id);
                toaster.add('Deadline deleted', 'Deadline has been successfully deleted');
                this.loading = false;
                this.$refs.modal.close();

                location.href = response.data.redirect_to;
            }
        }
    }
</script>
