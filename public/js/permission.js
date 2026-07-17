$(document).ready(function () {
    
    $("#btn_create_permission").click(function (e) { 
        e.preventDefault();
        
        $("#add_permission_modal").modal('toggle');

    });

    $("#tbl_permission").on('click', '.btn_edit_permission', function(){
        let row = $(this).closest('tr');
        let id = row.data('id');

        //fetch permission
        $.ajax({
            type: "get",
            url: "/getOnePermission",
            data: {
                permission_id: id
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                
            }
        });
    });//edit click

});//jquery