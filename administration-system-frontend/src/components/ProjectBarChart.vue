<template>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Projects</h5>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control" v-model="year" @change.prevent="getBarChartData">
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="tasks-bar-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Chart from 'chart.js/auto'
    import axios from 'axios';
    export default {
        data() {
            return {
                year: '2024',
                myChart: null,
            }
        },
        computed: {
            // current_roles() {
            //     return this.$store.getters.current_roles
            // },
            // current_permissions() {
            //     return this.$store.getters.current_permissions
            // }
        },
        mounted() {
            this.getBarChartData()
            // this.$store.dispatch('getAuthRolesAndPermissions').then(() => {
            // });
        },
        methods: {
            getBarChartData() {
                axios.get(`getBarChartData/${this.year}`).then((response) => {
                    
                    let datasets = []

                        datasets.push({
                            label: `Assigned - Tasks - ${response.data.year}`,
                            data: response.data.projects_array,
                            borderWidth: 2,
                            borderColor: 'gray',
                            backgroundColor: 'lightgray'
                        })
                    

                        datasets.push({
                            label: `In progress - Tasks - ${response.data.year}`,
                            data: response.data.in_progess_array,
                            borderWidth: 2,
                            borderColor: 'blue',
                            backgroundColor: 'lightblue'
                        })
                    

                        datasets.push({
                            label: `finished  - Tasks - ${response.data.year}`,
                            data: response.data.finished_array,
                            borderWidth: 2,
                            borderColor: 'green',
                            backgroundColor: 'lightgreen'
                        })

                        datasets.push({
                            label: `Canceled  - Tasks - ${response.data.year}`,
                            data: response.data.canceled_array,
                            borderWidth: 2,
                            borderColor: 'red',
                            backgroundColor: 'red'
                        })
                    

                    if(this.myChart) this.myChart.destroy();
                    this.myChart = new Chart(document.getElementById('tasks-bar-chart').getContext("2d"), {
                        type: 'bar',
                        data: {
                            labels: response.data.months,
                            datasets: datasets,
                        },
                        options: {
                            responsive: true,
                        },
                    });

                }).catch(err => console.log(err));
            },
        }
    }
</script>