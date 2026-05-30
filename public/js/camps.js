$(document).ready(function () {
    $("#btn_add_camp").click(function (e) { 
        e.preventDefault();
        $("#campAddModal").modal('toggle');
    });

    $("#tbl_camps").on('click', '.btn_edit_camp', function(){
        alert('clicked');
    });
});