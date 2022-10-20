<template>
    <modal-header>
        <h1 :class="`modal-title h5 w-100 ${lines.length > 1 ? 'text-center': ''}`">
            <div :key="index" v-for="line, index in lines">{{line}}</div>
        </h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </modal-header>
</template>

<script>
    import ModalHeader from './ModalHeader';
    export default {
        props: {
            lines: {
                type: Array,
                required: true
            }
        },
        components: {
            ModalHeader
        }
    };
</script>
