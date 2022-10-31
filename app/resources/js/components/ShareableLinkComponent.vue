<template>
    <div>
        <copy :text="link"></copy>
        <div class="small mt-1 text-muted w-100 text-center">Anyone with this link can view this calculation</div>
    </div>
</template>

<script>
    import Copy from './Copy';

    export default {
        components: {
            Copy
        },
        props: {
            link: {
                type: String,
                required: true
            }
        }
    }
</script>
