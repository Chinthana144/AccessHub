$(document).ready(function () {
    $("#btn_add_camp").click(function (e) { 
        e.preventDefault();
        $("#campAddModal").modal('toggle');
    });

    $("#tbl_camps").on('click', '.btn_edit_camp', function(){
        let row = $(this).closest('tr');
        let id = row.data('id');

        $("#hide_camp_id").val(id);

        $.ajax({
            type: "get",
            url: "/getOneCamp",
            data: {
                id: id,
            },
            // dataType: "dataType",
            success: function (response) {
                // console.log(response);                
                // alert(response["name"]);
                var is_upload = response['is_upload'];
                var is_active = response['status'];

                is_upload == 1 ? $("#chk_edit_upload_sheet").prop('checked', true) : $("#chk_edit_upload_sheet").prop('checked', false);
                is_active == 1 ? $("#chk_edit_active").prop('checked', true) : $("#chk_edit_active").prop('checked', false);

                $("#campEditModal").modal('toggle');

                $("#name").val(response['name']);
                $("#address").val(response['address']);
                $("#contactPerson").val(response['contactPerson']);
                $("#contactNo").val(response['contactNo']);
                $("#mikrotikHost").val(response['mikrotikHost']);
                $("#mikrotikPort").val(response['mikrotikPort']);
                $("#mikrotikUsername").val(response['mikrotikUsername']);
                $("#mikrotikPassword").val(response['mikrotikPassword']);
                $("#sheetID").val(response['sheetID']);
            }
        });
    });
    
});