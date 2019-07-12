<template>
    <div class="animated fadeIn">
        <b-col sm="6" lg="3">
            <b-card no-body class="bg-info">

                <template v-if="userStats.loadStatus == 1">
                    <b-card-body class="pb-0 text-center">
                        <b-loading background="#fff" size="57px"></b-loading>
                    </b-card-body>
                    <div style="height: 70px;">&nbsp;</div>
                </template>

                <template v-else-if="userStats.loadStatus == 2">
                    <b-card-body class="pb-0">
                        <!-- <b-dropdown class="float-right" variant="transparent p-0" right>
                            <template slot="button-content">
                                <i class="icon-settings"></i>
                            </template>
                            <b-dropdown-item>Action</b-dropdown-item>
                            <b-dropdown-item>Another action</b-dropdown-item>
                        </b-dropdown> -->
                        <h4 class="mb-0">{{ userStats.totalUser }}</h4>
                        <p>Registered users</p>
                    </b-card-body>
                    <card-bar-chart chartId="card-chart-04" class="chart-wrapper px-3" style="height:70px;" height="70"/>
                </template>

                <template v-else-if="userStats.loadStatus == 3">
                    <b-card-body class="pb-0 text-center" style="margin-top: 25px">
                        <p>Data load error</p>
                    </b-card-body>
                    <div style="height: 70px;">&nbsp;</div>
                </template>
            </b-card>
        </b-col>
    </div>
</template>

<script>
import UserAPI from '../../../api/user.js'
import CardBarChart from './CardBarChart'
export default {
    name      : 'Dashboard',
    components: {
        CardBarChart,
    },
    data: function () {
        return {
            userStats: {
                loadStatus: 0,
                totalUser: 0,
                last7DayStats: []
            },
        }
    },
    methods: {
    },
    created () {
        var vm = this;
        vm.userStats.loadStatus = 1
        UserAPI.getUserStats()
        .then(response => {
            vm.userStats.totalUser = response.data.user_stats.total
            vm.userStats.last7DayStats = response.data.user_stats.last_7_day_stats
            vm.userStats.loadStatus = 2
        })
        .catch(error => {
            vm.userStats.loadStatus = 3
        })
    },
}
</script>
