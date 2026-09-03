$(document).ready(function () {
    
    $("#btn_restart").click(function (e) { 
        e.preventDefault();
        
        var campID = $("#cmb_camp").val();
        var txtCode = $("#txt_code").val();

        $.ajax({
            type: "get",
            url: "/codeRestart",
            data: {
                camp_id: campID,
                code : txtCode,
            },
            beforeSend: function(){
                $("#p_status").text("Processing ...");
            },
            complete: function(){
                $("#p_status").text("");
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                
                if(response['success'])
                {
                    alert(response['message']);
                }//success
                else
                {
                    alert(response['message']);
                }
            }//success response
        });

    });

});//jquery