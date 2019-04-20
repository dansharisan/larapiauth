<template>
    <b-card :header="caption" header-class="text-left" class="text-center">
        <loading-stretch v-if="loadStatus==1"></loading-stretch>
        <div v-else-if="loadStatus == 2">
            <b-input-group class="mb-3">
              <b-form-select
                @input="onChangePerPage"
                v-model="perPage"
                id="per_page"
                :plain="false"
                :options="[{ text: '15', value: 15}, { text: '30', value: 30}, { text: '50', value: 50}, { text: '100', value: 100}]"
                size="xs"
                value="Please select"
                class="col-1"
              />
              <b-input-group-append>
                  <b-input-group-text>items per page</b-input-group-text>
              </b-input-group-append>
            </b-input-group>

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
                <template slot="status" slot-scope="data" v-if="tableData.data.length > 0 && tableData.data[0].status">
                    <b-badge :variant="getBadge(data.item.status)">
                        {{ data.item.status }}
                    </b-badge>
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
            >
            </b-pagination>
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
        loadStatus: {
            type: Number,
            default: 0
        }
    },
    data: () => {
        return {
            currentPage: 1,
            perPage: window.localStorage.getItem('per_page') || 15
        }
    },
    methods: {
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
