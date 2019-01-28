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
            text: "Temperature"
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
            name: "Tokyo",
            marker: {
              symbol: "square"
            },
            data: [
              7.0,
              6.9,
              9.5,
              14.5,
              18.2,
              21.5,
              25.2,
              26.5,
              23.3,
              18.3,
              13.9,
              9.6
            ]
          }
        ]
      }
    };
  }
};
</script>

