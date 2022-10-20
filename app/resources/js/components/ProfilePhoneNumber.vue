<template>
    <div>
        <profile-phone-number-modal-component trigger-hash="phone" v-on:change="handlePhoneNumberChange"></profile-phone-number-modal-component>
        <input-with-change
            label="Phone Number"
            placeholder="Add a phone number"
            :value="phoneNumber"
            link="#phone"
        ></input-with-change>
    </div>
</template>

<script>
    import ProfilePhoneNumberModalComponent from "./ProfilePhoneNumberModalComponent";
    import InputWithChange from "./InputWithChange.vue";

    export default {
        components: {
          ProfilePhoneNumberModalComponent,
          InputWithChange
        },
        props: {
            initialPhoneNumber: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                phoneNumber: this.initialPhoneNumber
            }
        },
        methods: {
            handlePhoneNumberChange(phoneNumber) {
                this.phoneNumber = phoneNumber;
            }
        }
    }
</script>
