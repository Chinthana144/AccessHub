$(document).ready(function () {
    
    $("#btn_fetch").click(function (e) { 
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "/getUsers",
            // data: ,
            // dataType: "dataType",
            success: function (response) {
                console.log(response);                
            }
        });

    });

    //fetch all users
    $("#btn_fetch_users").click(function (e) { 
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "/getAllUsers",
            // data: "data",
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                
            }
        });

    });

});//jquery