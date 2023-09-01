// Confirming Property.
$(document).on('click', '#btn-confirm', function(e) {
    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Are you sure want to confirm this request?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((confirmed) => {
        if (confirmed) {
            $('.confirm-property').submit();
        }else{
            // nothing to do
        }
    });
});

// Rejecting Property.
$(document).on('click', '#btn-reject', function(e) {
    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Are you sure want to reject this request?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((confirmed) => {
        if (confirmed) {
            $('.reject-property').submit();
        }else{
            // nothing to do
        }
    });
});

