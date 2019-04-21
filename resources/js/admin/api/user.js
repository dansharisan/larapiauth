import { APP_CONFIG } from '../../config.js';

export default {
    /*
    GET /api/auth/getUser
    To get user information
    */
    getUser: function() {
        return axios.get(APP_CONFIG.API_URL + '/auth/getUser');
    },

    /*
    GET /api/users
    To get user information
    */
    getUsers: function(page = 1, perPage = 25) {
        return axios.get(APP_CONFIG.API_URL + '/users?page=' + page + '&per_page=' + perPage);
    },

    /*
    POST /api/users/ban
    To get user information
    */
    banUser: function(userId) {
        return axios.post(APP_CONFIG.API_URL + '/users/ban',
        {
            user_id: userId,
        });
    },

    /*
    POST /api/users/unban
    To get user information
    */
    unbanUser: function(userId) {
        return axios.post(APP_CONFIG.API_URL + '/users/unban',
        {
            user_id: userId,
        });
    },
}
