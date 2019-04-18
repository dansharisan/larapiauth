<template>
    <b-card :header="caption" header-class="text-left" class="text-center">
        <loading-stretch v-if="tableData.loadStatus==1"></loading-stretch>
        <b-table v-else-if="tableData.loadStatus == 2"
        :hover="hover"
        :striped="striped"
        :bordered="bordered"
        :small="small"
        :fixed="fixed"
        :items="tableData.data"
        :fields="fields"
        :current-page="tableData.current_page"
        :per-page="tableData.per_page"
        responsive="sm"
       >
            <template slot="status" slot-scope="data" v-if="tableData.data.length > 0 && tableData.data[0].status">
                <b-badge :variant="getBadge(data.item.status)">
                    {{ data.item.status }}
                </b-badge>
            </template>
        </b-table>
        <p v-else class="text-center mb-0">Data load error!</p>
        <nav v-if="tableData.loadStatus == 2">
            <b-pagination
            v-model="tableData.current_page"
            :total-rows="tableData.total"
            :per-page="tableData.per_page"
            prev-text="Prev"
            next-text="Next"
            hide-goto-end-buttons
            />
        </nav>
    </b-card>
</template>

<script>
import LoadingStretch from 'vue-loading-spinner/src/components/Stretch.vue'
export default {
    name : 'cTable',
    components: {
        LoadingStretch
    },
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
    },
    data: () => {
       return {

        }
    },
    methods: {
        getBadge (status) {
            return status === 'Active' ? 'success'
            : status === 'Inactive' ? 'secondary'
            : status === 'Pending' ? 'warning'
            : status === 'Banned' ? 'danger' : 'primary'
        },
    },
    watch: {
        'tableData.current_page': function (newVal, oldVal) {
            var vueComponent = this
            if (oldVal && newVal) {
                this.tableData.loadStatus = 1
                axios.get(this.tableData.path + '?page=' + newVal)
                .then(response => {
                    if (response.data && response.data.success) {
                        vueComponent.tableData = response.data.data
                        vueComponent.tableData.loadStatus = 2
                        debugger
                    } else {
                        vueComponent.tableData.loadStatus = 3
                    }
                })
                .catch(error => {
                    // TODO: handle error
                    vueComponent.tableData.loadStatus = 3
                })
            }
        }
    }
}
</script>
