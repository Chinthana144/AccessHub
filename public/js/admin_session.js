$(document).ready(function () {
    
    $("#btn_fetch_session").click(function (e) { 
        e.preventDefault();
        
        var campID = $("#cmb_camp").val();
        var username = $("#txt_username").val();

        $.ajax({
            type: "get",
            url: "/fetchSession",
            data: {
                camp_id: campID,
                username: username,
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                
            }
        });

    });//fetch session

    $("#btn_fetch_user").click(function (e) { 
        e.preventDefault();
        
        var campID = $("#cmb_camp").val();
        var username = $("#txt_username").val();

        $.ajax({
            type: "get",
            url: "/getOneUserAdmin",
            data:{
                camp_id: campID,
                username: username,
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                
            }
        });

    });//fetch user

    //code check
    $("#btn_check").click(function (e) { 
        e.preventDefault();
        let campID = $("#cmb_check_camp").val();
        var codeInput = $("#txt_codes").val();

        $.ajax({
            type: "get",
            url: "/codeCheck",
            data: {
                camp_id: campID,
                txt_codes: codeInput,
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                
                console.log(response[0]);
                
            }
        });
        
    });

});//jquery