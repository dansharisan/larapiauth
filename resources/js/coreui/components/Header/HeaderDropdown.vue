<template>
    <b-nav-item-dropdown
    right
    no-caret
    >
    <template slot="button-content">
        <button type="button" class="btn btn-light">{{ user.email }}</button>
    </template>
    <b-dropdown-header
    tag="div"
    class="text-center"
    >
    <strong>Account</strong>
</b-dropdown-header>
<b-dropdown-item @click="logout()">
    <i class="fa fa-lock" /> Logout
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
            var vueComponent = this
            AuthAPI.logout()
            .then(response => {
                if (response.data && response.data.success) {
                    // Clear user in store
                    vueComponent.$store.dispatch('user/logout')
                    window.location.href = "/"
                } else {
                    // TODO: handle error
                    console.log(JSON.stringify(response))
                }
            })
            .catch(function(error) {
                // TODO: handle error
                console.log(JSON.stringify(error))
            })
        },
    },
}

</script>
