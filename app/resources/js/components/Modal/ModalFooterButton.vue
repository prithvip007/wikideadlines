<template>
    <modal-footer>
        <button
            v-on:click="$emit('click')"
            :type="type"
            class="btn btn-primary btn-orange-soda w-100 rounded-m"
            :disabled="disabled || loading"
        >
            <template v-if="!loading">
                <slot></slot>
            </template>
            <i v-else class="fa fa-spinner fa-spin"></i>
        </button>
    </modal-footer>
</template>

<script>
    import ModalFooter from './ModalFooter';
    export default {
        props: {
            type: {
                type: String,
                required: false,
                default: 'submit'
            },
            disabled: {
                type: Boolean,
                required: false,
                default: false
            },
            loading: {
                type: Boolean,
                required: false,
                default: false,
            }
        },
        components: {
            ModalFooter
        }
    };
</script>
