<template>
    <b-card :header="caption" header-class="text-left" class="text-center">
        <b-loading v-if="loadStatus==1"></b-loading>
        <div v-else-if="loadStatus == 2">
            <div class="row justify-content-between">
                <div class="col-4">
                    <b-input-group class="mb-3 input-group-sm">
                      <b-form-select
                        @input="onChangePerPage"
                        v-model="perPage"
                        id="per_page"
                        :plain="false"
                        :options="[{ text: '15', value: 15}, { text: '30', value: 30}, { text: '50', value: 50}]"
                        size="xs"
                        value="Please select"
                        class="col-2"
                      />
                      <b-input-group-append>
                          <b-input-group-text>items per page</b-input-group-text>
                      </b-input-group-append>
                    </b-input-group>
                </div>
                <div class="col-2 text-right">
                    <b-button size="sm" class="btn-action" variant="danger" @click="deleteItems()" v-if="hasChecked">
                        <i class="fa fa-remove text-white" aria-hidden="true"></i> <span class="text-white">Delete</span>
                    </b-button>
                    <b-button size="sm" class="btn-action" variant="primary" @click="createItem()">
                        <i class="fa fa-file-o text-white" aria-hidden="true"></i> <span class="text-white">Create</span>
                    </b-button>
                </div>
            </div>

            <b-table
            :hover="hover"
            :striped="striped"
            :bordered="bordered"
            :small="small"
            :fixed="fixed"
            :items="tableData.data"
            :fields="fields"
            :current-page="currentPage"
            per-page=0
            responsive="sm"
            >
                <template slot="checkbox" slot-scope="row">
                    <b-form-checkbox
                      :id="'checkbox-item-' + row.item.id"
                      :name="'checkbox-item-' + row.item.id"
                      class="checkbox-item"
                      @input="selectItem(row)"
                      value="checked"
                      unchecked-value="unchecked"
                    >
                    </b-form-checkbox>
                </template>
                <template slot="status" slot-scope="row" v-if="tableData.data.length > 0 && tableData.data[0].status">
                    <b-badge :variant="getBadge(row.item.status)">
                        {{ row.item.status }}
                    </b-badge>
                </template>
                <template slot="actions" slot-scope="row">
                    <b-button size="sm" class="btn-action" variant="warning" @click="editItem(row.item)">
                        <i class="fa fa-pencil-square-o text-white" aria-hidden="true"></i> <span class="text-white">Edit</span>
                    </b-button>
                    <b-button size="sm" class="btn-action" variant="danger" @click="deleteItem(row.item)">
                        <i class="fa fa-trash-o text-white" aria-hidden="true"></i> <span class="text-white">Delete</span>
                    </b-button>
                    <b-button size="sm" class="btn-action" variant="success" @click="unbanItem(row.item)" v-if="row.item.status == 'Banned'">
                        <i class="fa fa-unlock text-white" aria-hidden="true"></i> <span class="text-white">Unban</span>
                    </b-button>
                    <b-button size="sm" class="btn-action" variant="danger" @click="banItem(row.item)" v-if="row.item.status != 'Banned'">
                        <i class="fa fa-lock text-white" aria-hidden="true"></i> <span class="text-white">Ban</span>
                    </b-button>
                </template>
            </b-table>
        </div>
        <p v-else class="text-center mb-0">Data load error.</p>
        <nav v-if="loadStatus == 2">
            <b-pagination
            v-model="currentPage"
            :total-rows="tableData.total"
            :per-page="tableData.per_page"
            prev-text="Prev"
            next-text="Next"
            hide-goto-end-buttons
            class="mb-0"
            size="sm"
            >
            </b-pagination>
        </nav>
    </b-card>
</template>

<script>
export default {
    name : 'cTable',
    props: {
        caption: {
            type   : String,
            default: 'Table',
        },
        hover: {
            type   : Boolean,
            default: false,
        },
        striped: {
            type   : Boolean,
            default: false,
        },
        bordered: {
            type   : Boolean,
            default: false,
        },
        small: {
            type   : Boolean,
            default: false,
        },
        fixed: {
            type   : Boolean,
            default: false,
        },
        tableData: {
            type : Object,
            default: {},
        },
        fields: {
            type : Array,
            default: [],
        },
        loadStatus: {
            type: Number,
            default: 0
        }
    },
    data: () => {
        return {
            currentPage: 1,
            perPage: window.localStorage.getItem('per_page') || 15,
            hasChecked: false
        }
    },
    methods: {
        selectItem (row) {
            if ($('table .checkbox-item input').filter(':checked').length > 0) {
                this.hasChecked = true
            } else {
                this.hasChecked = false
            }
        },
        createItem () {
            alert('TODO: create item')
        },
        editItem (row) {
            alert('TODO: edit item')
        },
        deleteItem (row) {
            alert('TODO: delete item')
        },
        deleteItems (row) {
            alert('TODO: delete items')
        },
        banItem (row) {
            alert('TODO: ban item')
        },
        unbanItem (row) {
            alert('TODO: unban item')
        },
        getBadge (status) {
            return status === 'Active' ? 'success'
            : status === 'Inactive' ? 'secondary'
            : status === 'Banned' ? 'danger' : 'primary'
        },
        onChangePerPage (newPerPage) {
            // Remember user's preference for per_page
            window.localStorage.setItem('per_page', newPerPage)
        }
    },
    watch: {
        currentPage: function (newVal, oldVal) {
            // Request to change data, but not on the first load
            if (oldVal) {
                this.$emit('page_changed', newVal, this.perPage)
            }
        },
        perPage: function (newVal, oldVal) {
            // Request to change data, but not on the first load
            if (oldVal) {
                this.$emit('per_page_changed', newVal)
            }
        },
    },
}
</script>
