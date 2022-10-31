<template>
    <div
        class="modal fade"
        ref="modal"
        tabindex="-1"
        role="dialog"
        aria-hidden="true"
        data-backdrop="static"
        :data-keyboard="keyboard"
    >
        <div class="modal-dialog" role="document">
            <div style="overflow: hidden;" class="modal-content rounded-m">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            keyboard: {
                type: Boolean,
                required: false,
                default: true
            },
            backdrop: {
                type: String,
                required: false,
            },
            triggerHash: {
                type: String,
                required: true
            },
        },
        methods: {
            init() {
                $(this.$refs.modal).on("hide.bs.modal", () => location.hash = '');

                window.addEventListener("hashchange", this.onPageHashChange);

                this.onPageHashChange();
            },
            show() {
                $(this.$refs.modal).modal('show');
                this.$emit('show');
            },
            close() {
                $(this.$refs.modal).modal('hide');
                this.$emit('hide');
            },
            open() {
                location.hash = `#${this.triggerHash}`;
            },
            onPageHashChange() {
                if (location.hash === `#${this.triggerHash}`) {
                    this.show();
                } else {
                    this.close();
                }
            },
        },
        beforeDestroy() {
            window.removeEventListener("hashchange", this.onPageHashChange);
        },
        mounted() {
            this.init();
        }
    }
</script>
