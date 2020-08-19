import Api from "./Api";
import Csrf from "./Csrf"

export default {
    async login(form) {
        await Csrf.getCookie();

        return Api.post("/auth/login", form);
    },
    async profile() {
        await Csrf.getCookie();
        return Api.get("/auth/user");
    }
};
