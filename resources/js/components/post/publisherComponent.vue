<template>
<div>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card text-center">
                <div class="card-header">
                    建立貼文
                </div>

                <div class="card-body">
                    <form @click="checkAuth">
                        <div class="form-group">
                            <textarea
                                class="form-control"
                                :class="{disabled: $store.getters.logined}"
                                rows="3"
                                placeholder="我想說的..."
                                v-model="form.content">
                            </textarea>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-right">
                    <button
                        class="btn btn-success"
                        :class="{disabled:!this.$store.getters.logined}"
                        @click.prevent="publish"
                    >發佈</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="row justify-content-center">
        </div>
    </div>
</div>
</template>

<script>
import User from "../../apis/User"
// import Post from "../../apis/Post"

export default {
    name: 'publisher',
    props: [],
    data: function() {
        return {
            logined: false,
            form: {
                content: "",
            }
        }
    },
    methods: {
        // 檢查登入
        checkAuth: function() {
            if (this.$store.getters.logined != true) {
                Vue.swal('請先進行登入');
            }
        },
        // 發布文章
        publish: function() {
            let vm = this;
            vm.form.content = vm.form.content.trim();

            if (vm.$store.getters.logined != true) {
                Vue.swal('請先進行登入');
            } else if (vm.form.content == "") {
                Vue.swal('無輸入內容');
            } else {
                Post.store(vm.form).then((response) => {
                    let responseData = response.data;
                    if (responseData.code == 200) {
                        vm.form.content = "";
                    }
                }).catch((error) => {
                    console.log(error.response);
                    let errorResponse = error.response.data;
                    if (errorResponse.code == 400) {
                        Vue.swal(errorResponse.message, errorResponse.data.message, "warning");
                    } else {
                        Vue.swal(errorResponse.message, errorResponse.data.message, "error");
                    }

                });
            }
        }
    },
    computed: {

    },
    created : function () {
        let vm = this;
        User.profile().then((response => {
            if (response.data.code == 200) {
                // console.log("1");
                vm.$store.dispatch('logined');
                vm.logined = this.$store.getters.logined
            }
        })).catch(

        );
    }
}
</script>
