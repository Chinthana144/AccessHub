$(document).ready(function () {
    var areaChart;

    //load data
    loadAreaChart();

    function loadAreaChart()
    {
        $.ajax({
            type: "get",
            url: "/getAreaChartData",
            // data: "data",
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                
                var calDate = [];
                var totals = [];

                for (let i = 0; i < response.length; i++) {
                    calDate[i] = response[i]['issue_date'];
                    totals[i] = response[i]['total'];
                }//for

                var chart = {
                    chart: {
                        height: 280,
                        type: "area"
                    },
                    dataLabels: {
                        enabled: false
                    },
                    series: [
                        {
                        name: "Total",
                        data: totals
                        }
                    ],
                    fill: {
                        type: "gradient",
                        gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.9,
                        stops: [0, 90, 100]
                        }
                    },
                    xaxis: {
                        categories: calDate
                    }
                };

                if(areaChart){
                    areaChart.destroy();
                }
                areaChart = new ApexCharts(document.querySelector("#div_area_chart"), chart);
                areaChart.render();

            }//success
        });
    }//load area chart

});//jquery