$(document).ready(function () {

    $("#cmb_camp").on('change', function(){
        var campID = $(this).val();

        if(campID != 0){
            $.ajax({
                type: "get",
                url: "/getSheetByCampID",
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

    $("#btn_fetch_codes").click(function (e) { 
        e.preventDefault();

        var campID = $("#cmb_camp").val();
        var sheetName = $("#cmb_sheet").val();
        
        $.ajax({
            type: "get",
            url: "/getCodes",
            data: {
                camp_id: campID,
                sheet_name: sheetName
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
            }
        });

    });

});//jquery