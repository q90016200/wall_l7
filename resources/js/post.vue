<template>
    <div>
        <publisher></publisher>
        <postContent v-for="post in posts"
            v-bind:key="post.id"
            :post="post">
        </postContent>
    </div>
</template>

<script>
import publisher from "./components/post/publisherComponent.vue"
import postContent from "./components/post/postContentComponent.vue"
import Post from "./apis/Post"

export default {
    name: 'post',
    props: [],
    components: {
        publisher,
        postContent
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
        Post.posts({"page":1}).then((response => {
            console.log(response.data);

            vm.posts = response.data.data.data.data;
        })).catch(
        );
    },
    mounted(){
         console.log("test mounted");
    }
}
</script>
