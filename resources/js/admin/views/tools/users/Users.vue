<template>
    <div class="animated fadeIn">
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
                @create_item="createUser"
                @reset_validation="resetValidation"
                hover
                striped
                bordered
                small
                caption="Users"
                :tableData="tableData"
                :fields="fields"
                :loadStatus="loadStatus"
                :submitStatus="submitStatus"
                :message="message"
                :validation="validation"
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
            submitStatus: 2,
            message: '',
            validation: null
        }
    },
    methods: {
        resetValidation() {
            this.$nextTick(() => { this.validation = null })
        },
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
                vm.getUsers(currentPage, perPage)
                vm.$snotify.success("Deleted successfully")
            })
            .catch(error => {
                // Return back loadStatus value
                if (vm.tableData) {
                    vm.loadStatus = 2
                } else {
                    vm.loadStatus = 3
                }
                if (error && error.response) {
                    let msg = error.response.data.error ? error.response.data.error.message : error.response.data.message;
                    vm.$snotify.error("Failed to delete selected user(s): " + msg)
                } else {
                    vm.$snotify.error("Network error")
                }
            })
        },
        deleteUser(userId, currentPage, perPage) {
            var vm = this
            vm.loadStatus = 1
            UserAPI.deleteUser(userId)
            .then(response => {
                vm.getUsers(currentPage, perPage)
                vm.$snotify.success("Deleted successfully")
            })
            .catch(error => {
                // Return back loadStatus value
                if (vm.tableData) {
                    vm.loadStatus = 2
                } else {
                    vm.loadStatus = 3
                }
                if (error && error.response) {
                    let msg = error.response.data.error ? error.response.data.error.message : error.response.data.message;
                    vm.$snotify.error("Failed to delete this user: " + msg)
                } else {
                    vm.$snotify.error("Network error")
                }
            })
        },
        banUser(userId, currentPage, perPage) {
            var vm = this
            vm.loadStatus = 1
            UserAPI.banUser(userId)
            .then(response => {
                vm.getUsers(currentPage, perPage)
                vm.$snotify.success("Banned successfully")
            })
            .catch(error => {
                // Return back loadStatus value
                if (vm.tableData) {
                    vm.loadStatus = 2
                } else {
                    vm.loadStatus = 3
                }
                if (error && error.response) {
                    let msg = error.response.data.error ? error.response.data.error.message : error.response.data.message;
                    vm.$snotify.error("Failed to ban this user: " + msg)
                } else {
                    vm.$snotify.error("Network error")
                }
            })
        },
        unbanUser(userId, currentPage, perPage) {
            var vm = this
            vm.loadStatus = 1
            UserAPI.unbanUser(userId)
            .then(response => {
                vm.getUsers(currentPage, perPage)
                vm.$snotify.success("Unbanned successfully")
            })
            .catch(error => {
                // Return back loadStatus value
                if (vm.tableData) {
                    vm.loadStatus = 2
                } else {
                    vm.loadStatus = 3
                }
                if (error && error.response) {
                    let msg = error.response.data.error ? error.response.data.error.message : error.response.data.message;
                    vm.$snotify.error("Failed to unban this user: " + msg)
                } else {
                    vm.$snotify.error("Network error")
                }
            })
        },
        getUsers(page = 1, perPage = 15) {
            var vm = this
            vm.loadStatus = 1
            UserAPI.getUsers(page, perPage)
            .then(response => {
                vm.tableData = response.data.users
                vm.loadStatus = 2
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
                vm.submitStatus = 2
                vm.getUsers(currentPage, perPage)
                vm.$snotify.success("Edited successfully")
            })
            .catch(error => {
                // Return back loadStatus value
                if (vm.tableData) {
                    vm.submitStatus = 2
                } else {
                    vm.submitStatus = 3
                }
                if (error && error.response) {
                    vm.validation = error.response.data.validation;
                    let msg = error.response.data.error ? error.response.data.error.message : error.response.data.message;
                    vm.$snotify.error("Failed to create this user: " + msg)
                } else {
                    vm.$snotify.error("Network error")
                }
            })
        },
        createUser(userItem, currentPage, perPage) {
            var vm = this
            vm.submitStatus = 1
            UserAPI.createUser(userItem.email, userItem.email_verified_at, userItem.password, userItem.password, userItem.role_ids)
            .then(response => {
                vm.submitStatus = 2
                vm.getUsers(currentPage, perPage)
                vm.$snotify.success("Created successfully")
            })
            .catch(error => {
                // Return back loadStatus value
                if (vm.tableData) {
                    vm.submitStatus = 2
                } else {
                    vm.submitStatus = 3
                }
                if (error && error.response) {
                    vm.validation = error.response.data.validation;
                    let msg = error.response.data.error ? error.response.data.error.message : error.response.data.message;
                    vm.$snotify.error("Failed to create this user: " + msg)
                } else {
                    vm.$snotify.error("Network error")
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
