<template>
    <ContentContainer title="Server Reports" class-names="relative pb-32 mb-24">
        <highcharts :options="chartOptions"></highcharts>
    </ContentContainer>
</template>

<script>
import { Chart } from "highcharts-vue";

export default {
	components: {
		highcharts: Chart
	},
	created(){

	},
	data() {
		return {
		chartOptions: {
			chart: {
				type: "spline"
			},
			title: {
				text: "Monthly Report"
			},
			xAxis: {
			categories: [
				"Jan",
				"Feb",
				"Mar",
				"Apr",
				"May",
				"Jun",
				"Jul",
				"Aug",
				"Sep",
				"Oct",
				"Nov",
				"Dec"
			]
			},
			yAxis: {
				title: {
					text: "No. of Queues"
				},
				labels: {
					formatter: function() {
					return this.value + "°";
					}
				}
			},
			tooltip: {
				crosshairs: true,
				shared: true
			},
			plotOptions: {
				spline: {
					marker: {
					radius: 4,
					lineColor: "#666666",
					lineWidth: 1
					}
				}
			},
			series: [
				{
					name: "Served",
					marker: {
					symbol: "square"
					},
					data: []
				}
			]
		}
		};
	}
};
</script>

