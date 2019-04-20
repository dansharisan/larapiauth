<template>
    <div class="animated fadeIn">
        <b-row>
            <b-col sm="12">
                <c-table @page_changed="updateTableDataWithPage" @per_page_changed="updateTableDataWithPerPage"
                hover
                striped
                bordered
                small
                fixed
                caption="Users"
                :tableData="tableData"
                :fields="fields"
                :loadStatus="loadStatus"
                />
            </b-col>
        </b-row>
    </div>
</template>

<script>
import cTable from '../base/Table.vue'
import UserAPI from '../../api/user.js'
export default {
    name      : 'Users',
    components: { cTable },
    data: function () {
        return {
            tableData: {},
            fields: [
                { key: 'id', label: 'ID' },
                { key: 'email' },
                { key: 'display_roles', label: 'Role(s)' },
                { key: 'status', label: 'Status' },
                { key: 'created_at', label: 'Registered' },
            ],
            loadStatus: 0
        }
    },
    methods: {
        updateTableDataWithPage(newPage, perPage) {
            this.getUsers(newPage, perPage)
        },
        updateTableDataWithPerPage(perPage) {
            this.getUsers(1, perPage)
        },
        getUsers(page = 1, perPage = 25) {
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
        }
    },
    created () {
        let perPage = window.localStorage.getItem('per_page') || 25
        this.getUsers(1, perPage)
    },
}
</script>
