import Api from "./Api";

export default {
    store(form) {
        return Api.post('posts', form);
    }
}
