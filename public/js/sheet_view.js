$(document).ready(function () {
    $("#btn_synchronize").prop('disabled', true);

    $("#btn_sync_sheets").click(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "/fetchGoogleSheets",
            // data: "data",
            // dataType: "dataType",
            beforeSend: function(){
                $("#sheetSyncedModal").modal('toggle');
                $("#loader").removeClass("loader-hidden").addClass('loader');
            },
            complete: function(){
                $("#loader").removeClass("loader").addClass('loader-hidden');
            },
            success: function (response) {
                console.log(response.length);
                let dataHtml = "";
                if(response.length > 0)
                {   
                    $("#btn_synchronize").prop('disabled', false);

                    dataHtml += "<table class='table'>";
                    dataHtml += "<thead>";
                    dataHtml += "<tr>";
                    dataHtml += "<th>Sheet Name</th>";
                    dataHtml += "<th>Month</th>";
                    dataHtml += "<th>Start Date</th>";
                    dataHtml += "<th>End Date</th>";
                    dataHtml += "<th>Has Code</th>";
                    dataHtml += "</tr>";
                    dataHtml += "</thead>";

                    dataHtml += "<tbody>";
                    $.each(response[0], function (key, val) { 
                        dataHtml += "<tr data-key='"+key+"' data-sheet = '"+val+"'>";
                        dataHtml += "<td>"+ val +"</td>";
                        dataHtml += "<td><input type='month' class='form-control select_month'></td>";
                        dataHtml += "<td><input type='text' class='form-control start_date' readonly></td>";
                        dataHtml += "<td><input type='text' class='form-control end_date' readonly></td>";
                        dataHtml += "<td><input type='checkbox' class='chk_code' value='yes'></td>";
                        dataHtml += "</tr>";
                    });
                    dataHtml += "</tbody>";

                    dataHtml += "</table>";

                }//has new sheets
                else{
                    dataHtml = "<p class='text-success'>All sheets are up to date!</p>";
                }

                $("#div_content").html(dataHtml);
            }//success
        });
    });

    $("#div_content").on('change', '.select_month', function(){
        let row = $(this).closest('tbody tr');
        let key = row.data('key');

        let input = row.find('.select_month').val();

        var parts = input.split('-');
        var year = parseInt(parts[0], 10);
        var month = parseInt(parts[1], 10);

        var startDate = new Date(year, month -1, 1);
        var endDate = new Date(year, month, 0);

        let startDateInput = row.find('.start_date').val(formatDate(startDate));
        let endDateInput = row.find('.end_date').val(formatDate(endDate));
    });

    $("#btn_synchronize").click(function(){
        let sheetData = [];

        $("#div_content tbody tr").each(function () {

        let row = $(this);

        sheetData.push({
                sheet_name: row.data("sheet"),
                month: row.find(".select_month").val(),
                start_date: row.find(".start_date").val(),
                end_date: row.find(".end_date").val(),
                has_code: row.find(".chk_code").is(":checked") ? 1 : 0
            });

        });
        console.log(sheetData);
        
        $.ajax({
            type: "post",
            url: "/saveSheetNames",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                sheets: sheetData,
            },
            dataType: "dataType",
            success: function (response) {
                console.log(response);
                $("#sheetSyncedModal").modal('hide');
            }
        });

    });

    //edit click
    $("#tbl_sheets").on('click', '.btn_edit_sheet', function(){
        var row = $(this).closest("tr");
        var sheetID = row.data('id');

        $.ajax({
            type: "get",
            url: "/getSheetByID",
            data: {
                sheetID: sheetID
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                var sheetName = response['name'];
                var startDate = response['start_date'];    
                var endDate = response['end_date'];
                var lastSync = response['last_synced_at'];    
                var hasData = response['has_data'];
                var status = response['status'];

                $("#edit_sheet_modal").modal('toggle');

                $("#edit_sheet_modal .modal-title").text("Edit sheet - " + sheetName);
                $("#hide_sheet_id").val(sheetID);

                $("#edit_start_date").val(startDate);
                $("#edit_end_date").val(endDate);

                $("#p_last_sync").text("Last Sync: " + lastSync);
                
                hasData == 1 ? $("#chk_has_code").prop('checked', true) : $("#chk_has_code").prop('checked', false);

                status == 1 ? $("#chk_active_sheet").prop('checked', true) : $("#chk_active_sheet").prop('checked', false);
            }
        });
    });

    //date formatter
    function formatDate(date) {
        var d = date.getDate();
        var m = date.getMonth() + 1; // Months are 0-indexed
        var y = date.getFullYear();
        return y + '-' + (m < 10 ? '0' + m : m) + '-' + (d < 10 ? '0' + d : d);
    }

});