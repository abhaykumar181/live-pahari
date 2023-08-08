jQuery(document).ready(function($) {

    // Validate User Create Form
    $(".form").validate({
        errorElement: 'span',
        errorClass: 'error',
        onkeyup: false,
        rules: {
            locationName: {
                required: true
            }
        },
        messages: {
            locationName: {
                required: "Please enter Location Name"
            }
        }, 
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.parent('div').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    
});
