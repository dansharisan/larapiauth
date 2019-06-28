<template>
    <div class="app flex-row align-items-center">
        <div class="container">
            <b-row class="justify-content-center">
                <b-col md="4">
                    <b-card no-body class="mx-4">
                        <b-card-body class="p-4">
                            <h2>Register</h2>
                            <p class="text-muted">
                                Create your account
                            </p>
                            <b-input-group class="mb-3">
                                <b-input-group-prepend>
                                    <b-input-group-text>@</b-input-group-text>
                                </b-input-group-prepend>
                                <input type="text" class="form-control" placeholder="Email">
                            </b-input-group>

                            <b-input-group class="mb-3">
                                <b-input-group-prepend>
                                    <b-input-group-text><i class="icon-lock" /></b-input-group-text>
                                </b-input-group-prepend>
                                <input type="password" class="form-control" placeholder="Password">
                            </b-input-group>

                            <b-input-group class="mb-4">
                                <b-input-group-prepend>
                                    <b-input-group-text><i class="icon-lock" /></b-input-group-text>
                                </b-input-group-prepend>
                                <input type="password" class="form-control" placeholder="Repeat password">
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
                                <b-col cols="6" class="text-right">
                                    <!-- <b-loading v-if="request.status==1"></b-loading> -->
                                    <b-button variant="success" block>
                                        Register
                                    </b-button>
                                </b-col>
                            </b-row>
                        </b-card-body>
                        <b-card-footer class="p-4">
                            <b-row>
                                <b-col cols="6">
                                    <b-button block class="btn btn-facebook">
                                        <span class="ml-4">facebook</span>
                                    </b-button>
                                </b-col>
                                <b-col cols="6">
                                    <b-button block class="btn btn-twitter" type="button">
                                        <span class="ml-4">twitter</span>
                                    </b-button>
                                </b-col>
                            </b-row>
                        </b-card-footer>
                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        goToHome() {
            window.location.href = "/"
        },
    }
}
</script>
