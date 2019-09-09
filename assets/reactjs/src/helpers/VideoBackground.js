import React from 'react';

export const VideoBackground = ( settings , type ) => {
    if( settings[type+'_background'].bgType == 'video' ){
        if( settings[type+'_background'].videoType == 'local' ){
            if( settings[type+'_background'].bgVideo.url ){
                return (
                    <div className="wppb-video-bg-wrap">
                        <video className="wppb-video-bg" autoPlay muted loop>
                            <source src={settings[type+'_background'].bgVideo.url} />
                        </video>
                    </div>
                )
            }
        }
        if( settings[type+'_background'].videoType == 'external' ){
            if( settings[type+'_background'].bgExternalVideo ){
                let video = settings[type+'_background'].bgExternalVideo,
                    src = '';
                if ( video.match('youtube|youtu\.be') ) {
                    let id = 0;
                    if( video.match('embed') ) { id = video.split(/embed\//)[1].split('"')[0]; }
                    else{ id = video.split(/v\/|v=|youtu\.be\//)[1].split(/[?&]/)[0]; }
                    src = '//www.youtube.com/embed/'+id+'?playlist='+id+'&iv_load_policy=3&enablejsapi=1&disablekb=1&autoplay=1&controls=0&showinfo=0&rel=0&loop=1&wmode=transparent&widgetid=1';
                } else if (video.match('vimeo\.com')) {
                    let id = video.split(/video\/|https:\/\/vimeo\.com\//)[1].split(/[?&]/)[0];
                    src = "//player.vimeo.com/video/"+id+"?autoplay=1&loop=1&title=0&byline=0&portrait=0"
                }
                return (
                    <div className="wppb-video-bg-wrap"><iframe src={src} allowFullScreen></iframe></div>
                )
            }
        }
    }
}