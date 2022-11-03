<template>
    <div class="card-deck text-center">
        <div style="overflow:hidden" class="card mb-4 card-m">
            <div class="card-header" v-bind:class="{ 'bg-white': !isFreeActive(), 'bg-dark': isFreeActive(), 'text-white': isFreeActive() }">
                <h4 class="my-0 font-weight-normal text-capitalize">Basic</h4>
                <img v-if="isFreeActive()" class="pricing-card__selected-icon" src="/images/tick.svg" alt="selected">
            </div>
            <div class="card-body">
                <h1 class="card-title mb-0">Free</h1>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>nes</li>
                    <li>Share deand best practices</li>
                    <li><del>Keep case <del></li>
                    <li><del>Exppple, Outlook, iCal calendars</del></li>
                </ul>
            </div>
        </div>
        <div v-for="plan of plans" :key="plan.interval" style="overflow:hidden" class="card mb-4 card-m">
            <div class="card-header" v-bind:class="{ 'bg-white': !plan.active, 'bg-dark': plan.active, 'text-white': plan.active }">
                <h4 class="my-0 font-weight-normal text-capitalize">{{getPriceData(plan.interval).name }}</h4>
                <img v-if="plan.active" class="pricing-card__selected-icon" src="/images/tick.svg" alt="selected">
            </div>
            <div class="card-body d-flex ">
                <div style="flex: 1 1 auto" class="d-flex flex-column justify-content-between">
                    <div>
                        <h1 class="card-title mb-0">${{ plan.price }}<small class="text-muted text-capitalize">/{{ plan.interval }}</small></h1>
                        <template v-if="getPriceData(plan.interval).priceSubtitles.length">
                            <small
                                v-for="priceSubtitle of getPriceData(plan.interval).priceSubtitles" :key="priceSubtitle"
                                class="text-muted d-block"
                            >
                                {{ priceSubtitle }}
                            </small>
                        </template>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li v-for="description of getPriceData(plan.interval).descriptions" :key="description">{{ description }}</li>
                        </ul>
                    </div>
                    <button
                        v-on:click="handleSelectClick(plan.interval)"
                        :disabled="$data[getFlagName(plan.interval)]"
                        type="button"
                        class="btn btn-lg btn-block btn-outline-warning d-flex align-items-center justify-content-center rounded-m text-dark"
                        :class="{
                            'btn-outline-warning': plan.active === false,
                            'btn-outline-dark': plan.active && !plan.canceled,
                            'btn-outline-success': plan.active && plan.canceled,
                        }"
                    >
                        {{
                            plan.active
                                ? plan.canceled ? 'Renew' : 'Cancel'
                                : plans.some(({ interval, active }) => interval !== plan.interval && active) ? 'Update' : 'Select'
                        }}
                        <div v-if="$data[getFlagName(plan.interval)]" class="spinner-border spinner-border-sm ml-2" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { capitalizeFirstLetter } from '../utils';
    import { client } from '../client';

    export default {
        props: {
            publishableKey: {
                type: String,
                required: true
            },
            plans: {
                type: Array,
                required: true
            },
        },
        data() {
            return this.plans.reduce((accumulator, plan) => {
                const flag = this.getFlagName(plan.interval);
                accumulator[flag] = false;
                return accumulator;
            }, {});
        },
        methods: {
            isFreeActive() {
                return this.plans.every(({ active }) => !active);
            },
            createCheckoutSession(billingPlan) {
                return client.createCheckoutSession({ billing_plan: billingPlan })
                    .then(function(response) {
                        return response.data;
                    });
            },
            getPriceData(interval) {
                if (interval === 'month') {
                    return {
                        name: 'Monthly',
                        priceSubtitles: [],
                        descriptions: [
                            "Calculate deadlines",
                            "Keep case deadline history",
                            "Share deadlines and best practices",
                            "Export deadlines to Google, Apple, Outlook, iCal calendars"
                        ]
                    }
                }

                if (interval === 'year') {
                    return {
                        name: 'Annual',
                        priceSubtitles: ['$14.92/month', '21% discount'],
                        descriptions: [
                            "Calculate deadlines",
                            "Keep case deadline history",
                            "Share deadlines and best practices",
                            "Export deadlines to Google, Apple, Outlook, iCal calendars",
                        ]
                    }
                }

                return {};
            },
            handleSelectClick(billingPlan) {
                const flagField = this.getFlagName(billingPlan);

                this[flagField] = true;

                this.createCheckoutSession(billingPlan).then((data) => {
                    if (data.portal_url) {
                        window.location = data.portal_url;

                        return;
                    }

                    const stripe = new Stripe(this.publishableKey);

                    return stripe
                        .redirectToCheckout({
                            sessionId: data.session_id
                        });
                }).catch((error) => {
                    this[flagField] = false;
                    console.error(error);
                });
            },
            getFlagName(plan) {
                return `isRequesting${capitalizeFirstLetter(plan)}`;
            },
        }
    }
</script>
