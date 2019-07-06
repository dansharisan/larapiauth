<template>
    <header class="app-header navbar">
        <vue-snotify></vue-snotify>
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button" @click="mobileSidebarToggle">
            <span class="navbar-toggler-icon" />
        </button>
        <b-link class="navbar-brand" to="#"/>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" @click="sidebarToggle">
            <span class="navbar-toggler-icon" />
        </button>
        <b-navbar-nav class="d-md-down-none">
            <b-nav-item class="px-3" @click="goTo('/')">
                Home
            </b-nav-item>
            <b-nav-item class="px-3" @click="goTo('/api')">
                API Documentation
            </b-nav-item>
        </b-navbar-nav>
        <b-navbar-nav class="ml-auto">
            <header-dropdown />
        </b-navbar-nav>
    </header>
</template>
<script>
import HeaderDropdown from './HeaderDropdown.vue'

export default {
    name      : 'CHeader',
    components: { HeaderDropdown },
    props     : {
        fixed: {
            type   : Boolean,
            default: true,
        },
    },
    mounted () {
        if (this.fixed) $('body').addClass('header-fixed')
    },
    beforeDestroy () {
        $('body').removeClass('header-fixed')
    },
    methods: {
        goTo (path) {
            window.location.href = path;
        },
        sidebarToggle (e) {
            e.preventDefault()
            document.body.classList.toggle('sidebar-hidden')
        },
        sidebarMinimize (e) {
            e.preventDefault()
            document.body.classList.toggle('sidebar-minimized')
        },
        mobileSidebarToggle (e) {
            e.preventDefault()
            document.body.classList.toggle('sidebar-mobile-show')
        },
    },
}

</script>
