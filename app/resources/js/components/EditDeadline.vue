<template>
    <modal :trigger-hash="triggerHash">
        <modal-header-primary :lines="['Interview']"></modal-header-primary>
        <modal-body>
            <div class="d-flex justify-content-end">
                <a target="_blank" :href="externalPageLink">{{ externalPageText }} <i class="fa fa-external-link"></i></a>
            </div>
            <template
                v-for="data, index in interview"
            >
                <section
                    class="py-3 px-2"
                    :key="index"
                    :style="`${isHighlighted() ? 'background-color: rgba(0, 0, 0, 0.05)' : ''}`"
                    v-if="data.value"
                >
                    <h6 class="font-weight-bold">{{ `${getOrderNumber()}. ${data.title }` }}</h6>
                    <p class="m-0">
                        <pre v-if="isPreFormatted(data)" style="white-space: pre-wrap;font-size:inherit;font-family:inherit;">{{ Array.isArray(data.value) ? data.value.join(', ') : data.value }}</pre>
                        <template v-else>{{ Array.isArray(data.value) ? data.value.join(', ') : data.value }}</template>
                    </p>
                </section>
            </template>
        </modal-body>
    </modal>
</template>

<script>
    import Modal from './Modal/Modal';
    import ModalHeaderPrimary from './Modal/ModalHeaderPrimary';
    import ModalBody from './Modal/ModalBody';

    export default {
        props: {
            triggerHash: Modal.props.triggerHash,
            interview: {
                type: Array,
                required: false
            },
            externalPageLink: {
                type: String,
                required: false
            },
            externalPageText: {
                type: String,
                required: false
            }
        },
        components: {
            Modal,
            ModalBody,
            ModalHeaderPrimary
        },
        data() {
            return {
                isLoading: true,
                isSaving: false
            }
        },
        methods: {
            isHighlighted() {
                this.isGray = !this.isGray;
                return this.isGray;
            },
            getOrderNumber() {
                if (!this._order_cache) {
                    this._order_cache = 0;
                }

                return ++this._order_cache;
            },
            isPreFormatted(interview) {
                return interview?.meta?.key === 'best-practice';
            }
        }
    }
</script>
