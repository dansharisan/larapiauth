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
    PATCH /api/users/{id}/ban
    To ban an user
    */
    banUser: function(userId) {
        return axios.patch(APP_CONFIG.API_URL + '/users/' + userId +'/ban');
    },

    /*
    PATCH /api/users/{id}/unban
    To unban an user
    */
    unbanUser: function(userId) {
        return axios.patch(APP_CONFIG.API_URL + '/users/' + userId + '/unban');
    },

    /*
    DELETE /api/users/{id}/unban
    To delete an user
    */
    deleteUser: function(userId) {
        return axios.delete(APP_CONFIG.API_URL + '/users/' + userId);
    },

    /*
    POST /api/users/collection:batchDelete
    To delete a selected collection of users
    */
    deleteUsers: function(userIds) {
        return axios.post(APP_CONFIG.API_URL + '/users/collection:batchDelete',
        {
            ids: userIds,
        });
    },
}
