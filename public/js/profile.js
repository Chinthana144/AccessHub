$(document).ready(function () {
    
    $("#re_new_password").on('keyup', function(){
        var newPassword = $("#new_password").val();
        var reNewPassword = $("#re_new_password").val();

        if(newPassword == reNewPassword)
        {
            $("#re_new_password").css('border-color', 'lime');
        }
        else
        {
            $("#re_new_password").css('border-color', 'firebrick');
        }
    });

});//jquery