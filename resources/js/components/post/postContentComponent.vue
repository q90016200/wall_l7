<template>
<div>
    <div class="mt-3">
        <div class="bg-white rounded border-bottom">
            <!-- head -->
            <div class="row mx-2" >
                <div class="col-auto mr-auto">
                    <div>{{post.writer.name}}</div>
                    <div>
                        <!-- <router-link :to="{ name: 'postShow', params: { post_id: post.id } }">{{post.updated_at}}</router-link> -->
                        <router-link :to="{name:'postShow', params: { post_id: post.id }}">{{post.updated_at}}</router-link>
                    </div>
                </div>
                <div class="col-auto">
                    <button class="btn bg-white" type="button" id="post_action_men" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ...
                    </button>
                    <div class="dropdown-menu" aria-labelledby="post_action_men">
                        <a class="dropdown-item">複製連結</a>
                        <a class="dropdown-item">刪除</a>
                    </div>
                </div>
            </div>
            <!-- head end -->

            <!-- content -->
            <div class="mx-2 " v-html="content"></div>
            <!-- content end -->

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
            content: "",
        }
    },
    methods: {
        wrapPostContentURLs: (text ,new_window) => {
            let url_pattern = /(https?\:\/\/+)([a-z0-9\.\/\?\=\_\-\&\~\%\#]*)/igm;
            let target = (new_window === true || new_window == null) ? '_blank' : '';

            return text.replace(url_pattern, function (url) {
                // let protocol_pattern = /^(?:(?:https?|ftp):\/\/)/i;
                // let href = protocol_pattern.test(url) ? url : 'http://' + url;
                let href = url;
                return '<a href="' + href + '" target="' + target + '" >' + url + '</a>';
            });
        },
    },
    created() {
        // 轉超連結
        // let content = this.wrapPostContentURLs(this.decodeEntities(this.post.content), true);
        let content = this.wrapPostContentURLs(this.post.content, true);

        //替換所有的換行符
        content = content.replace(/\r\n/g, "<br>");
        content = content.replace(/\n/g, "<br>");

        this.content = content;
    }
}

</script>



