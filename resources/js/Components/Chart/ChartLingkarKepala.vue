<template>

    <div class="container">
        <Line v-if="loaded" :data="chartData" :options="chartOptions" />
    </div>
</template>

<script>
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js'
import { Line } from 'vue-chartjs'

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
)
import axios from 'axios';

export default {
    name: 'BarChart',
    components: { Line },
    props: ['id'],
    data: () => ({
        loaded: false,
        chartData: null,
        chartOptions: {
            responsive: true,
        }
    }),
    async mounted() {
        axios.get(route('api.balita.getLingkarKepala', { id: this.id }))
            .then((response) => {
                if (response.status == 200) {
                    this.chartData = {
                        labels: response.data.label,
                        datasets: [{
                            label: 'Pertumbuhan Lingkar Kepala',
                            data: response.data.data_chart,
                            backgroundColor: '#FFB534',
                            borderColor: '#FFB514',
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
