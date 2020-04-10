import Axios from 'axios'
import Config from '@/config/main';
class AuthModule {
    /**
     * 
     * @param {string} name 
     * @param {string} password 
     */
    static async login(name, password) {
        try {
            var response = await Axios(
                {
                    method: 'post',
                    url: Config.BACKEND_URL,
                    data: {
                        type: 'login',
                        name,
                        password
                    }
                }
            );
        }
        catch (e) {
            throw new Error('Неизвестная ошибка');
        }
        if (!response.data.success)
            throw new Error(response.data.message);
    }

    static async logout() {
        try {
            var response = await Axios(
                {
                    method: 'post',
                    url: Config.BACKEND_URL,
                    data: {
                        type: 'logout'
                    }
                }
            );
        }
        catch (e) {
            throw new Error('Неизвестная ошибка');
        }
        if (!response.data.success)
            throw new Error(response.data.message);      
    }

    static async register(name, password) {
        try {
            var response = await Axios(
                {
                    method: 'post',
                    url: Config.BACKEND_URL,
                    data: {
                        type: 'register',
                        name,
                        password
                    }
                }
            );
        }
        catch (e) {
            throw e;
        }
        if (!response.data.success)
            throw new Error(response.data.message);
    }

    static async getUserInfo() {
        try {
            let response = await Axios(
                {
                    method: 'post',
                    url: Config.BACKEND_URL,
                    data: {
                        type: 'userInfo'
                    }
                }
            );
            if (!response.data.success)
                throw new Error(response.data.message);

            return response.data.data;
        }
        catch (e) {
            throw e;
        }        
    }
}

export default AuthModule;