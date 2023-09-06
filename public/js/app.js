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
            $("#btn-confirm").one("click", false);
            $('.property-actions').submit();
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
            $("#btn-reject").one("click", false);
            $('.property-actions').submit();
        }else{
            // nothing to do
        }
    });
});


// $("#btn-reject").bind("click", function( event ) {
//     event.preventDefault(); 
//     swal({
//         title: "Are you sure?",
//         text: "Are you sure want to reject this request?",
//         icon: "warning",
//         buttons: true,
//         dangerMode: true,
//     }).then((confirmed) => {
//         if (confirmed) {
//             $('.property-actions').submit();
//         }else{
//             // nothing to do
//         }
//     });
//     $(this).unbind( event );
    
//   });
// pr([$checkoutDate, $calculatedCheckoutdate]);
