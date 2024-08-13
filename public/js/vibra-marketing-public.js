(function($) {
    'use strict';

    $(function() {
        var $window = $(window);
        var $whatsappButton = $('.vibra-whatsapp-button');

        function checkWhatsAppButtonVisibility() {
            var windowHeight = $window.height();
            var scrollTop = $window.scrollTop();

            if (scrollTop > windowHeight * 0.5 && !$whatsappButton.is(':visible')) {
                $whatsappButton.fadeIn();
            } else if (scrollTop <= windowHeight * 0.5 && $whatsappButton.is(':visible')) {
                $whatsappButton.fadeOut();
            }
        }

        $window.on('scroll', checkWhatsAppButtonVisibility);
        checkWhatsAppButtonVisibility();

//        $('.vibra-whatsapp-button').on('click', function(e) {
        $whatsappButton.on('click', function(e) {
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

            $.post(ajaxurl, {
                action: 'vibra_whatsapp_click'
            });

            console.log('WhatsApp button clicked');
        });

         // Form submission event
        $('#vibra-contact-form, #vibra-subscription-form').on('submit', function(e) {
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