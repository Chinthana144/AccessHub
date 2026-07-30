$(document).ready(function () {
    
    $("#btn_general_cli").click(function (e) { 
        e.preventDefault();
        
        var txtCli = $("#txt_general_cli").val();
        var campID = $("#cmb_camp").val();

        $.ajax({
            type: "get",
            url: "/general-cli",
            data: {
                camp_id: campID,
                txt_cli: txtCli,
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
            }//show 
        });
    });//general CLI

    $("#btn_testing").click(function (e) { 
        e.preventDefault();
       
        var campID = $("#cmb_camp").val();

        $.ajax({
            type: "get",
            url: "/testing-cli",
            data: {
                camp_id: campID,
                parameter: "12345"
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                
            }//success
        });
    });

});//jquery