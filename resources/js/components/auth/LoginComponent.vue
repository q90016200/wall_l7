<template>
    <div>
        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
            <div class="col-md-6">
                <input id="email" type="email" class="form-control"  name="email" value="" required autocomplete="email" autofocus v-model="form.email">
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" v-model="form.password">
            </div>
        </div>

    <div class="form-group row mb-0" >
            <div class="col-md-8 offset-md-4">
                <a class="btn btn-primary" @click.prevent="onLogin">Login</a>
            </div>
        </div>
    </div>
</template>


<script>
import User from "../../apis/User"

export default {
    name: 'app',
    components: {
        // Header
    },
    data: function() {
        return {
            form : {
                email: '',
                password: '',
            },
        }
    },
    created : function () {
        // let accessToken = localStorage.getItem('token');
        // let vm = this;

        // if (accessToken != '' && accessToken != null) {
        //     vm.$store.dispatch("logined", accessToken);
        // }
    },
    methods: {
        // 登入
        onLogin: function() {
            let vm = this;

            User.login(this.form).then(function () {
                Vue.swal('登入成功').then(() => {
                    window.location.href = "/home";
                });


            });

        }
        // // 登出
        // onLogout: function() {
        //     let vm = this;
        //     vm.$store.dispatch('logout');
        // }
    },
}
</script>
