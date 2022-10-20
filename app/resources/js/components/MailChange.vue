<template>
        <div class="card">
            <h5 v-if="mode === 'logging'" class="card-header text-center">Sign in with Email</h5>
            <h5 v-if="mode === 'signup'" class="card-header text-center">Sign up with Email</h5>
            <modal-header-primary v-if="mode === 'update'" :lines="['Email change']"></modal-header-primary>
            <div class="card-body">
                <form @submit.prevent="sendForm" class="p-0 px-md-5 py-md-2">
                    <div v-if="currentStep === EMAIL_STEP">
                        <div class="form-group d-flex align-items-center flex-column">
                            <div v-if="mode === 'logging'" class="text-center mb-3">Please enter an email<br> to log in to WikiDeadlines</div>
                            <div v-if="mode === 'signup'" class="text-center mb-3">Please enter an email<br> to sign up to WikiDeadlines</div>
                            <div v-if="mode === 'update'" class="text-center mb-3">Please enter a new email<br> that you will use to log in to WikiDeadlines</div>
                            <input required v-model="email" placeholder="email@example.com" name="email" class="form-control" type="email" v-bind:class="{ 'is-invalid': emailServerErrors.length > 0 }">
                            <div v-for="error in emailServerErrors" :key="error" class="invalid-feedback d-block">
                                {{ error }}
                            </div>
                        </div>
                        <div class="form-group">
                            <button :disabled="isSubmitting" type="submit" class="btn btn-orange-soda rounded-m w-100 text-uppercase d-flex align-items-center justify-content-center">
                                Next
                                <div v-if="isSubmitting" class="spinner-border spinner-border-sm ml-2" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div v-if="currentStep === CODE_STEP">
                        <div class="form-group d-flex align-items-center flex-column">
                            <div class="text-center mb-3">
                                Enter the verification code we sent to
                                <br>
                                {{ email }}
                                <br>
                                <small class="form-text text-muted text-center m-0">
                                    <a @click.prevent="handleEmailEdit" href="#">Edit email</a>
                                </small>
                            </div>
                            <input :value="code" @input="verifyCode" pattern="[0-9]+" inputmode="numeric" type="tel" class="form-control"  v-bind:class="{ 'is-invalid': codeServerErrors.length > 0 }" name="code" required autofocus placeholder="Code" autocomplete="off">
                            <div :key="error" v-for="error in codeServerErrors" class="invalid-feedback">
                                {{ error }}
                            </div>
                        </div>
                        <div class="form-group">
                            <button :disabled="isSubmitting" type="submit" class="btn btn-orange-soda rounded-m w-100 text-uppercase d-flex align-items-center justify-content-center">
                                Verify
                                <div v-if="isSubmitting" class="spinner-border spinner-border-sm ml-2" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</template>

<script>
    import InputWithChange from "./InputWithChange.vue";
    import ModalHeaderPrimary from './Modal/ModalHeaderPrimary';
    import { client } from '../client';

    export default {
        components: {
          InputWithChange,
          ModalHeaderPrimary
        },
        props: {
            mode: {
                type: String,
                required: false,
                default: 'update',
                validator: function (value) {
                    return ['update', 'logging', 'signup'].includes(value)
                }
            }
        },
        data() {
            return {
                email: '',
                code: '',
                errors: [],
                isSubmitting: false,
                codeServerErrors: [],
                emailServerErrors: [],
                currentStep: 0
            }
        },
        methods: {
            verifyCode(e) {
                const value = e.currentTarget.value.replace(/\D/g, '').slice(0, 100);

                this.code = value;
                e.currentTarget.value = value;
            },
            async sendForm() {
                switch (this.currentStep) {
                    case this.EMAIL_STEP:
                            this.emailServerErrors = [];
                            this.isSubmitting = true;

                        try {
                            if (this.mode === 'logging' || this.mode === 'signup') {
                                await client.sendCodeToAuthenticateUserByEmail({ email: this.email });
                            } else {
                                await client.sendCodeToUpdateEmail({ email: this.email });
                            }
                            this.currentStep = this.CODE_STEP;
                        } catch (e) {
                            this.emailServerErrors = e?.response?.data?.errors?.email ?? [];
                        } finally {
                            this.isSubmitting = false;
                        }
                        break;
                    case this.CODE_STEP:
                        this.codeServerErrors = [];
                        this.isSubmitting = true;

                        try {
                            if (this.mode === 'logging' || this.mode === 'signup') {
                                const response = await client.confirmCodeToAuthenticateUserByEmail({ email: this.email, code: this.code });
                                this.$emit('changed', this.email, response.data.data.redirect_to);
                            } else {
                                await client.confirmCodeToUpdateEmail({ email: this.email, code: this.code });
                                this.$emit('changed', this.email);
                            }
                            this.isSubmitting = false;
                        } catch (e) {
                            this.codeServerErrors = e?.response?.data?.errors?.code ?? [];
                        } finally {
                            this.isSubmitting = false;
                        }
                        break;
                    default:
                        throw new Error('The step doesn\'t exist');
                }
            },
            handleEmailEdit() {
                this.currentStep = this.EMAIL_STEP;
                this.code = '';
            },
        },
        created() {
            this.EMAIL_STEP = 0;
            this.CODE_STEP = 1;
        },
    }
</script>
