<template>
    <div class="app flex-row align-items-center">
        <div class="container">
            <b-row class="justify-content-center">
                <b-col md="4">
                    <b-card-group>
                        <b-card
                        no-body
                        class="p-4"
                        >
                        <b-card-body>
                            <h2>User Info</h2>
                            <p class="text-muted">
                                Your profile is as below:
                            </p>
                            <b-input-group class="mb-3">
                                <b-input-group-prepend is-text>
                                        Email
                                </b-input-group-prepend>
                                <input
                                type="text"
                                class="form-control"
                                placeholder="Email"
                                :value="user.email"
                                disabled
                                />
                            </b-input-group>
                            <b-input-group class="mb-3">
                                <b-input-group-prepend is-text>
                                    Roles
                                </b-input-group-prepend>
                                <input
                                type="text"
                                class="form-control"
                                placeholder="Role"
                                :value="this.getRoles(this.user)"
                                disabled
                                />
                            </b-input-group>
                            <b-button
                            v-if="this.hasRole(this.user, 'admin')"
                            variant="link"
                            class="px-0"
                            @click="$router.push({ name: 'Dashboard' })"
                            >
                            Go to Admin panel
                        </b-button>
                        <br v-if="this.hasRole(this.user, 'admin')"/>
                        <button type="button" class="btn px-0 btn-link" @click="goToHome()">
                            Back to Home
                        </button>
                        <br />
                        <button type="button" class="btn px-0 btn-link" @click="logout()">
                            Logout
                        </button>
                    </b-card-body>
                </b-card>
            </b-card-group>
        </b-col>
    </b-row>
</div>
</div>
</template>

<script>
import AuthAPI from '../../api/auth.js'
import { AuthUtils } from '../../mixins/auth-utils.js';

export default {
    name: 'UserInfo',
    data () {
        return {
            user: {},
        }
    },
    created () {
        this.user = this.$store.get('user/user')
    },
    methods: {
        goToHome() {
            window.location.href = "/"
        },
        logout () {
            var vm = this
            AuthAPI.logout()
            .then(response => {
                vm.$store.dispatch('user/logout')
                vm.$router.push({ name: 'Login' })
            })
            .catch(function(error) {
                if (error.response) {
                    // Show message error
                    vm.$snotify.error("Server error")
                } else {
                    vm.$snotify.error("Network error")
                }
            })
        },
    },
    mixins:[
        AuthUtils,
    ],
}
</script>
