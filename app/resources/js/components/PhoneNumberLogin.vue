<style>
.modal-content, .card.card-m {
    overflow: visible !important;
}
</style>
<template>
    <div style="overflow:hidden;" class="card card-m">
        <h5 v-if="currentStep === PHONE_STEP && mode === 'logging'" class="card-header text-center bg-white">Log in with your phone number</h5>
        <h5 v-if="currentStep === PHONE_STEP && mode === 'signup'" class="card-header text-center bg-white">Sign up with your phone number</h5>
        <modal-header-primary v-if="currentStep === PHONE_STEP && mode === 'update'" :lines="['Phone number change']"></modal-header-primary>
        <h5 v-else-if="currentStep === CODE_STEP" class="card-header text-center bg-white">Verify your phone number</h5>
        <div class="card-body">
            <form @submit.prevent="sendForm" class="p-0 px-md-5 py-md-2">
                <div v-if="currentStep === PHONE_STEP">
                    <div class="form-group d-flex align-items-center flex-column">
                        <div v-if="mode === 'logging'" class="text-center mb-3">Please enter your phone number<br>to log in to WikiDeadlines</div>
                        <div v-if="mode === 'update'"  class="text-center mb-3">Please enter a new phone number<br>that you will use to log in to WikiDeadlines</div>
                        <div v-if="mode === 'signup'" class="text-center mb-3">Please enter your phone number<br>to sign up to WikiDeadlines</div>
                            <vue-phone-number-input border-radius="10" style="overflow: scroll;" class="w-100" size="sm" :no-example="true" autofocus v-on:update="handlePhoneNumberUpdate" autocomplete="tel" required v-model="phone"></vue-phone-number-input>
                        <div v-if="isPhoneNumberValid === false" class="invalid-feedback">
                            Incorrect phone number
                        </div>
                        <div v-for="error in phoneNumberServerErrors" :key="error" class="invalid-feedback d-block">
                            {{ error }}
                        </div>
                    </div>
                    <div class="form-group">
                        <button
                            :disabled="isSendingCode || !internationalPhone"
                            type="submit"
                            
                            class="btn btn-orange-soda w-100 text-uppercase d-flex align-items-center justify-content-center rounded-m"
                        >
                            Next
                            <div v-if="isSendingCode" class="spinner-border spinner-border-sm ml-2" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
                    <slot name="initial-screen-bottom"></slot>
                </div>
                <div v-if="currentStep === CODE_STEP">
                    <div class="form-group d-flex align-items-center flex-column">
                        <div class="text-center mb-3">
                            Enter the verification code we sent to
                            <br>
                            {{ this.getPhoneForRequest() }}
                            <br>
                            <small class="form-text text-muted text-center m-0">
                                <a @click.prevent="handlePhoneEdit" href="#">Edit phone number</a>
                            </small>
                        </div>
                        <input :value="code" @input="verifyCode" pattern="[0-9]+" inputmode="numeric" type="tel" class="form-control"  v-bind:class="{ 'is-invalid': codeServerErrors.length > 0 }" name="code" required autofocus placeholder="Code" autocomplete="off">
                        <div v-for="error in codeServerErrors" v-bind:key="error" class="invalid-feedback">
                            {{ error }}
                        </div>
                    </div>
                    <div class="form-group">
                        <button :disabled="isVerifyingCode" type="submit" class="btn btn-orange-soda rounded-m w-100 text-uppercase d-flex align-items-center justify-content-center">
                            Verify
                            <div v-if="isVerifyingCode" class="spinner-border spinner-border-sm ml-2" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                            <small v-if="resendLeftTimeInSeconds" class="form-text text-muted text-center">
                                You will be able to request SMS in {{ getPrettyTimer() }}
                            </small>
                            <small v-else class="form-text text-muted text-center">
                                Didn't get the code? <a @click.prevent="handleCodeResending" href="#">Resend</a>
                            </small>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import VuePhoneNumberInput from 'vue-phone-number-input';
    import 'vue-phone-number-input/dist/vue-phone-number-input.css';
    import ModalHeaderPrimary from './Modal/ModalHeaderPrimary';
    import { client } from '../client';

    export default {
        components: {
            VuePhoneNumberInput,
            ModalHeaderPrimary
        },
        props: {
            resendTimeoutInSeconds: {
                type: Number,
                default: 60
            },
            mode: {
                type: String,
                default: 'update',
                required: false,
                validator: function (value) {
                    return ['update', 'logging', 'signup'].includes(value)
                }
            }
        },
        data() {
            return this.getInitialData();
        },
        watch: {
            currentStep: function (currentStep) {
                this.codeServerErrors = [];
                this.phoneNumberServerErrors = [];

                // if user moved to the SMS code step, then we should disable ability to request sms code for sometime
                if (currentStep === this.CODE_STEP) {
                    this.startResendTimeout();
                    return
                }

                // if user moved to the step which is different from the SMS code step, we should disable timeout
                this.stopResendTimeout();
            }
        },
        methods: {
            verifyCode(e) {
                const value = e.currentTarget.value.replace(/\D/g, '').slice(0, 100);

                this.code = value;
                e.currentTarget.value = value;
            },
            handlePhoneNumberUpdate(data) {
                this.internationalPhone = data.formattedNumber;
            },
            sendForm() {
                if (this.currentStep === this.PHONE_STEP) {
                    this.handlePhoneStep();
                    return;
                }

                if (this.currentStep === this.CODE_STEP) {
                    this.handleCodeStep();
                    return;
                }
            },
            handlePhoneStep() {
                this.isPhoneNumberValid = this.validatePhoneNumber(this.phone);

                if (this.isPhoneNumberValid === false) {
                    return;
                }

                this.phoneNumberServerErrors = [];

                this.requestCodeSending().then(() => {
                    this.currentStep = this.CODE_STEP;
                }).catch((error) => {
                    if (error?.response?.data?.errors?.phone_number) {
                        this.phoneNumberServerErrors = error.response.data.errors.phone_number;
                    }
                });
            },
            handleCodeStep() {
                this.codeServerErrors = [];

                this.requestCodeVerifying().then(({ data: axiosResponseData }) => {
                    this.$emit('logged-in', axiosResponseData.data);
                }).catch((error) => {
                    console.error(error);

                    if (error?.response?.data?.errors?.sms_code) {
                        this.codeServerErrors = error.response.data.errors.sms_code;
                    }
                });
            },
            handleCodeResending() {
                this.startResendTimeout();

                this.codeServerErrors = [];

                this.requestCodeSending().then((response) => {
                    // handle response 
                    // Probably it would be better to keep all data related to the sent codes
                    // and validate them in bulk in order to be able to prevent race conditions
                    // when sms servicd is lagging
                }).catch(console.error); // we omit error handling here because of global axios handler that displays toaster
            },
            handlePhoneEdit() {
                const data = this.getInitialData({ phone: this.getPhoneForRequest() });
                Object.assign(this.$data, data);
            },
            requestCodeSending() {
                // TODO: probably disable button click and show mouse loader instead of return
                if (this.isSendingCode) {
                    return Promise.reject(new Error('Wait till the previous request is finished'));
                }

                this.isSendingCode = true;

                const method = ['logging', 'signup'].includes(this.mode) ? 'sendCodeToAuthenticateUser' : 'sendCodeToUpdatePhoneNumber';

                return client[method]({
                    phone_number: this.getPhoneForRequest()
                }).finally(() => {
                    this.isSendingCode = false;
                });
            },
            requestCodeVerifying() {
                this.isVerifyingCode = true;

                const method = ['logging', 'signup'].includes(this.mode) ? 'confirmCodeToAuthenticateUser' : 'confirmCodeToUpdatePhoneNumber';

                return client[method]({
                    phone_number: this.getPhoneForRequest(),
                    sms_code: this.code
                }).finally(() => {
                    this.isVerifyingCode = false;
                });
            },
            startResendTimeout() {
                const timestamp = Date.now();

                // when timer is started left time is equal to the maximal time
                this.resendLeftTimeInSeconds = this.resendTimeoutInSeconds;

                this.INTERVAL_ID = setInterval(() => {
                    const currentTimestamp = Date.now();

                    // calculate passed seconds since timer has been started
                    const passedSeconds = Math.round((currentTimestamp - timestamp) / 1000);

                    // if timeout is reached, stop timer
                    if (passedSeconds >= this.resendTimeoutInSeconds) {
                        this.stopResendTimeout();
                        return;
                    }

                    // update left time
                    this.resendLeftTimeInSeconds = this.resendTimeoutInSeconds - passedSeconds;
                }, 1000);
            },
            stopResendTimeout() {
                clearInterval(this.INTERVAL_ID);

                this.INTERVAL_ID = null;
                this.resendLeftTimeInSeconds = 0;
            },
            getPrettyTimer() {
                const minutes = Math.floor(this.resendLeftTimeInSeconds / 60);
                const seconds = Math.floor(this.resendLeftTimeInSeconds % 60);

                const prettyMinutes = minutes < 10 ? `0${minutes}` : minutes;
                const prettySeconds = seconds < 10 ? `0${seconds}` : seconds;

                return `${prettyMinutes}:${prettySeconds}`;
            },
            validatePhoneNumber(phone) {
                phone = phone.trim();

                const regex = /^\+?[\s\dx\(\)\-x]+$/i;
                const isPhoneNumberValid = regex.test(phone);

                return isPhoneNumberValid;
            },
            getPhoneForRequest() {
                return this.internationalPhone;
            },
            getInitialData(data = {}) {
                return Object.assign({
                    currentStep: 0,
                    phone: '',
                    internationalPhone: undefined,
                    code: '',
                    isPhoneNumberValid: true,
                    phoneNumberServerErrors: [],
                    codeServerErrors: [],
                    isSendingCode: false,
                    isVerifyingCode: false,
                    resendLeftTimeInSeconds: 0
                }, data);
            }
        },
        created() {
            this.PHONE_STEP = 0;
            this.CODE_STEP = 1;
            this.INTERVAL_ID = null;
        },
        unmount() {
            this.stopResendTimeout();
        }
    }
   
</script>
