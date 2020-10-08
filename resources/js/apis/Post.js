import Api from "./Api";

export default {
    store(form) {
        return Api.post('posts', form);
    },
    posts(form) {
        return Api.get('posts?page=' + form.page);
    }
}
