<template>
    <publisher></publisher>
</template>

<script>
import publisher from "./components/post/publisherComponent.vue"

export default {
    name: 'post',
    props: [],
    components: {
        publisher
    },
    data: function() {
        return {
            posts:null
        }
    },
    methods: {

    },
    computed: {

    },
    created : function () {

    }
}
</script>
