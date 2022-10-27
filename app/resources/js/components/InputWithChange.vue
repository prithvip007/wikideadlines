<template>
    <div class="form-group">
        <label class="font-weight-bold" :for="INPUT_ID">{{ label }}</label>
        <div class="position-relative">
            <input disabled :value="value" :placeholder="placeholder" :name="INPUT_ID" :id="INPUT_ID" class="form-control" style="padding-right: 4rem !important">
            <a :href="link" @click="$emit('change')" class="btn btn-link position-absolute" style="right:0;top:0">
                change
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            label: {
                type: String,
                required: true
            },
            placeholder: {
                type: String,
                required: false,
                default: ''
            },
            value: {
                type: String,
                required: false,
                default: ''
            },
            link: {
                type: String,
                required: true
            }
        },
        methods: {
            generateRandomId() {
                return String(Math.random() + Date.now());
            }
        },
        beforeMount() {
            this.INPUT_ID = this.generateRandomId();
        }
    }
</script>
