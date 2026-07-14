$(document).ready(function () {

    $("#btn_submit").prop('disabled', true);

    $("#cmb_camp").on('change', function(){
        var campID = $(this).val();

        if(campID != 0){
            $.ajax({
                type: "get",
                url: "/getActiveSheetByCampID",
                data: {
                    camp_id: campID,
                },
                // dataType: "dataType",
                success: function (response) {
                    console.log(response);

                    $("#cmb_sheet").empty();
                    $("#cmb_sheet").append("<option value='0'>--- Select Sheet ---</option>");
                    $.each(response, function (key, value) { 
                        $("#cmb_sheet").append("<option value='"+value['name']+"'>"+ value['name'] +"</option>");
                    });
                }
            });
        }//has camp
        else{
            alert("Please select a camp!");
        }
    });

    //remove this later
    // $("#btn_fetch_codes").click(function (e) { 
    //     e.preventDefault();

    //     var campID = $("#cmb_camp").val();
    //     var sheetName = $("#cmb_sheet").val();
        
    //     $.ajax({
    //         type: "get",
    //         url: "/getCodes",
    //         data: {
    //             camp_id: campID,
    //             sheet_name: sheetName
    //         },
    //         // dataType: "dataType",
    //         success: function (response) {
    //             console.log(response);
    //         }
    //     });
    // });

    $("#btn_fetch_by_date").click(function (e) { 
        e.preventDefault();
        
        var campID = $("#cmb_camp").val();
        var sheetName = $("#cmb_sheet").val();
        var sheet_date = $("#sheet_date").val();

        $.ajax({
            type: "get",
            url: "/getCodesByDate",
            data: {
                camp_id: campID,
                sheet_name: sheetName,
                sheet_date: sheet_date
            },
            // dataType: "dataType",
            beforeSend: function(){
                $("#tbl_codes").html("");
                $("#div_totals").html("");
                $("#loader").removeClass("loader-hidden").addClass('loader');
            },
            complete: function(){
                $("#loader").removeClass("loader").addClass('loader-hidden');
            },
            success: function (response) {
                console.log(response);
                $("#btn_submit").prop('disabled', false);
                let i = 1;
                let row_count = 0;
                let total = 0;
                let free_count = 0;

                var htmlData = "";
                htmlData += "<tr>";
                htmlData += "<th>#</th>";
                htmlData += "<th>Date</th>";
                htmlData += "<th>Username</th>";
                htmlData += "<th>Password</th>";
                htmlData += "<th>Name</th>";
                htmlData += "<th>Room No</th>";
                htmlData += "<th>Amount</th>";
                htmlData += "</tr>";

                
                $.each(response['data'], function (key, value) { 
                    row_count++;
                    let amount = parseFloat(value['amount']);
                    if(isNaN(amount))
                    {
                        amount = 0;
                        free_count++;
                    }
                    total += parseFloat(amount);

                    htmlData += "<tr>";
                    htmlData += "<td>"+ i +"</td>";
                    htmlData += "<td>"+ value['date'] +"</td>";
                    htmlData += "<td>"+ value['username'] +"</td>";
                    htmlData += "<td>"+ value['password'] +"</td>";
                    htmlData += "<td>"+ value['name'] +"</td>";
                    htmlData += "<td>"+ value['room_no'] +"</td>";
                    htmlData += "<td>"+ amount.toFixed(2) +"</td>";
                    htmlData += "</tr>";
                    i++;
                });//each

                htmlData += "<tr>";
                htmlData += "<th colspan='6' class='text-e'>Total</th>";
                htmlData += "<th>"+ total.toFixed(2) +"</th>";
                htmlData += "</tr>";

                $("#tbl_codes").html(htmlData);

                //show totals
                let htmlTotals = "";
                htmlTotals += "<p>";
                htmlTotals += "Count: <b>"+ row_count + "</b></br>";
                htmlTotals += "Free: <b>"+ free_count + "</b></br>";
                htmlTotals += "Total: <b>"+ total.toFixed(2) + "</b></br>";
                htmlTotals += "</p>";

                $("#div_totals").html(htmlTotals);
            }
        });

    });

});//jquery