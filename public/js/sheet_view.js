$(document).ready(function () {
    
    $("#btn_sync_sheets").click(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "/fetchGoogleSheets",
            // data: "data",
            // dataType: "dataType",
            beforeSend: function(){
                $("#sheetSyncedModal").modal('toggle');
                $("#loader").removeClass("loader-hidden").addClass('loader');
            },
            complete: function(){
                $("#loader").removeClass("loader").addClass('loader-hidden');
            },
            success: function (response) {
                console.log(response);

                console.log(response[0].length);

                let dataHtml = "";
                dataHtml += "<table class='table'>";
                dataHtml += "<tr>";
                dataHtml += "<th>Sheet Name</th>";
                dataHtml += "<th>Month</th>";
                dataHtml += "<th>Start Date</th>";
                dataHtml += "<th>End Date</th>";
                dataHtml += "<th>Has Code</th>";
                dataHtml += "</tr>";

                $.each(response[0], function (key, val) { 
                    dataHtml += "<tr>";
                    dataHtml += "<td>"+ val +"</td>";
                    dataHtml += "<td>input</td>";
                    dataHtml += "</tr>";
                });

                dataHtml += "</table>";

                $("#div_content").html(dataHtml);
            }
        });
    });

    $("#btn_fetch_sheets").click(function (e) {
        e.preventDefault();
        
        // $.ajax({
        //     type: "get",
        //     url: "/fetchGoogleSheets",
        //     // data: {

        //     // },
        //     // dataType: "dataType",
        //     beforeSend: function(){
        //         $("#loader").removeClass("loader-hidden").addClass('loader');
        //     },
        //     complete: function(){
        //         $("#loader").removeClass("loader").addClass('loader-hidden');
        //     },
        //     success: function (response) {
        //         console.log(response);

        //         // console.log(response['sheetNames'][0]);

        //         let dataHtml = "";
        //         dataHtml += "pastha....";

        //         $("#div_content").html(dataHtml);
            
        //     }
        // });
    });

});