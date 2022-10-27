<template>
    <div>
        <section class="row">
            <h5 class="col-12">General Methods</h5>
            <div class="col-12 col-md-6">
                <profile-phone-number :initial-phone-number="phoneNumber"></profile-phone-number>
            </div>
            <div class="col-12 col-md-6">
                <profile-email :initialEmail="email"></profile-email>
            </div>
        </section>
        <hr>
        <section class="row">
            <h5 class="col-12">Connected Services</h5>
            <section class="col-12">
                <h6>Facebook</h6>
                <p class="font-weight-bold d-flex justify-content-between align-items-center">
                    <template v-if="isFacebookConnected === false">
                        Add Facebook to sign in to WikiDeadlines with one click
                        <a :href="connectToFacebookLink" class="btn btn-facebook rounded-m"><i class="fa fa-facebook mr-2"></i>Sign in with Facebook</a>
                    </template>
                    <template v-else>
                        You have connected Facebook to Wikideadlines
                        <button :disabled="isDisconnectingFacebook" @click="onSocialDisconnectClick('facebook')" class="btn btn-danger d-flex align-items-center justify-content-center rounded-m">
                            <i class="fa fa-facebook mr-2"></i>
                            Disconnect Facebook
                            <div v-if="isDisconnectingFacebook" class="spinner-border spinner-border-sm ml-2" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </template>
                </p>
            </section>
            <section class="col-12">
                <h6>Google</h6>
                <p class="font-weight-bold d-flex justify-content-between align-items-center">
                    <template v-if="isGoogleConnected === false">
                        Add Google to sign in to WikiDeadlines with one click
                        <a :href="connectToGoogleLink" class="btn btn-outline-dark rounded-m"><i class="fa fa-google mr-2"></i>Sign in with Google</a>
                    </template>
                    <template v-else>
                        You have connected Google to WikiDeadlines
                        <button :disabled="isDisconnectingGoogle" @click="onSocialDisconnectClick('google')" class="btn btn-danger d-flex align-items-center justify-content-center rounded-m">
                            <i class="fa fa-google mr-2"></i>
                            Disconnect Google
                            <div v-if="isDisconnectingGoogle" class="spinner-border spinner-border-sm ml-2" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </template>
                </p>
            </section>
        </section>
    </div>
</template>

<script>
    import { capitalizeFirstLetter } from '../utils';
    import ProfileEmail from './ProfileEmail.vue';
    import ProfilePhoneNumber from './ProfilePhoneNumber.vue'
    import { client } from '../client';

    export default {
        components: {
            ProfileEmail,
            ProfilePhoneNumber
        },
        props: {
            phoneNumber: ProfilePhoneNumber.props.initialPhoneNumber,
            email: ProfileEmail.props.initialEmail,
            isFacebookConnectedInitial: {
                type: Boolean,
                required: true
            },
            isGoogleConnectedInitial: {
                type: Boolean,
                required: true
            },
            connectToFacebookLink: {
                type: String,
                required: true
            },
            connectToGoogleLink: {
                type: String,
                required: true
            },
        },
        data() {
            console.log('phoneNumber', this.phoneNumber)
            return {
                isDisconnectingFacebook: false,
                isFacebookConnected: this.isFacebookConnectedInitial,
                isDisconnectingGoogle: false,
                isGoogleConnected: this.isGoogleConnectedInitial
            }
        },
        methods: {
            onSocialDisconnectClick(network) {
                const networkCapitalized = capitalizeFirstLetter(network);

                this[`isDisconnecting${networkCapitalized}`] = true;

                client.disconnectSocialNetwork(network)
                    .then(() => {
                        toaster.add('Done!', `${networkCapitalized} has been disconnected`);
                        this[`is${networkCapitalized}Connected`] = false;
                    })
                   .catch((error) => {
                        toaster.error('Error!', error.response.data.message);
                    })
                    .finally(() => {
                        this[`isDisconnecting${networkCapitalized}`] = false;
                    });
            }
        }
    }
</script>
