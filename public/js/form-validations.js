jQuery(document).ready(function($) {

    // Validate login Form
    $(".login_form").validate({
        errorElement: 'span',
        errorClass: 'error',
        onkeyup: false,
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        messages: {
            email: {
                required: "Please enter Email",
                email: "Please enter valid Email"
            },
            password: {
                required: "Please enter Password",
            },

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

    // Validate Location Form
    $(".location_form").validate({
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


    // Validate Testimonial Form
    $(".testimonial_form").validate({
        errorElement: 'span',
        errorClass: 'error',
        onkeyup: false,
        rules: {
            name: {
                required: true
            },
            title: {
                required: true
            },
            testimonial: {
                required: true
            },
            testimonial_status: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter Name."
            },
            title: {
                required: "Please enter Title."
            },
            testimonial: {
                required: "Please enter Testimonial."
            },
            testimonial_status: {
                required: "Please select the Status."
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



