<template>
    <div>
        <!-- <postContent
            :post="post">
        </postContent> -->
        {{$route.params.post_id}}
    </div>
</template>

<script>
import postContent from "./components/post/postContentComponent.vue"
import Post from "./apis/Post"

export default {
    name: 'postShow',
    props: [],
    components: {
        postContent
    },
    data: function() {
        return {
            post: null
        }
    },
    methods: {

    },
    computed: {

    },
    created() {
        let vm = this;
        // console.log("test created");
    },
    mounted(){
        //  console.log("test mounted");
    }
}
</script>
