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
        :fields="tableData.fields"
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
            default: false,
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
}
</script>
