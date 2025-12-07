/**
 *
 * -----------------------------------------------------------------------------
 *
 * Template : Touriza HTML Template
 * Author : themewant
 * Author URI : https://themewant.com/ 
 *
 * -----------------------------------------------------------------------------
 *
 **/
(function ($) {
    'use strict';

    // Get the form and messages div
    var form = $('#contact-form');
    var formMessages = $('#form-messages');

    // Listen for form submit
    form.submit(function (e) {
        e.preventDefault(); // Stop default form submission

        // Serialize the form data
        var formData = form.serialize();

        // AJAX POST request
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: formData
        })
        .done(function (response) {
            // Remove error class, add success
            formMessages.removeClass('error').addClass('success');
            // Show response message
            formMessages.text(response);

            // Clear the form fields
            form.find('input[type="text"], input[type="email"], input[type="url"], textarea').val('');
        })
        .fail(function (data) {
            // Remove success class, add error
            formMessages.removeClass('success').addClass('error');

            // Show error message
            if (data.responseText !== '') {
                formMessages.text(data.responseText);
            } else {
                formMessages.text('Oops! An error occurred and your message could not be sent.');
            }
        });
    });

})(jQuery);
