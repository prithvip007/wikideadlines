<template>
    <div class="input-group">
        <input style="border-top-right-radius: 0 !important;border-bottom-right-radius: 0 !important;" ref="link" type="text" class="form-control" :value="text">
        <div class="input-group-append">
            <button
                title="Copied!"
                ref="btn"
                :data-clipboard-text="text"
                class="btn btn-orange-soda rounded-m"
                style="border-top-left-radius: 0 !important;border-bottom-left-radius: 0 !important;"
                type="button"
            >
                Copy
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            text: {
                type: String,
                required: true
            },
            options: {
                type: Function,
                default: () => {}
            }
        },
        methods: {
            init() {
                this.preventChange();

                new ClipboardJS(this.$refs.btn, this.options());

                $(this.$refs.btn).tooltip({
                    trigger: 'manual',
                    placement: 'bottom'
                }).on('click', () => {
                    $(this.$refs.btn).tooltip('show');
                }).on('mouseout', () => {
                    $(this.$refs.btn).tooltip('hide');
                });
            },
            preventChange() {
                const specialKeys = {
                    'Meta': false,
                    'Control': false,
                };

                const prevent = (e) => {
                    const keysToSkip = ['Tab'];

                    if (keysToSkip.includes(e.key)) {
                        return;
                    }

                    if (specialKeys.hasOwnProperty(e.key)) {
                        specialKeys[e.key] = e.type === 'keydown';
                        return;
                    }

                    if (Object.keys(specialKeys).some((key) => specialKeys[key])) {
                        return;
                    }


                    e.preventDefault();
                }

                this.$refs.link.addEventListener('keyup', prevent);
                this.$refs.link.addEventListener('keydown', prevent);
            },
        },
        mounted() {
            this.init();
        }
    }
</script>
