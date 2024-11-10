$(document).ready(function () {
    function changeStatus (taskID, newStatus) {
        $.ajax({
            url: '?action=change_status',
            type: 'POST',
            data: {id: taskID, status: newStatus},
            dataType: 'json',
            success: function(data) {
                if (data.success){
                    const statusElem = $('#status-' + taskID);
                    if(newStatus === 'pending'){
                        statusElem.removeClass('btn-success').addClass('btn-warning');
                        statusElem.text('Pending');
                    } else {
                        statusElem.text('Completed');
                        statusElem.removeClass('btn-warning').addClass('btn-success');
                    }
                    
                } else {
                    console.log("Failed to update status:", data.error);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    }

    $('.status-toggle').on('click', function () {
        const taskID = $(this).data('id');
        const currentStatus = $(this).data('status');
        const newStatus = currentStatus === 'pending' ? 'completed' : 'pending';

        changeStatus(taskID, newStatus);

        $(this).data('status', newStatus);
    });
});