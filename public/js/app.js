// Confirming Property.
$(document).on('click', '#btn-confirm', function(e) {
    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Are you sure want to confirm this confirmation request?",
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

