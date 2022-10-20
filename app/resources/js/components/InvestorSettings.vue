<template>
    <div class="row">
        <section class="col-12">
            <h5>Become a WikiDeadlines investor</h5>
            <p>WikiDeadlines, LLC currently is selling Member Units each for USD $2. <br>
            Minimum investment is $5,000.</p>
        </section>
        <section v-if="delayDays === 0" class="col-12">
            <hr>
            <p>
                If you'd like to join our investor team, enter your name and email and we will send you the pitch deck:
            </p>

            <form @submit.prevent="handleSubmit">
                <div class="row">
                    <div class="form-group col-12 col-md-4">
                        <label class="font-weight-bold" for="first-name">First Name</label>
                        <input
                            v-model="form.first_name"
                            required
                            name="first_name"
                            id="first-name"
                            :class="{'is-invalid': hasError('first_name')}"
                            class="form-control"
                        > 
                        <span :key="error" v-for="error in getErrors('first_name')" class="invalid-feedback">
                            {{ error }}
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-md-5">
                        <label class="font-weight-bold" for="last-name">
                            Last Name
                            <small class="text-muted">
                                (optional)
                            </small>
                        </label>
                        <input
                            v-model="form.last_name"
                            name="last_name"
                            id="last-name"
                            class="form-control"
                            :class="{'is-invalid': hasError('last_name')}"
                        > 
                        <span :key="error" v-for="error in getErrors('last_name')" class="invalid-feedback">
                            {{ error }}
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-md-8">
                        <label class="font-weight-bold" for="email">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            required
                            name="email"
                            id="email"
                            class="form-control"
                            :class="{'is-invalid': hasError('email')}"
                        >
                        <span :key="error" v-for="error in getErrors('email')" class="invalid-feedback">
                            {{ error }}
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-md-4">
                        <button :disabled="isSubmiting" type="submit" class="btn btn-orange-soda w-100 text-uppercase d-flex align-items-center justify-content-center rounded-m">
                            send
                            <div v-if="isSubmiting" class="spinner-border spinner-border-sm ml-2" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </section>
        <section class="col-12" v-else>
            <hr>
            <p class="px-md-5 text-left text-md-center">
                You have already sent a request to become a WikiDeadlines investor.<br>
                You will be able to send a new request in <strong> {{ delayDays }} day{{ delayDays > 1 ? 's' : '' }} </strong>
            </p>
        </section>
    </div>
</template>

<script>
    import { client } from '../client';

    export default {
        props: {
            nextApplicationDays: {
                type: Number,
                required: true,
                default: 0
            },
            user: {
                type: Object,
                required: false,
                default: null
            }
        },
        data() {
            return {
                form : {
                    first_name: '',
                    last_name: '',
                    email: this?.user?.email ?? ''
                },
                isSubmiting: false,
                delayDays: this.nextApplicationDays,
                errors: []
            }
        },
        methods: {
           async handleSubmit() {
                this.isSubmiting = true;
                this.errors = [];

                try {
                    const response = await client.applyToBeInvestor(this.form);

                    this.delayDays = response.data.data.delay_days;

                    toaster.add('Successful application', 'Thank you. We will respond shortly.');
                } catch (e) {
                    if (e?.response?.data?.errors) {
                        this.errors = e.response.data.errors;
                    } else {
                        console.error(e);
                    }
                } finally {
                    this.isSubmiting = false;
                }
            },
            hasError(fieldName) {
                return !!this.errors[fieldName];
            },
            getErrors(fieldName) {
                return (this.errors[fieldName]) || [];
            },
        }
    }
</script>
