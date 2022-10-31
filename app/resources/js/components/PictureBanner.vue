<template>
    <div class="d-flex align-items-center flex-column">
        <img class="picture-banner__image" :src="imageSource" :alt="imageAlt" >
        <h5 class="mb-0 mt-3 text-center">{{ titleText }}</h5>
        <a :href="link" class="btn btn-orange-soda rounded-m mt-3">{{ linkText }}</a>
    </div>
</template>

<script>
    export default {
        props: {
            imageSource: {
                type: String,
                required: true
            },
            imageAlt: {
                type: String,
                required: true
            },
            titleText: {
                type: String,
                required: true
            },
            link: {
                type: String,
                required: true
            },
            linkText: {
                type: String,
                required: true
            }
        }
    }
</script>
