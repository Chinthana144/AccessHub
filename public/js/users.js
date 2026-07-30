$(document).ready(function () {
    
    $("#btn_create_user").click(function (e) { 
        e.preventDefault();
        $("#add_user_modal").modal('toggle');
    });

    //password check
    $("#re_password").on('keyup', function(){
        var rePassword = $(this).val();
        var password = $("#password").val();

        if(rePassword === password){
            $("#re_password").css('border-color', 'lime');
        }
        else{
            $("#re_password").css('border-color', 'firebrick');
        }
    });

    $("#tbl_users").on('click', '.btn_edit_user', function(){
        let row = $(this).closest('tr');
        let id = row.data('id');

        $.ajax({
            type: "get",
            url: "/getUser",
            data: {
                user_id: id,
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                
                $("#edit_user_modal").modal('toggle');

                $("#hide_user_id").val(id);
                $("#cmb_edit_role").val(response['role_id']);
                $("#edit_name").val(response['name']);
                $("#edit_email").val(response['email']);
            }
        });
    });

    $("#tbl_users").on('click', '.btn_change_password', function(){
        let row = $(this).closest('tr');
        let id = row.data('id');

        $("#edit_pwd_modal").modal('toggle');

        $("#pwd_change_id").val(id);

        $.ajax({
            type: "get",
            url: "/getUser",
            data: {
                user_id: id,
            },
            // dataType: "dataType",
            success: function (response) {
                let htmlData = "";
                
                htmlData += "User: <b>" + response['name'] + "</b></br>";
                htmlData += "Email: <b>" + response['email'] + "</b></br>";

                $("#p_user_data").html(htmlData);
            }
        });
    });

    //check new password
    $("#new_re_password").on('keyup', function(){
        var rePassword = $(this).val();
        var password = $("#new_password").val();

        if(rePassword === password){
            $("#new_re_password").css('border-color', 'lime');
        }
        else{
           $("#new_re_password").css('border-color', 'firebrick'); 
        }
    });

});//jquery