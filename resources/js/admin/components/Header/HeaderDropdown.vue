<template>
    <b-nav-item-dropdown right no-caret>
        <template slot="button-content">
            <button type="button" class="btn btn-light">{{ user.email }}</button>
        </template>
        <b-dropdown-header tag="div" class="text-center">
            <strong>Account</strong>
        </b-dropdown-header>
        <b-dropdown-item @click="logout()">
            <i class="fa fa-sign-out" /> Logout
        </b-dropdown-item>
    </b-nav-item-dropdown>
</template>
<script>
import AuthAPI from '../../api/auth.js'

export default {
    name: 'HeaderDropdown',
    data: () => {
        return {
            itemsCount: 42,
            user: null
        }
    },
    created () {
        this.user = this.$store.get('user/user')
    },
    methods: {
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
}

</script>
