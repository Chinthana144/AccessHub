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
                
                $("#edit_permission_modal").modal('toggle');

                $("#hide_permission_id").val(response['id']);
                $("#cmb_edit_role").val(response['role_id']);
                $("#cmb_edit_page").val(response['page_id']);
                
                response['can_create'] == 1 ? $("#chk_edit_create").prop('checked', true) : $("#chk_edit_create").prop('checked', false);
                response['can_edit'] == 1 ? $("#chk_edit_edit").prop('checked', true) : $("#chk_edit_edit").prop('checked', false); 
                response['can_view'] == 1 ? $("#chk_edit_view").prop('checked', true) : $("#chk_edit_view").prop('checked', false); 
                response['can_delete'] == 1 ? $("#chk_edit_delete").prop('checked', true) : $("#chk_edit_delete").prop('checked', false); 
            }//success
        });
    });//edit click

    $("#tbl_permission").on('click', '.btn_delete_permission', function(){
        let row = $(this).closest('tr');
        let id = row.data('id');

        let result = confirm("Are you sure you want to delete permission!");

        if(result)
        {
            $.ajax({
                type: "get",
                url: "/delete-permission",
                data: {
                    permission_id: id,
                },
                // dataType: "dataType",
                success: function (response) {
                    console.log(response);
                    
                    if(response['success'])
                    {
                        location.reload();
                    }
                }
            });
        }//yes
        else{
            return;
        }
    });//delete

});//jquery