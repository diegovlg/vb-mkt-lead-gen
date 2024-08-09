(function($) {
    'use strict';

    $(function() {
        $('.vibra-whatsapp-button').on('click', function(e) {
            // GTM event
            if (typeof dataLayer !== 'undefined') {
                dataLayer.push({
                    'event': 'whatsapp_button_click',
                    'eventCategory': 'Vibra Marketing',
                    'eventAction': 'WhatsApp Button Click',
                    'eventLabel': window.location.href
                });
            }
            
            // GA4 event
            if (typeof gtag !== 'undefined') {
                gtag('event', 'whatsapp_button_click', {
                    'event_category': 'Vibra Marketing',
                    'event_label': window.location.href
                });
            }

            console.log('WhatsApp button clicked');
        });

         // Form submission event
        $('#vibra-contact-form').on('submit', function(e) {
            if (typeof dataLayer !== 'undefined') {
                dataLayer.push({
                    'event': 'vibra_form_submit',
                    'formId': 'contact_form'
                });
            }

            if (typeof gtag !== 'undefined') {
                gtag('event', 'form_submit', {
                    'event_category': 'Vibra Marketing',
                    'event_label': 'Contact Form'
                });
            }
        });
    });

})(jQuery);