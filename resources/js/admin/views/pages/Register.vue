<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col
          md="6"
          sm="8"
        >
          <b-card
            no-body
            class="mx-4"
          >
            <b-card-body class="p-4">
              <h2>Register</h2>
              <p class="text-muted">
                Create your account
              </p>
              <b-input-group class="mb-3">
                <b-input-group-prepend>
                  <b-input-group-text><i class="icon-user" /></b-input-group-text>
                </b-input-group-prepend>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Username"
                >
              </b-input-group>

              <b-input-group class="mb-3">
                <b-input-group-prepend>
                  <b-input-group-text>@</b-input-group-text>
                </b-input-group-prepend>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Email"
                >
              </b-input-group>

              <b-input-group class="mb-3">
                <b-input-group-prepend>
                  <b-input-group-text><i class="icon-lock" /></b-input-group-text>
                </b-input-group-prepend>
                <input
                  type="password"
                  class="form-control"
                  placeholder="Password"
                >
              </b-input-group>

              <b-input-group class="mb-4">
                <b-input-group-prepend>
                  <b-input-group-text><i class="icon-lock" /></b-input-group-text>
                </b-input-group-prepend>
                <input
                  type="password"
                  class="form-control"
                  placeholder="Repeat password"
                >
              </b-input-group>

              <b-button
                variant="success"
                block
              >
                Create Account
              </b-button>
              <p class="text-center mb-1 mt-1">OR</p>
              <button type="button" class="btn btn-primary btn-block" @click="$router.push({ name: 'Login' })">
                  Login
              </button>
              <button type="button" class="btn px-0 btn-link float-right mt-2" @click="goToHome()">
                Back to Home
              </button>
            </b-card-body>
            <b-card-footer class="p-4">
              <b-row>
                <b-col cols="6">
                  <b-button
                    block
                    class="btn btn-facebook"
                  >
                    <span>facebook</span>
                  </b-button>
                </b-col>
                <b-col cols="6">
                  <b-button
                    block
                    class="btn btn-twitter"
                    type="button"
                  >
                    <span>twitter</span>
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
