<template>
    <div class="app flex-row align-items-center">
        <div class="container">
            <b-row class="justify-content-center">
                <b-col md="4">
                    <b-card-group>
                        <b-card no-body class="p-4">
                            <b-card-body>
                                <h2>Reset password</h2>
                                <p class="text-muted">
                                    Reset your password
                                </p>
                                <div :class="'alert alert-' + this.notification.type" id="message" v-if="this.notification.message" role="alert">
                                    {{ this.notification.message }}
                                </div>
                                <!-- <div v-bind:class="{'alert alert-success': (this.resetPasswordRequest.status == 2), 'alert alert-danger': !(this.resetPasswordRequest.status == 2)}" id="message" v-if="this.validation.message && this.resetPasswordRequest.status==2" role="alert">{{ this.validation.message }}</div>
                                <div v-bind:class="{'alert alert-success': (this.findTokenRequest.status == 2), 'alert alert-danger': !(this.findTokenRequest.status == 2)}" id="message" v-else-if="this.validation.message" role="alert">{{ this.validation.message }}</div> -->
                                <b-input-group class="mb-3" v-if="this.findTokenRequest.status == 2 && this.resetPasswordRequest.status != 2">
                                    <b-input-group-prepend>
                                        <b-input-group-text>
                                            <i class="icon-envelope-open" />
                                        </b-input-group-text>
                                    </b-input-group-prepend>
                                    <b-input type="text" class="form-control" :value="form.email" disabled/>
                                </b-input-group>
                                <b-input-group class="mb-3" v-if="this.findTokenRequest.status == 2 && this.resetPasswordRequest.status != 2">
                                    <b-input-group-prepend>
                                        <b-input-group-text>
                                            <i class="icon-lock" />
                                        </b-input-group-text>
                                    </b-input-group-prepend>
                                    <b-input type="password" class="form-control" v-model="form.password" :state="$v.form.password | state" placeholder="New password" v-on:keyup.enter="submit"/>
                                    <div class="invalid-feedback d-block" v-if="$v.form.password.$invalid && validation && validation.password">
                                        {{ validation.password[0] }}
                                    </div>
                                </b-input-group>
                                <b-input-group class="mb-3" v-if="this.findTokenRequest.status == 2 && this.resetPasswordRequest.status != 2">
                                    <b-input-group-prepend>
                                        <b-input-group-text>
                                            <i class="icon-lock" />
                                        </b-input-group-text>
                                    </b-input-group-prepend>
                                    <b-input type="password" class="form-control" v-model="form.password_confirmation" :state="$v.form.password_confirmation | state" placeholder="New password confirmation" v-on:keyup.enter="submit"/>
                                    <div class="invalid-feedback d-block" v-if="$v.form.password_confirmation.$invalid &&  validation && validation.password_confirmation">
                                        {{ validation.password_confirmation[0] }}
                                    </div>
                                </b-input-group>
                                <b-row>
                                    <b-col cols="6" class="text-left">
                                        <b-button variant="link" class="px-0" @click="$router.push({ name: 'Login' })">
                                            Login
                                        </b-button>
                                        <button type="button" class="btn px-0 btn-link" @click="goToHome()">
                                            Back to Home
                                        </button>
                                    </b-col>
                                    <b-col cols="6" class="text-right" v-if="findTokenRequest.status==2 && this.resetPasswordRequest.status != 2">
                                        <b-loading v-if="resetPasswordRequest.status==1"></b-loading>
                                        <b-button variant="primary" class="px-4" @click="submit" v-else>
                                            Reset
                                        </b-button>
                                    </b-col>
                                    <b-col cols="6" class="text-right" v-else>
                                    </b-col>
                                </b-row>
                            </b-card-body>
                        </b-card>
                    </b-card-group>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
import { required, sameAs } from 'validators'
import AuthAPI from '../../api/auth.js'

export default {
    name: 'ResetPassword',
    data () {
        return {
            form: {
                email: '',
                password: '',
                password_confirmation: ''
            },
            notification: {
                type: 'danger',
                message: ''
            },
            validation: null,
            findTokenRequest: {
                status: 0
            },
            resetPasswordRequest: {
                status: 0
            },
            params:  {
                token: ''
            }
        }
    },
    validations () {
        return {
            form: {
                password: { required },
                password_confirmation: {
                    required,
                    sameAsPassword: sameAs('password')
                },
            },
        }
    },
    created () {
        // Get token param from URL
        this.params.token = this.$route.params.token
        if (!this.params.token) {
            message = 'Token not found'
            return false
        }

        // Check if the token is valid
        this.checkToken(this.params.token);
    },
    methods: {
        goToHome() {
            window.location.href = "/"
        },

        submit () {
            // Validation
            this.$v.$touch()

            this.resetPassword(this.form.email, this.form.password, this.form.password_confirmation, this.params.token)
        },

        checkToken (token) {
            var vueComponent = this;
            this.findTokenRequest.status = 1
            AuthAPI.findPasswordResetToken(token)
            .then(response => {
                vueComponent.notification.type = 'success'
                // Mark request status as loaded succesully
                vueComponent.findTokenRequest.status = 2
                vueComponent.form.email = response.data.password_reset.email

                // if (response.data && response.data.success) {
                //     vueComponent.validation.message = response.data.message
                //     // Mark request status as loaded succesully
                //     vueComponent.findTokenRequest.status = 2
                //     vueComponent.form.email = response.data.data.email
                // } else {
                //     // Mark request status as failed to load
                //     vueComponent.findTokenRequest.status = 3
                //     // Show message error
                //     vueComponent.validation.message = response.data.message
                // }
            })
            .catch(error => {
                // Mark request status as failed to load
                vueComponent.findTokenRequest.status = 3
                if (error.response) {
                    // Show message error
                    vueComponent.notification.type = 'danger'
                    vueComponent.notification.message = error.response.data.error.message
                    vueComponent.validation = error.response.data.validation
                } else {
                    vueComponent.notification.message = "Network error"
                }
            })
        },

        resetPassword (email, password, password_confirmation, token) {
            var vueComponent = this;
            // Mark request status as loading
            this.resetPasswordRequest.status = 1
            // Get the access token
            AuthAPI.resetPassword(email, password, password_confirmation, token)
            .then(response => {
                vueComponent.notification.type = 'success'
                // Mark request status as loaded succesully
                vueComponent.resetPasswordRequest.status = 2
                vueComponent.notification.message = "Your password has been reset successfully"
            })
            .catch(error => {
                // Mark request status as failed to load
                vueComponent.resetPasswordRequest.status = 3
                if (error.response) {
                    // Show message error
                    vueComponent.notification.type = 'danger'
                    vueComponent.notification.message = error.response.data.error.message
                    vueComponent.validation = error.response.data.validation
                } else {
                    vueComponent.notification.message = "Network error"
                }
            })
        }
    },
}
</script>
