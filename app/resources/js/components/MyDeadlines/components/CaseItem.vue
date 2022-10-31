<template>
    <div>
        <a :href="`#${getHashForCalculation(calculation)}`" :data-name="calculation.case_name" class="py-3 btn btn-history d-flex align-self-center justify-content-between">
            <b>
                <i v-if="pinned" class="fa fa-map-pin mr-3 text-primary" style="transform: rotate(45deg);" aria-hidden="true"></i>
                {{ calculation.case_name }}
            </b>
            <span>
                #{{ calculation.all_count }}
            </span>
        </a>
        <case-deadlines-modal :calculation="calculation" :trigger-hash="getHashForCalculation(calculation)"></case-deadlines-modal>
    </div>
</template>

<script>
    import CaseDeadlinesModal from './CaseDeadlinesModal';

    export default {
        components: {
            CaseDeadlinesModal
        },
        props: {
            pinned: {
                type: Boolean,
                required: false
            },
            calculation: {
                type: Object,
                required: true
            }
        },
        methods: {
            getHashForCalculation(calculation) {
                return `calculations-${encodeURIComponent(calculation.case_name)}`
            },
        }
    }
</script>
