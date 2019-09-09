jQuery(document).ready(function($){

    if (wppb_admin_ajax.current_editor === 'wppb_builder_activated'){
        jQuery("body").addClass("active-wppb-editor");
    }else{
        jQuery("body").addClass("inactive-wppb-editor");
    }

    jQuery('.edit-with-wppb-builder').click(function (e) {
        e.preventDefault();
        var $that =  $(this);
        var post_id = jQuery('.wppagebuilder-edit-button').attr("data-postid");
        $.post(  wppb_admin_ajax.ajax_url, {action: 'wppb_switch_editor', post_id : post_id, wppb_nonce : wppb_admin_ajax.wppb_nonce }, function( data ) {
        });
        location.href = $that.attr('href');
    });

    $('.use-default-editor').click(function (e) {
        e.preventDefault();
        var post_id = jQuery('.wppagebuilder-edit-button').attr("data-postid");
        jQuery.ajax({
            url : wppb_admin_ajax.ajax_url,
            type : 'post',
            data : {
                action: 'wppb_switch_default',
                post_id : post_id,
                wppb_nonce : wppb_admin_ajax.wppb_nonce
            },
            success : function( response ) {
                //
            }
        });
        window.location.reload();
    });

    $(document).on('click', '#wppb_clear_cache_btn', function(e){
        e.preventDefault();

        var $that = $(this);

        jQuery.ajax({
            url : wppb_admin_ajax.ajax_url,
            type : 'post',
            data : {
                action: 'wppb_clear_cache',
                wppb_nonce : wppb_admin_ajax.wppb_nonce
            },
            beforeSend: function(){
                $that.addClass('updating-message');
            },
            success : function( response ) {
                $that.closest('label').find('.response-text').html('<span style="color: #228b22;">WP Page Builder cache has been cleared.</span>');
            },
            complete: function(){
                $that.removeClass('updating-message');
            }
        });
    });

    /**
     * Gutenberg compatibility
     */

    let wppbGutenbergCompatibility = {
        init : function(){
            let self = this;
            setTimeout(
                function(){
                    self.addWPPBBtn();
                    self.addSwitchTemplate();
                },
                1
            );

        },
        toolbarSelector: $('.edit-post-header-toolbar'),
        addWPPBBtn: function(){
            let isBtnExists = this.toolbarSelector.find('#wppb-edit-with-btn-in-gutenberg-toolbar').length;
            let btnHtmlWrap = $('#wppb-edit-with-btn-in-gutenberg-toolbar');
            if (!isBtnExists && btnHtmlWrap.length) {
                $('.edit-post-header-toolbar').append(btnHtmlWrap.html());
            }
        },
        addSwitchTemplate: function(){
            var hasSwitchTemplate = $('#wp-pagebuilder-to-gutenberg-switch-mode').length;
            if (hasSwitchTemplate){
                $('.editor-block-list__layout').after($('#wp-pagebuilder-to-gutenberg-switch-mode').html());
            }
        }
    };
    wppbGutenbergCompatibility.init();


    $(document).on('click', '.wppb-back-to-gutenberg', function(e){
        e.preventDefault();

        var $that = $(this);

        $that.hide();
        $('.edit-with-wppb-builder').show();
        $('body').removeClass('currently-activated-editor-wppb_builder_activated');

        var post_id = $('#post_ID').val();
        $.ajax({
            url : wppb_admin_ajax.ajax_url,
            type : 'post',
            data : {
                action: 'wppb_switch_default',
                post_id : post_id,
                wppb_nonce : wppb_admin_ajax.wppb_nonce,
                last_editor : 'gutenberg',
            },
        });

    });



});


//wppb_clear_cache_btn