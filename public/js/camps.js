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