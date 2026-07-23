$(document).ready(function () {
    
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
                
            }
        });
    }//load area chart

});//jquery