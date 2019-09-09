jQuery(document).ready(function($){
    'use strict';

    $(document).on('click', '.wppb-posts-addon-loadmore-btn', function(e){
        e.preventDefault();
        var selector = $(this);
        var paged = selector.attr('data-paged');
        var page_id = $('body').attr('class').match(/\wppb-body-single-(\d+)\b/)[1];
        var addon_id = selector.closest('.wppb-builder-addon').attr('data-addon-id');

        $.ajax({
            url: wppb_posts_addon.ajax_url,
            type: 'POST',
            data: {
                action: 'wppb_posts_addon_load_more',
                'paged': paged,
                'page_id': page_id,
                'addon_id': addon_id,
            },
            beforeSend: function(){
                $('.wppb-posts-addon-content').append('<div class="wppb-post-grid-spinner"><div class="wppb-post-grid-spin"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
            },
            success: function(data){
                var target = selector.closest('.wppb-posts-addon').find('.wppb-posts-addon-content');
                $('.wppb-posts-addon-pagination').remove();
                target.append(data);
            },
            error: function(jqXHR, String ){
                //
            },
            complete: function(){
                $('.wppb-post-grid-spinner').remove();
            }
        });

    });


    $(document).on('click', '.wppb-posts-paginate-link', function(e){

        e.preventDefault();
        var selector = $(this);
        var paged = selector.attr('data-paged');
        var page_id = $('body').attr('class').match(/\wppb-body-single-(\d+)\b/)[1];
        var addon_id = selector.closest('.wppb-builder-addon').attr('data-addon-id');

        if (paged < 1){
            paged = 1;
        }

        $.ajax({
            url: wppb_posts_addon.ajax_url,
            type: 'POST',
            data: {
                action: 'wppb_posts_addon_load_more',
                'paged': paged,
                'page_id': page_id,
                'addon_id': addon_id,
            },
            beforeSend: function(){
                $('.wppb-posts-addon-content').append('<div class="wppb-post-grid-spinner"><div class="wppb-post-grid-spin"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
            },
            success: function(data){
                var target = selector.closest('.wppb-addon');
                $('.wppb-posts-addon-pagination').remove();
                target.html(data);
            },
            error: function(jqXHR, String ){
                //
            },
            complete: function(){
                $('.wppb-post-grid-spinner').remove();
            }
        });

    })



});