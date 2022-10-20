<template>
    <phone-number-login :mode="mode" v-on:logged-in="successLogin">
        <template v-slot:initial-screen-bottom>
            <div> 
                <div class="d-flex align-items-center mb-3">
                    <hr style="flex:1 1 auto;">
                    <span class="mx-3">or</span>
                    <hr style="flex:1 1 auto;">
                </div>
                <a :href="facebookLink" class="btn btn-facebook w-100 rounded-m"><i class="fa fa-facebook mr-2"></i>
                    {{
                        mode === 'logging' ? 'Sign in with Facebook' : 'Sign up with Facebook'
                    }}
                </a>
                <a :href="googleLink" class="btn btn-outline-dark w-100 mt-3 rounded-m"><i class="fa fa-google mr-2"></i>
                    {{
                        mode === 'logging' ? 'Sign in with Google' : 'Sign up with Google'
                    }}
                </a>
                <a :href="emailLink" class="btn btn-success w-100 mt-3 rounded-m"><i class="fa fa-envelope-o mr-2"></i>
                    {{
                        mode === 'logging' ? 'Sign in with Email' : 'Sign up with Email'
                    }}
                </a>
            </div>
        </template>
    </phone-number-login>
</template>

<script>
    import PhoneNumberLogin from './PhoneNumberLogin.vue';

    export default {
        components: {
            PhoneNumberLogin
        },
        props: {
            mode: {
                type: String,
                required: true,
                validator: function (value) {
                    return ['logging', 'signup'].includes(value)
                }
            },
            emailLink: {
                type: String,
                required: true
            },
            facebookLink: {
                type: String,
                required: true
            },
            googleLink: {
                type: String,
                required: true
            },
            resendTimeoutInSeconds: {
                type: Number,
                default: 120
            },
            initialStep: {
                type: Number,
                default: 0
            },
            hideRegistrationAlert: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return this.getInitialData();
        },
        methods: {
            successLogin({ redirect_to }) {
                location.href = redirect_to || '/';
            },
            getInitialData(data = {}) {
                return Object.assign({
                    currentStep: this.initialStep,
                    phone: '',
                    internationalPhone: undefined,
                    code: '',
                    firstName: '',
                    secondName: '',
                    redirectTo: '',
                    isPhoneNumberValid: true,
                    phoneNumberServerErrors: [],
                    codeServerErrors: [],
                    firstNameServerErrors: [],
                    secondNameServerErrors: [],
                    isSendingCode: false,
                    isVerifyingCode: false,
                    isUpdatingProfile: false,
                    resendLeftTimeInSeconds: 0
                }, data);
            }
        },
        created() {
            this.PHONE_STEP = 0;
            this.CODE_STEP = 1;
            this.PROFILE_STEP = 2;
            this.INTERVAL_ID = null;
        },
        unmount() {
            this.stopResendTimeout();
        }
    }
</script>
