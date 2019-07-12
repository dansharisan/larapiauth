<script>
import { Bar } from 'vue-chartjs'
import { CustomTooltips } from '@coreui/coreui-plugin-chartjs-custom-tooltips'

export default {
    extends: Bar,
    props: [
        'height'
        , 'data'
    ],
    mounted () {
        const datasets = [
            {
                label: 'New user(s)',
                backgroundColor: 'rgba(255,255,255,.3)',
                borderColor: 'transparent',
                data: Object.values(this.data)
            }
        ]
        this.renderChart(
            {
                labels: Object.keys(this.data),
                datasets: datasets
            },
            {
                tooltips: {
                    enabled: false,
                    custom: CustomTooltips
                },
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        display: false,
                        categoryPercentage: 1,
                        barPercentage: 0.5
                    }],
                    yAxes: [{
                        display: false
                    }]
                }
            }
        )
    }
}
</script>

<style>
.chartjs-tooltip {
    position: absolute;
    z-index: 1021;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    padding: 0.25rem 0.5rem;
    color: #fff;
    pointer-events: none;
    background: rgba(0, 0, 0, 0.7);
    opacity: 0;
    transition: all 0.25s ease;
    -webkit-transform: translate(-50%, 0);
    transform: translate(-50%, 0);
    border-radius: 0.25rem;
}

.chartjs-tooltip .tooltip-header {
    margin-bottom: 0.5rem;
}

.chartjs-tooltip .tooltip-header-item {
    font-size: 0.765625rem;
    font-weight: 700;
}

.chartjs-tooltip .tooltip-body-item {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    font-size: 0.765625rem;
    white-space: nowrap;
}

.chartjs-tooltip .tooltip-body-item-color {
    display: inline-block;
    width: 0.875rem;
    height: 0.875rem;
    margin-right: 0.875rem;
}

.chartjs-tooltip .tooltip-body-item-value {
    padding-left: 1rem;
    margin-left: auto;
    font-weight: 700;
}
</style>
