jQuery(document).ready(function($) {

    // Validate User Create Form
    $(".form").validate({
        errorElement: 'span',
        errorClass: 'error',
        onkeyup: false,
        rules: {
            accountType: {
                required: true,
            },
            firstName: {
                required: true,
                minlength: 2
            },
            lastName: {
                required: true,
                minlength: 2
            },
            password: {
                required: true,
                minlength: 5
            },
            password_confirmation: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true
            },
            location: {
                required: true
            }
        },
        messages: {
            accountType: {
                required: "Please select account type",
            },
            firstName: {
                required: "Please enter First Name",
                minlength: "Your first name must consist of at least 2 characters"
            },
            lastName: {
                required: "Please enter last name",
                minlength: "Your last name must consist of at least 2 characters"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            password_confirmation: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            email: "Please enter a valid email address",
            location: {
                required: "Please enter location"
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
