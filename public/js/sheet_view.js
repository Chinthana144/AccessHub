$(document).ready(function () {
    
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
                console.log(response);

                console.log(response[0].length);

                let dataHtml = "";
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
                    dataHtml += "<tr data-key='"+key+"'>";
                    dataHtml += "<td>"+ val +"</td>";
                    dataHtml += "<td><input type='month' class='form-control select_month'></td>";
                    dataHtml += "<td><input type='text' class='form-control start_date' readonly></td>";
                    dataHtml += "<td><input type='text' class='form-control end_date' readonly></td>";
                    dataHtml += "<td><input type='checkbox' class='chk_code' value='yes'></td>";
                    dataHtml += "</tr>";
                });
                dataHtml += "</tbody>";

                dataHtml += "</table>";

                $("#div_content").html(dataHtml);
            }
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

    //date formatter
    function formatDate(date) {
        var d = date.getDate();
        var m = date.getMonth() + 1; // Months are 0-indexed
        var y = date.getFullYear();
        return y + '-' + (m < 10 ? '0' + m : m) + '-' + (d < 10 ? '0' + d : d);
    }

});