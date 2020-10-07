<template>
    <publisher></publisher>
</template>

<script>
import publisher from "./components/post/publisherComponent.vue"
import Post from "./apis/Post"

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
    created() {
        let vm = this;
        console.log("test created");
        Post.posts().then((response => {
             console.log(response);
        })).catch(
        );
    },
    mounted(){
         console.log("test mounted");
    }
}
</script>
