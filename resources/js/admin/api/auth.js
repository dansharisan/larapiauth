import { APP_CONFIG } from '../../config.js';

export default {
    /*
    POST /api/user
    Get access token
    */
    getAccessToken: function(email, password) {
        return axios.post(APP_CONFIG.API_URL + '/auth/login',
        {
            email: email,
            password: password
        });
    },

    /*
    GET /api/auth/password/token/create
    Generate password reset token and send that token to user through mail
    */
    createPasswordResetToken: function(email) {
        return axios.post(APP_CONFIG.API_URL + '/auth/password/token/create',
        {
            email: email,
        });
    },

    /*
    GET /api/auth/password/token/find/:token
    Find the reset password token
    */
    findPasswordResetToken: function(token) {
        return axios.get(APP_CONFIG.API_URL + '/auth/password/token/find/' + token);
    },

    /*
    PATCH /api/auth/password/reset
    Reset password
    */
    resetPassword: function(email, password, password_confirmation, token) {
        return axios.patch(APP_CONFIG.API_URL + '/auth/password/reset',
        {
            email: email,
            password: password,
            password_confirmation: password_confirmation,
            token: token
        });
    },

    /*
    POST /api/auth/logout
    Logout
    */
    logout: function() {
        return axios.get( APP_CONFIG.API_URL + '/auth/logout' );
    },
}
