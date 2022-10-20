<template>
    <mail-change :mode="mode" v-on:changed="handleEmailChanged"></mail-change>
</template>

<script>
    import MailChange from "./MailChange.vue";

    export default {
        components: {
          MailChange,
        },
        props: {
            mode: {
                type: String,
                required: true,
                validator: function (value) {
                    return ['logging', 'signup'].includes(value)
                }
            },
        },
        data() {
            return {
                email: ''
            }
        },
        methods: {
            handleEmailChanged(email, redirect_to) {
                const message = this.mode === 'logging' ? 'You have signed in. Redirecting...' : 'You have signed up. Redirecting...';
                toaster.add('Successful authentication', message);

                location.href = redirect_to;
            }
        }
    }
</script>
