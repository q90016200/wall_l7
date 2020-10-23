<template>
<div>
    <div class="mt-3">
        <div class="bg-white rounded border-bottom">
            <span>{{ post.id }}</span>
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

    }
}
</script>
