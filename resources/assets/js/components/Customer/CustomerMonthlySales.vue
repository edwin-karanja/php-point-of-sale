<template>
    <div class="col-md-10 graph">
        <canvas id="customerMonthlyPurchases"></canvas>
    </div>

</template>

<script>
    export default {
        props: {
            customer: {}
        },

        data () {
            return {
                chart: null,
                borderWidth: 1,
                label: 'Daily total sales for a month',
                response: {
                    monthlySales: []
                }
            };
        },

        methods: {
            fetchChartData () {
                return axios.get('/customers/ajax/' + this.customer.id + '/monthly-purchases').then((response) => {
                    this.response = response.data
                })
            },

            getDate (day) {
                var  dt = new Date(), y = dt.getFullYear(), m = dt.getMonth()
                return new Date(y, m, day).toString().split(' ').slice(1,4).join('-')
            },

            loadChart (data) {
                var myChart = new Chart(this.chart, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(this.response.monthlySales).map(key => this.getDate(key)),
                        datasets: [{
                            label: this.label,
                            data: Object.keys(this.response.monthlySales).map(key => this.response.monthlySales[key]),
                            backgroundColor: this.setBackgroundColor(),
                            borderColor: this.setBorderColor(),
                            borderWidth: this.borderWidth
                        }],
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            },

            setBackgroundColor () {
                return [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ]
            },

            setBorderColor () {
                return [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ]
            }
        },

        mounted() {
            this.chart = document.getElementById("customerMonthlyPurchases").getContext('2d');

            this.fetchChartData().then(() => {
                this.loadChart()
            })

            this.getDate(7)
        }
    }
</script>

<style scoled>
    .graph {
        max-height: 500px;
    }
</style>