<template>
    <div class="relative w-full md:w-[320px]  h-max" v-if="loaded">
        <Doughnut id="my-chart-id" :options="chartOptions" :data="chartData"
            class="w-[300px] sm:w-[10%] md:max-w-xs object-contain" />
    </div>
</template>

<script>
import { Chart as ChartJS, ArcElement, Tooltip, Legend, RadialLinearScale } from 'chart.js'
import { Doughnut } from 'vue-chartjs'
ChartJS.register(ArcElement, Tooltip, Legend, RadialLinearScale)


export default {
    name: 'ChartJumlah',
    components: { Doughnut },
    props: ['id'],
    data: () => ({
        loaded: false,
        chartData: null,
        chartOptions: {
            responsive: true,
            plugins:{
                legend:{
                    position:'right'
                },
                title:{
                    display: true,
                    text: 'Total Data   '
                }
            }
        }
    }),
    async mounted() {
        axios.get(route('api.Chart.getDoughnatChart'))
            .then((response) => {
                if (response.status == 200) {
                    this.chartData = {
                        labels: response.data.label,
                        datasets: [{
                            label: 'Total Data',
                            data: response.data.data_chart,
                            backgroundColor: [
                                '#ED9455',
                                '#41B06E',
                                '#DF2E38',
                            ],
                            borderColor: [
                                '#FFBB70',
                                '#8DECB4',
                                '#FF8080',
                            ],
                            borderWidth: 3
                        }]
                    }
                    this.loaded = true;
                } else {
                    console.error('Error loading data:', response.status, response.statusText)
                }
            })
            .catch((error) => {
                console.error('Error loading data:', error)
            })
    }
}
</script>
