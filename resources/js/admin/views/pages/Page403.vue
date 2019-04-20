<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="6">
          <div class="clearfix">
            <h2 class="float-left display-3 mr-4">
              403
            </h2>
            <h4 class="pt-3">
              Restricted area.
            </h4>
            <p class="text-muted">
              You're not authorized to access this page.
            </p>
            <button type="button" class="btn px-0 btn-link" @click="goToHome()">
              Back to Home
            </button>
          </div>
          <!-- <b-input-group>
            <b-input-group-prepend>
              <b-input-group-text>
                <i class="fa fa-search" />
              </b-input-group-text>
            </b-input-group-prepend>
            <input
              id="prependedInput"
              class="form-control"
              size="16"
              type="text"
              placeholder="What are you looking for?"
            >
            <b-input-group-append>
              <b-button variant="info">
                Search
              </b-button>
            </b-input-group-append>
          </b-input-group> -->
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
export default {
    name: 'Page403',
    methods: {
        goToHome() {
            window.location.href = "/"
        },
    }
}
</script>
