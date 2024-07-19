<template>
    <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: 'BarChart',
    components: { Bar },
    data() {
        return {
            title: 'Jenis Imunisasi',
            chartData: {
                labels: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'Mai',
                    'Jun',
                    'Jul',
                    'Agus',
                    'Sept',
                    'Okt',
                    'Nov',
                    'Des'
                ],
                datasets: [
                    {
                        label: 'Imunisasi A',
                        data: [
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt()
                        ],
                        backgroundColor: 'rgba(255, 99, 132 , 0.7)',
                        borderColor: 'rgb(255, 99, 132)',
                    },
                    {
                        label: 'Imunisasi B',
                        data: [
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt(),
                            this.getRandomInt()
                        ],
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 0.2)',
                    }
                ]
            },
            chartOptions: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Jenis Imunisasi'
                    }
                }
            }
        }
    },
    methods: {
        getRandomInt() {
            return Math.floor(Math.random() * (50 - 5 + 1)) + 5
        }
    },
}
</script>
