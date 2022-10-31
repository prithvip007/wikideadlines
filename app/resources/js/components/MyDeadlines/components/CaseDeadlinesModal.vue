<template>
    <modal @show="loadCalculations" :trigger-hash="triggerHash">
        <modal-header-primary :lines="[calculation.case_name]"></modal-header-primary>
        <modal-body>
            <div class="d-flex justify-content-end px-2">
                <a :href="calculation.add_calculation_url" class="btn btn-link btn-link-orange-soda"><i class="fa fa-lg fa-plus"></i></a>
            </div>
            <ul @scroll="onScroll" class="list-group list">
                <li class="list-group-item list-group-item-action" v-for="item, index in calculations" :key="index">
                    <a class="d-flex justify-content-between align-items-center text-dark" target="_blank" :href="item.url">
                        <span class="d-flex flex-column">
                            <span>{{ item.document }}</span>
                            <small class="text-muted">
                                <b>Calculated at:</b> <span>{{ item.created_at }}</span>
                             </small>
                        </span>
                        <i class="fa fa-external-link" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="d-flex justify-content-center py-2" style="color:#f35f34" v-if="isLoading">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </li>
            </ul>
        </modal-body>
    </modal>
</template>

<style scoped>
    .list {
        max-height: 600px;
        overflow: auto;
    }

    .list a {
        text-decoration: none;
    }
</style>

<script>
    import Modal from '../../Modal/Modal';
    import ModalHeaderPrimary from '../../Modal/ModalHeaderPrimary';
    import ModalBody from '../../Modal/ModalBody.vue';
    import { client } from '../../../client';

    export default {
        props: {
            calculation: {
                type: Object,
                required: true
            },
            triggerHash: Modal.props.triggerHash 
        },
        components: {
            Modal,
            ModalBody,
            ModalHeaderPrimary
        },
        data() {
            return {
                calculations: [],
                more: true,
                currentPage: 0,
                isLoading: false
            }
        },
        methods: {
            onScroll(e) {
                const element = e.currentTarget;

                const offset = element.scrollHeight * 0.3;
                const isScrolledToLoadableArea = Math.abs(element.scrollHeight - element.clientHeight - element.scrollTop) < offset;

                if (isScrolledToLoadableArea) {
                    this.loadCalculations();
                }
            },
            async loadCalculations() {
                if (this.isLoading || this.more === false) {
                    return;
                }

                try {
                    this.isLoading = true;

                    const query = typeof this.calculation.query === 'string' ? this.calculation.query : this.calculation.case_name;

                    const { data } = await client.getCaluclationsByCaseName(query, this.currentPage + 1);

                    this.calculations.push(
                        ...data.results
                    );
                    this.more = data.pagination.more;
                    this.currentPage += 1;
                } catch (e) {
                    console.error(e);
                } finally {
                    this.isLoading = false;
                }
            }
        }
    }
</script>
