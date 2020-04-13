import Axios from 'axios'
import Config from '@/config/main';
class AuthModule {
    /**
     * 
     * @param {string} username 
     * @param {string} password 
     */
    static async login(username, password) {
        try {
            var response = await Axios(
                {
                    method: 'post',
                    url: `${Config.BACKEND_URL}/account.php`,
                    data: {
                        action: 'login',
                        username,
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
                    method: 'delete',
                    url: `${Config.BACKEND_URL}/account.php`,
                    data: {
                        action: 'logout'
                    }
                }
            );

            // Axios.delete(`${Config.BACKEND_URL}/account.php`, { data: { foo: "bar" } });
        }
        catch (e) {
            throw new Error('Неизвестная ошибка');
        }
        if (!response.data.success)
            throw new Error(response.data.message);
    }

    static async register(username, password) {
        try {
            var response = await Axios(
                {
                    method: 'post',
                    url: `${Config.BACKEND_URL}/account.php`,
                    data: {
                        action: 'register',
                        username,
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
                    method: 'get',
                    url: `${Config.BACKEND_URL}/account.php?action=getUserInfo`
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