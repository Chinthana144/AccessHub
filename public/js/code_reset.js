$(document).ready(function () {

    //run initially
    var campID = $("#cmb_camp").val();
    getIdentity(campID);

    //get one user
    $("#btn_fetch_user").click(function (e) { 
        e.preventDefault();
        
        var campID = $("#cmb_camp").val();
        var username = $("#username").val();

        if(username == "")
        {
            alert("Please enter username!");
            // $("#username").css("border-color", 'red');
            return
        }

        $.ajax({
            type: "get",
            url: "/getOneUser",
            data: {
                camp_id: campID,
                username: username,
            },
            beforeSend: function(){
                $("#div_content").html("");
                $("#end_time").val("");
                $("#loader").removeClass("loader-hidden").addClass('loader');
            },
            complete: function(){
                $("#loader").removeClass("loader").addClass('loader-hidden');
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                let htmlData = "";

                if(response['success'])
                {
                    $("#end_time").val(response['data']['end_time']);

                    var status = response['data']['disabled'] == "false" ? "Active" : "Disabled";
                    var status_class = response['data']['disabled'] == "false" ? "bg-success" : "bg-danger";
                    
                    htmlData += "<p class='mt-2'>Status: <span class='p-1 rounded text-white "+ status_class +"'>"+ status +"</span></p>";

                    htmlData += "<p>";
                    htmlData += "Username: <b>"+ response['data']['username'] +"</b></br>";
                    htmlData += "Password: <b>"+ response['data']['password'] +"</b></br>";
                    htmlData += "</p>";

                    htmlData += "<p>";
                    htmlData += "IP Address: " + response['data']['ip_address'] +"</br>";
                    htmlData += "MAC Address: " + response['data']['mac'] +"</br>";
                    htmlData += "Package: " + response['data']['profile'] +"</br>";
                    htmlData += "</p>";

                    htmlData += "<p>";
                    htmlData += "Login Date: <b>"+ response['data']['start_time'] +"</b></br>";
                    htmlData += "Expire Date: <b>"+ response['data']['end_time'] +"</b></br>";
                    htmlData += "</p>";
                }//response success
                else
                {
                    htmlData = "<p class='p-1 bg-warning text-white rounded fs-6'>";
                    htmlData += response['message'];
                    htmlData += "</p>";
                }//response failed
                
                $("#div_content").html(htmlData);
            }//ajax success
        });
    });

    //fetch session
    $("#btn_fetch_session").click(function (e) { 
        e.preventDefault();

        var campID = $("#cmb_camp").val();
        var username = $("#username").val();
        
        $.ajax({
            type: "get",
            url: "/getSessionByUsername",
            data: {
                camp_id: campID,
                username: username,
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                
            }
        });
    });

    //camp change
    $("#cmb_camp").on("change", function(){
        var campID = $(this).val();

        getIdentity(campID);
    });
    
    //get identity
    function getIdentity(campID)
    {
        $.ajax({
            type: "get",
            url: "/getIdentity",
            data: {
                camp_id: campID
            },
            // dataType: "dataType",
            success: function (response) {
                // console.log(response);
                if(response.length > 0)
                {
                    $("#div_identity").html("<span class='badge bg-success'>"+ response[0]['name'] +" online</span>");
                }
                else
                {
                    $("#div_identity").html("<span class='badge bg-danger'>Mikrotik Offline</span>");
                } 
            }
        });
    }//get identity

    //countdown
    function countdown()
    {
        var endTime = $("#end_time").val();
        var time = "";

        if(endTime != "")
        {
            const expireTime = new Date(endTime).getTime();
            const now = new Date().getTime();
            let distance = expireTime - now;

            if (distance <= 0) {
                time = "Expired!";
            }

            if(isNaN(distance))
            {
                time = "N/A";
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            time = "Expire in : <span class='text-success'><b>"+days+"d "+ hours+"h "+ minutes+"m "+ seconds +"s</b></span>";

            $("#p_countdown").html(time);
        }//has time
        else{
            $("#p_countdown").html("");
        }     
    }//time count down

    setInterval(countdown, 1000);

});//jquery