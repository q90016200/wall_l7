<template>
<div>
    <div class="mt-3">
        <div class="bg-white rounded border-bottom">
            <!-- head -->
            <div class="row mx-2" >
                <div>{{ post.writer.name }}</div>
                <div class="col-auto">
                    <button class="btn bg-white" type="button" id="post_action_men" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ...
                    </button>
                </div>
            </div>
            <!-- head end -->




        </div>
    </div>
</div>
</template>

<script>
export default {
    name: 'postContent',
    props: ['post'],
    data: function() {
        return {
            content:"",
        }
    },
    methods: {

    },
    created() {
        // console.log(this.post);
    }
}
</script>
