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

});//jquery