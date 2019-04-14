import { APP_CONFIG } from '../../config.js';

export default {
    /*
    GET /api/user
    To get user information
    */
    getUser: function() {
        return axios.get(APP_CONFIG.API_URL + '/auth/getUser');
    },
}
