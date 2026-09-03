$(document).ready(function () {
    
    $("#btn_fetch_codes").click(function (e) { 
        e.preventDefault();
        
        var campID = $("#cmb_camp").val();
        var firstCharactor = $("#first_charactor").val();

        $.ajax({
            type: "get",
            url: "/fetchUserCodes",
            data: {
                camp_id: campID,
                first_charactor: firstCharactor,
            },
            beforeSend: function(){
                $("#p_fetch_status").text("Loading ...");
            },
            complete: function(){
                $("#p_fetch_status").text("");
            },
            // dataType: "dataType",
            success: function (response) {
                // console.log(response);
                
                $("#txt_code_filter").val(response);

            }
        });//ajax
    });

    $("#btn_generate").click(function (e) { 
        e.preventDefault();
        var campID = $("#cmb_camp").val();
        var codes = $("#txt_code_filter").val();
        var codeCount = $("#code_count").val();
        var profileName = $("#txt_profile").val();
        var firstCharactor = $("#first_charactor").val();

        $.ajax({
            type: "get",
            url: "/generateCodes",
            data: {
                camp_id : campID,
                codes : codes,
                code_count : codeCount,
                profile_name : profileName,
                first_charactor : firstCharactor,
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                
                let htmlData = "";
                
                $.each(response['users'], function (key, value) { 
                    htmlData += value['username'] + " " + value['password'] + "<br>";
                });
                
                $("#p_codes").html(htmlData);

            }
        });        
    });

});//jquery