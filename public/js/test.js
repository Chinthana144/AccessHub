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
                
                let htmlData = "";

                $.each(response, function (key, value) { 
                    htmlData += "<p>";
                    htmlData += value['username'];
                    htmlData += value['password'];
                    htmlData += value['actual-profile'];
                    // htmlData += value['caller-id'];
                    htmlData += "</p>";
                });

                $("#div_data").html(htmlData);
            }//success
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
                
                let htmlData = "";

                htmlData += "<p>";
                $.each(response, function (key, value) { 
                    
                    htmlData += value['username'] + "<br>";
                    // htmlData += value['password'] + " ";
                    // htmlData += value['actual-profile'] + " ";
                    // htmlData += value['caller-id'];
                    
                });
                htmlData += "</p>";

                $("#div_data").html(htmlData);
                
            }//success
        });

    });

});//jquery