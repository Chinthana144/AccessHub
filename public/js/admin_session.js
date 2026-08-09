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
            url: "/getOneUser",
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

});//jquery