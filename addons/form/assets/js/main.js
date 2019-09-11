'use strict';
;(function ($) {
    'use strict';
    $(document).on('submit', '.wppb-global-form-addon form', function(e){
        e.preventDefault();

        var $form = $(this);
        var $formData = $form.serialize()+'&action=wppb_form_process';
        var $formErrors = { msg : '', requiredFields : [] };

        $('[data-required="true"]').each(function(index, element){
            var $field = $(this);
            var field_type = $field[0].type;
            var $closestDiv = $field.closest('.wppb-form-field-wrap');

            if (field_type === 'switch' || field_type === 'radio'){
                $closestDiv.addClass('has-multi-input');
            }else{
                if (!$field.val()){
                    $field.addClass('wppb-form-field-has-error');
                    $formErrors.requiredFields.push($field.data('label'));
                }else {
                    if (field_type === 'email' && ! wppbFormValidateEmail($field.val()) ){
                        $field.addClass('wppb-form-field-has-error');
                        $formErrors.requiredFields.push($field.data('label'));
                    }else {
                        $field.removeClass('wppb-form-field-has-error');
                    }
                }
            }
        });

        if ($('.has-multi-input').length){
            $('.has-multi-input').each(function(index, element){
                var $that = $(this);
                var $firstField = $that.find('input').first();

                if (! $that.find('input:checked').length){
                    $formErrors.requiredFields.push($firstField.data('label'));
                    $that.addClass('wppb-form-field-has-error');
                }else {
                    var newIndex = $formErrors.requiredFields.indexOf($firstField.data('label'));
                    if (newIndex > -1) {
                        $formErrors.requiredFields.splice(newIndex, 1);
                    }
                    $that.removeClass('wppb-form-field-has-error');
                }
            });
        }
        var ErrorMsg = '<div class="wppb_alert_warning">';
        
        if ($formErrors.requiredFields.length){
            ErrorMsg += 'Please, fill in the following fields:';
            ErrorMsg += '<ul>';

            $.each($formErrors.requiredFields, function(errorIndex, error ) {
                ErrorMsg += '<li>'+error+'</li>';
            });

            ErrorMsg += '</ul></div>';
            $form.find('.wppb-form-msg').html(ErrorMsg);
            return;
        }

        $.ajax({
            type: 'POST',
            url: wppb_form.ajax_url,
            data: $formData,
            beforeSend: function (jqXHR, settings) {
                $form.find('.wppb-form-msg').html('');
                $form.find('.wppb-btn-forms').append('<i class="fas fa-spinner wppb-font-sync"></i>');
            },
            error: function(jqXHR, textStatus, errorThrown){
                $form.find('.wppb_form_response').html("<p class='wppb_alert_error'>"+ textStatus+"("+jqXHR.status+")" +" : "+ errorThrown + "</p>");
            },
            success: function (data, textStatus, jqXHR ) {
                if (data.data) {
                    if (data.success) {
                        $form.find('.wppb_form_response').html('<p class="wppb_alert_success">' + data.data.msg + '</p>');
                        setTimeout(function(){
                            $form.find('.wppb_form_response').html('');
                        }, 2000);

                        $form[0].reset();
                        if (data.data.enable_redirect_url) {
                            location.href = data.data.redirect_url;
                        }
                    }else{
                        $form.find('.wppb-form-msg').html('<div class="wppb_alert_warning">'+data.data.msg+'</div>');
                    }
                }
            },
            complete: function(jqXHR, textStatus){
                $form.find('.fa.fa-spin.wppb-font-sync').remove();
                if (typeof grecaptcha !== 'undefined'){
                    grecaptcha.reset();
                }
            }
        });
    });
})(jQuery);

function wppbFormValidateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}