<template>
    <div class="animated fadeIn">
        <vue-snotify></vue-snotify>
        <b-row>
            <b-col sm="12">
                <c-table
                @page_changed="updateTableDataWithPage"
                @per_page_changed="updateTableDataWithPerPage"
                @ban_item="banUser"
                @unban_item="unbanUser"
                @delete_item="deleteUser"
                @delete_items="deleteUsers"
                @edit_item="editUser"
                hover
                striped
                bordered
                small
                caption="Users"
                :tableData="tableData"
                :fields="fields"
                :loadStatus="loadStatus"
                :submitStatus="submitStatus"
                />
            </b-col>
        </b-row>
    </div>
</template>

<script>
import cTable from './Table.vue'
import UserAPI from '../../../api/user.js'
export default {
    name      : 'Users',
    components: { cTable },
    data: function () {
        return {
            tableData: {},
            fields: [
                { key: 'checkbox', label: ' ' },
                { key: 'id', label: 'ID' },
                // { key: 'id', label: 'ID', thClass: 'd-none', tdClass: 'd-none' },  -> this is to hide this column
                { key: 'email' },
                { key: 'display_roles', label: 'Role(s)' },
                { key: 'status', label: 'Status' },
                { key: 'created_at', label: 'Registered' },
                { key: 'actions' }
            ],
            loadStatus: 0,
            submitStatus: 2
        }
    },
    methods: {
        updateTableDataWithPage(newPage, perPage) {
            this.getUsers(newPage, perPage)
        },
        updateTableDataWithPerPage(perPage) {
            this.getUsers(1, perPage)
        },
        deleteUsers(userIdsSeq, currentPage, perPage) {
            var vm = this
            vm.loadStatus = 1
            UserAPI.deleteUsers(userIdsSeq)
            .then(response => {
                if (response.data.success) {
                    vm.getUsers(currentPage, perPage)
                    vm.$snotify.success(response.data.message)
                } else {
                    vm.loadStatus = 3
                    vm.$snotify.error(response.data.message)
                }
            })
            .catch(error => {
                vm.loadStatus = 3
                if (error && error.response && error.response.data && error.response.data.message) {
                    vm.$snotify.error(error.response.data.message)
                }
            })
        },
        deleteUser(userId, currentPage, perPage) {
            var vm = this
            vm.loadStatus = 1
            UserAPI.deleteUser(userId)
            .then(response => {
                if (response.data.success) {
                    vm.getUsers(currentPage, perPage)
                    vm.$snotify.success(response.data.message)
                } else {
                    vm.loadStatus = 3
                    vm.$snotify.error(response.data.message)
                }
            })
            .catch(error => {
                vm.loadStatus = 3
                if (error && error.response && error.response.data && error.response.data.message) {
                    vm.$snotify.error(error.response.data.message)
                }
            })
        },
        banUser(userId, currentPage, perPage) {
            var vm = this
            vm.loadStatus = 1
            UserAPI.banUser(userId)
            .then(response => {
                if (response.data.success) {
                    vm.getUsers(currentPage, perPage)
                    vm.$snotify.success(response.data.message)
                } else {
                    vm.loadStatus = 3
                    vm.$snotify.error(response.data.message)
                }
            })
            .catch(error => {
                vm.loadStatus = 3
                if (error && error.response && error.response.data && error.response.data.message) {
                    vm.$snotify.error(error.response.data.message)
                }
            })
        },
        unbanUser(userId, currentPage, perPage) {
            var vm = this
            vm.loadStatus = 1
            UserAPI.unbanUser(userId)
            .then(response => {
                if (response.data.success) {
                    vm.getUsers(currentPage, perPage)
                    vm.$snotify.success(response.data.message)
                } else {
                    vm.loadStatus = 3
                    vm.$snotify.error(response.data.message)
                }
            })
            .catch(error => {
                vm.loadStatus = 3
                if (error && error.response && error.response.data && error.response.data.message) {
                    vm.$snotify.error(error.response.data.message)
                }
            })
        },
        getUsers(page = 1, perPage = 15) {
            var vm = this
            vm.loadStatus = 1
            UserAPI.getUsers(page, perPage)
            .then(response => {
                if (response.data.success) {
                    vm.tableData = response.data.data
                    vm.loadStatus = 2
                } else {
                    vm.loadStatus = 3
                }
            })
            .catch(error => {
                vm.loadStatus = 3
            })
        },
        editUser(userItem, currentPage, perPage) {
            var vm = this
            vm.submitStatus = 1
            UserAPI.editUser(userItem.id, userItem.email_verified_at, userItem.role_ids)
            .then(response => {
                if (response.data.success) {
                    vm.submitStatus = 2
                    vm.getUsers(currentPage, perPage)
                    vm.$snotify.success(response.data.message)
                } else {
                    vm.submitStatus = 3
                    vm.$snotify.error(response.data.message)
                }
            })
            .catch(error => {
                vm.submitStatus = 3
                if (error && error.response && error.response.data && error.response.data.message) {
                    vm.$snotify.error(error.response.data.message)
                }
            })
        }
    },
    created () {
        let perPage = window.localStorage.getItem('per_page') || 15
        this.getUsers(1, perPage)
    },
}
</script>
