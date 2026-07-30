$(document).ready(function () {
    
    $("#btn_search").click(function (e) { 
        e.preventDefault();
        
        var txtSearch = $("#txt_search").val();
        var campID = $("#cmb_camp").val();

        if(campID == 0)
        {
            alert("Please select a camp!");
            return;
        }

        $.ajax({
            type: "get",
            url: "/codeSearch",
            data: {
                camp_id : campID,
                txt_search: txtSearch
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);

                loadTable(response);
            }//success
        });
    });

    $("#div_table").on('click', '.btn_edit_code', function(){
        let row = $(this).closest('tr');
	    let id = row.data('id');

        $.ajax({
            type: "get",
            url: "/getOneCode",
            data: {
                code_id : id,
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                
                $("#code_edit_modal").modal('toggle');

                $("#code_edit_id").val(id);
                $("#issue_date").val(response['issue_date']);
                $("#customer_name").val(response['customer_name']);
                $("#room_no").val(response['room_no']);
                $("#amount").val(response['amount']);
                $("#note").val(response['note']);

                //show code
                let htmlData = "";
                htmlData += "Username: <b>" + response['username'] + "</b></br>";
                htmlData += "password: <b>" + response['password'] + "</b></br>";

                $("#p_code_details").html(htmlData);
            }
        });
    });

    //delete code
    $("#div_table").on('click', '.btn_delete_code', function(){
        let row = $(this).closest('tr');
	    let id = row.data('id');
        let campID = $("#cmb_camp").val();
        let txt_search = $("#txt_search").val();

        let result =  confirm("Are you sure you want to delete code?");

        if(result){
            $.ajax({
                type: "get",
                url: "/delete_code",
                data: {
                    code_id: id,
                    camp_id: campID,
                    txt_search: txt_search
                },
                // dataType: "dataType",
                success: function (response) {
                    console.log(response);
                    
                    if(response['action'] == 'reload')
                    {
                        location.reload();
                    }
                    else{
                        loadTable(response['data']);
                    }
                }
            });           
        }
        else{
            return;
        }//no
    });

    function loadTable(data)
    {
        let htmlData = "";

        htmlData += "<table class='table'>";
        htmlData += "<tr>";
        htmlData += "<th>#</th>";
        htmlData += "<th>Date</th>";
        htmlData += "<th>Username</th>";
        htmlData += "<th>Password</th>";
        htmlData += "<th>Name</th>";
        htmlData += "<th>Room No</th>";
        htmlData += "<th>Amount</th>";
        htmlData += "<th>Note</th>";
        htmlData += "<th>Action</th>";
        htmlData += "</tr>";
        
        let i = 1;
        $.each(data, function (key, value) { 
            htmlData += "<tr data-id='"+ value['id'] +"'>";
            htmlData += "<td>"+ i +"</td>";
            htmlData += "<td>"+ value['issue_date'] +"</td>";
            htmlData += "<td>"+ value['username'] +"</td>";
            htmlData += "<td>"+ value['password'] +"</td>";
            htmlData += "<td>"+ value['customer_name'] +"</td>";
            htmlData += "<td>"+ value['room_no'] +"</td>";
            htmlData += "<td>"+ value['amount'] +"</td>";
            htmlData += "<td>"+ value['note'] +"</td>";
            htmlData += "<td>";
            htmlData += "<button class='btn btn-outline-warning btn-sm btn_edit_code'><i class='bx bx-edit'></i></button>";
            htmlData += "<button class='btn btn-outline-danger btn-sm btn_delete_code'><i class='bx bx-trash'></i></button>";
            htmlData += "</td>";
            htmlData += "</tr>";

            i++;
        });
        htmlData += "</table>"

        $("#div_table").html(htmlData);
    }//load table

    // setTimeout(() => {
    //     $("#txt_search").on('keyup', function(){
    //     var txtSearch = $(this).val();

    //     alert("response = " + txtSearch);
 
    //     });
    // }, 500);

});//jquery