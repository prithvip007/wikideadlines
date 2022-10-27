Vue.mixin({
    methods: {
        csrfToken() {
            return window.csrfToken;
        }
    }
});
