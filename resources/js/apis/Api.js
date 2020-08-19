// 封裝axios，設置攔截器，統一管理錯誤
import axios from 'axios'

let Api = axios.create({
    baseURL: 'http://test.wall.com/api/'
});

Api.defaults.withCredentials = true;

export default Api;
