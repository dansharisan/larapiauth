<template>
    <div class="animated fadeIn">
        <b-col sm="6" lg="3">
            <b-card no-body class="bg-info">
                <b-card-body class="pb-0">
                    <!-- <b-dropdown class="float-right" variant="transparent p-0" right>
                        <template slot="button-content">
                            <i class="icon-settings"></i>
                        </template>
                        <b-dropdown-item>Action</b-dropdown-item>
                        <b-dropdown-item>Another action</b-dropdown-item>
                    </b-dropdown> -->
                    <h4 class="mb-0">9.999</h4>
                    <p>Registered users</p>
                </b-card-body>
                <card-bar-chart chartId="card-chart-04" class="chart-wrapper px-3" style="height:70px;" height="70"/>
            </b-card>
        </b-col>
    </div>
</template>

<script>
import CardBarChart from './CardBarChart'
export default {
    name      : 'Dashboard',
    components: {
        CardBarChart,
    },
    data: function () {
        return {
        }
    },
    methods: {
    },
}
</script>
