<template>
    <div class="animated fadeIn">
        <b-row>
            <b-col sm="12">
                <c-table
                hover
                striped
                bordered
                small
                fixed
                caption="Users"
                :tableData="tableData"
                :fields="fields"
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
                { key: 'active', label: 'Status' },
                { key: 'created_at', label: 'Registered' },
            ]
        }
    },
    methods: {
    },
    created () {
        var vueComponent = this
        // Start loading
        vueComponent.tableData.loadStatus = 1
        UserAPI.getUsers()
        .then(response => {
            if (response.data.success) {
                vueComponent.tableData = response.data.data
                vueComponent.tableData.loadStatus = 2
            } else {
                vueComponent.tableData.loadStatus = 3
            }
        })
        .catch(error => {
            vueComponent.tableData.loadStatus = 3
        })
    },
}
</script>
