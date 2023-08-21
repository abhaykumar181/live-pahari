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



    // Validate Addon Form
    $(".addon_form").validate({
        errorElement: 'span',
        errorClass: 'error',
        onkeyup: false,
        rules: {
            title: {
                required: true
            },
            description: {
                required: true
            },
            "locations[]": "required",
            thumbnail: {
                required: function(element){
                    return ($("input[name='thumbnailName']").length < 1 || $("input[name='thumbnailName']").val() == "");
                }
            },
            price: {
                required: true
            },
            priceType: {
                required: true
            },
            addon_status: {
                required: true
            },
            locations: {
                required: true
            },
            
        },
        messages: {
            title: {
                required: "Please enter Title."
            },
            description: {
                required: "Please enter Description."
            },
            "locations[]": "Please choose Locations.",
            thumbnail: {
                required: "Please select an Image."
            },
            price: {
                required: "Please enter Price."
            },
            priceType: {
                required: "Please select the Price type."
            },
            addon_status: {
                required: "Please select the Status."
            },
            locations: {
                required: "Please select locations."
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



    // Validate Addon Form
    $(".property_form").validate({
        errorElement: 'span',
        errorClass: 'error',
        onkeyup: false,
        rules: {
            title: {
                required: true
            },
            description: {
                required: true
            },
            "locations[]": "required",
            thumbnail: {
                required: function(element){
                    return ($("input[name='thumbnailName']").length < 1 || $("input[name='thumbnailName']").val() == "");
                }
            },
            price: {
                required: true
            },
            priceType: {
                required: true
            },
            addon_status: {
                required: true
            },
            ownerName: {
                required: true
            },
            email: {
                required: true
            },
            phone: {
                required: true
            },
            confirmation: {
                required: true
            },
            
        },
        messages: {
            title: {
                required: "Please enter Title."
            },
            description: {
                required: "Please enter Description."
            },
            "locations[]": "Please choose Locations.",
            thumbnail: {
                required: "Please select an Image."
            },
            price: {
                required: "Please enter Price."
            },
            priceType: {
                required: "Please select the Price type."
            },
            addon_status: {
                required: "Please select the Status."
            },
            ownerName: {
                required: "Please enter the Owner Name."
            },
            email: {
                required: "Please enter the Owner Email."
            },
            phone: {
                required: "Please enter the Phone Number."
            },
            confirmation: {
                required: "Please choose the Confirmation."
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



     // Validate Package Form
     $(".package_form").validate({
        errorElement: 'span',
        errorClass: 'error',
        onkeyup: false,
        ignore: ".ignore",
        rules: {
            title: {
                required: true
            },
            description: {
                required: true
            },
            howtoReach: {
                required: true
            },
            extraDetails: {
                required: true
            },
            numberofDays: {
                required: true
            },
            "locations[]": "required",
            thumbnail: {
                required: function(element){
                    return ($("input[name='thumbnailName']").length < 1 || $("input[name='thumbnailName']").val() == "");
                }
            },
            price: {
                required: true
            },
            
            
        },
        messages: {
            title: {
                required: "Please enter Title."
            },
            description: {
                required: "Please enter Description."
            },
            howtoReach: {
                required:  "Please enter How to reach."
            },
            extraDetails: {
                required:  "Please enter Extra Details."
            },
            numberofDays: {
                required: "Please enter Number of days."
            },
            "locations[]": "Please choose Locations.",
            thumbnail: {
                required: "Please select an Image."
            },
            price: {
                required: "Please enter Price."
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


     // Itinerary Form 
    //  $(".itineraries_form").validate({
    //     errorElement: 'span',
    //     errorClass: 'error',
    //     onkeyup: false,
    //     ignore: ".ignore",
    //     rules: {
           
    //     },
    //     messages: {
            
    //     }, 
    //     errorPlacement: function (error, element) {
    //         error.addClass('invalid-feedback');
    //         element.parent('div').append(error);
    //     },
    //     highlight: function (element, errorClass, validClass) {
    //         $(element).addClass('is-invalid');
    //     },
    //     unhighlight: function (element, errorClass, validClass) {
    //         $(element).removeClass('is-invalid');
    //     }
    // });


    // Image Gallery Form
    $(".gallery_form").validate({
        errorElement: 'span',
        errorClass: 'error',
        onkeyup: false,
        ignore: ".ignore",
        rules: {
            "thumbnail[]": "required",
        },
        messages: {
            "thumbnail[]": "Please select the Images.", 
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

