<template>
    <div>
        <form @submit.prevent="handleSubmit">
            <div class="row">
                <div class="form-group col-12 col-md-6">
                    <label class="font-weight-bold" for="first-name">First Name</label>
                    <input required v-model="firstName" placeholder="John" name="first_name" v-bind:class="{ 'is-invalid': firstNameErrors.length > 0 }" id="first-name" class="form-control"> 
                    <div :key="error" v-for="error in firstNameErrors" class="invalid-feedback">
                        {{ error }}
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label class="font-weight-bold" for="second-name">Last Name <small class="text-muted">(optional)</small></label>
                    <input v-model="secondName" placeholder="Doe" name="second_name" v-bind:class="{ 'is-invalid': secondNameErrors.length > 0 }" id="second-name" class="form-control">
                    <div :key="error" v-for="error in secondNameErrors" class="invalid-feedback">
                        {{ error }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12 col-md-6">
                    <label class="font-weight-bold" for="phone-number">Phone Number</label> 
                    <input disabled type="phone-number" :value="defaultPhoneNumber" name="phone-number" id="phone-number" class="form-control">
                    <small class="text-muted">To change phone number click <a :href="linkToAuthenticationPage">here</a></small>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label class="font-weight-bold" for="email">Email</label> 
                    <input disabled type="email" :value="defaultEmail" name="email" id="email" class="form-control">
                    <small class="text-muted">To change email click <a :href="linkToAuthenticationPage">here</a></small>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12 col-md-6">
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
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <button
                        v-bind:disabled="isUpdatingProfile"
                        type="submit"
                        class="btn btn-orange-soda w-100 rounded-m text-uppercase d-flex align-items-center justify-content-center"
                    >
                        Update
                        <div v-if="isUpdatingProfile" class="spinner-border spinner-border-sm ml-2" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import ProfilePhoneNumber from "./ProfilePhoneNumber";
    import { client } from '../client';

    export default {
        components: {
            ProfilePhoneNumber
        },
        props: {
            experienceLevels: {
                type: Array,
                required: true
            },
            linkToAuthenticationPage: {
                type: String,
                required: true
            },
            defaultPhoneNumber: {
                type: String,
                default: ''
            },
            defaultExperienceLevel: {
                type: Number,
                default: ''
            },
            defaultFirstName: {
                type: String,
                default: ''
            },
            defaultSecondName: {
                type: String,
                default: ''
            },
            defaultEmail: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                isUpdatingProfile: false,
                firstName: this.defaultFirstName,
                secondName: this.defaultSecondName,
                experienceLevel: this.defaultExperienceLevel,
                experienceLevelErrors: [],
                firstNameErrors: [],
                secondNameErrors: []
            }
        },
        methods: {
            handleSubmit() {
                this.isUpdatingProfile = true;

                client.updateProfile({
                    first_name: this.firstName,
                    second_name: this.secondName,
                    experience_level: this.experienceLevel
                }).then(() => {
                    toaster.add('Profile updated', 'Profile has been successfully updated');
                }).catch((error) => {
                    if (error?.response?.data?.errors?.first_name) {
                        this.firstNameErrors = error.response.data.errors.first_name;
                    }

                    if (error?.response?.data?.errors?.second_name) {
                        this.secondNameErrors = error.response.data.errors.second_name;
                    }

                    if (error?.response?.data?.errors?.experience_level) {
                        this.experienceLevelErrors = error.response.data.errors.experience_level;
                    }
                }).finally(() => {
                    this.isUpdatingProfile = false;
                });
            },
        }
    }
</script>
