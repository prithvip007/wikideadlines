<template>
    <div>
        <div v-if="hideRegistrationAlert === false" class="alert alert-success text-center" role="alert">
            You have been successfully registered!
        </div>
        <div style="overflow:hidden;" class="card card-m">
            <h5 class="card-header text-center bg-white">Add profile information</h5>
            <div class="card-body">
                <form @submit.prevent="sendForm" class="p-0 px-md-5 py-md-2">
                    <div class="form-group">
                        <!-- Its actually not a Jurisdiction. Is a State. We should refactor the whole app to support jurisdictions later when more details become available -->
                        <label class="font-weight-bold" for="experience-id">Experience Level</label>
                        <select v-model="experienceLevel" v-select2="{placeholder: 'Select Experience Level'}" id="experience-id"
                                class="form-control"
                                name="state_id" required>
                            <option></option>
                            <option v-for="level in experienceLevels" :value="level.id" :key="level.id">{{ level.name }}</option>
                        </select>
                        <div v-for="error in experienceLevelErrors" v-bind:key="error" class="invalid-feedback d-block">
                            {{ error }}
                        </div>
                    </div>

                    <div class="form-group d-flex align-items-center flex-column">
                        <label class="align-self-start font-weight-bold" for="firstName">
                            First name
                        </label>
                        <input required v-model="firstName" id="firstName" type="text" v-bind:class="{ 'is-invalid': firstNameServerErrors.length > 0 }" class="form-control" name="firstName" autofocus placeholder="John">
                        <div v-for="error in firstNameServerErrors" v-bind:key="error" class="invalid-feedback">
                            {{ error }}
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center flex-column">
                        <label class="align-self-start font-weight-bold" for="secondName">
                            Last Name <small class="text-muted">(optional)</small>
                        </label>
                        <input v-model="secondName" id="secondName" type="text" v-bind:class="{ 'is-invalid': secondNameServerErrors.length > 0 }" class="form-control" name="secondName" autofocus placeholder="Doe">
                        <div v-for="error in secondNameServerErrors" v-bind:key="error" class="invalid-feedback">
                            {{ error }}
                        </div>
                    </div>
                    <div class="form-group">
                        <button :disabled="isUpdatingProfile" type="submit" class="btn btn-orange-soda rounded-m w-100 text-uppercase d-flex align-items-center justify-content-center">
                            Finish
                            <div v-if="isUpdatingProfile" class="spinner-border spinner-border-sm ml-2" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { client } from '../client';

    export default {
        props: {
            hideRegistrationAlert: {
                type: Boolean,
                default: false
            },
            experienceLevels: {
                type: Array,
                required: true
            }
        },
        data() {
            return this.getInitialData();
        },
        methods: {
            sendForm() {
                this.firstNameServerErrors = [];
                this.secondNameServerErrors = [];

                this.updateProfile().then((...args) => {
                    toaster.add('Success', 'Profile information has been updated. Redirecting...');
                    location.href = '/';
                }).catch((error) => {
                    if (error?.response?.data?.errors?.first_name) {
                        this.firstNameServerErrors = error.response.data.errors.first_name;
                    }

                    if (error?.response?.data?.errors?.second_name) {
                        this.secondNameServerErrors = error.response.data.errors.second_name;
                    }


                    if (error?.response?.data?.errors?.experience_level) {
                        this.experienceLevelErrors = error.response.data.errors.experience_level;
                    }
                });
            },
            updateProfile() {
                this.isUpdatingProfile = true;

                return client.updateProfile({
                    first_name: this.firstName,
                    second_name: this.secondName,
                    experience_level: this.experienceLevel 
                }).finally(() => {
                    this.isUpdatingProfile = false;
                });
            },
            getInitialData(data = {}) {
                return Object.assign({
                    firstName: '',
                    secondName: '',
                    experienceLevel: '',
                    experienceLevelErrors: [],
                    firstNameServerErrors: [],
                    secondNameServerErrors: [],
                    isUpdatingProfile: false,
                }, data);
            }
        }
    }
</script>
