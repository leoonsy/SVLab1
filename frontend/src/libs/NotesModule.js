import Axios from 'axios'
import Config from '@/config/main';
class NotesModule {
    static async getNotes() {
        try {
            let response = await Axios(
                {
                    method: 'get',
                    url: `${Config.BACKEND_URL}/notes.php?action=getNotes`
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

    static async addNote() {
        try {
            let response = await Axios(
                {
                    method: 'post',
                    url: `${Config.BACKEND_URL}/notes.php`,
                    data: {
                        action: 'addNote'
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

    static async updateNote(id, name, description) {
        try {
            let response = await Axios(
                {
                    method: 'put',
                    url: `${Config.BACKEND_URL}/notes.php`,
                    data: {
                        action: 'updateNote',
                        id, name, description
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

    static async deleteNote(id) {
        try {
            let response = await Axios(
                {
                    method: 'delete',
                    url: `${Config.BACKEND_URL}/notes.php`,
                    data: {
                        action: 'deleteNote',
                        id
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

export default NotesModule;