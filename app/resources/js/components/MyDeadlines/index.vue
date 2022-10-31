<template>
    <div>
        <case-item pinned :calculation="pinned"></case-item>
        <hr>
        <div v-for="calculation, index in calculations" :key="calculation.case_name">
            <case-item :calculation="calculation" :key="index"></case-item>
            <hr v-if="index !== calculations.length - 1">
        </div>
    </div>
</template>

<script>
    import CaseItem from './components/CaseItem.vue';

    export default {
        components: {
            CaseItem
        },
        props: {
            pinned: {
                type: Object,
                required: false
            },
            calculations: {
                type: Array,
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
