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

});//jquery