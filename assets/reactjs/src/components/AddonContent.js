import React, { Component } from 'react'

class AddonContent extends Component {

    constructor(props) {
        super(props);
        this.state = {
            settings: this.props.addon.settings,
            htmlContent: ''
        };
    }

    componentDidMount(){
        const { addon } = this.props;
        jQuery(document).trigger('rendered_addon', [addon]);
        this.renderAddon( this.props.addon );
    }

    componentWillReceiveProps( nextProps ) {
        if( !__.isEqual( this.props.addon.settings, nextProps.addon.settings ) ){
            this.renderAddon(  nextProps.addon );
        }
    }

    shouldComponentUpdate( nextProps, nextState ) {
        if( !__.isEqual( this.props.addon.settings, nextProps.addon.settings ) ) {
            return true;
        } else if(!__.isEqual( this.state.htmlContent, nextState.htmlContent) ) {
            return true;
        }
        return false;
    }

    componentDidUpdate(){
        jQuery(document).trigger('rendered_addon', [this.props.addon]);
    }

    renderAddon( addon ){
        let template    = document.getElementById( 'wppb-tmpl-addon-'+addon.name );
        if( template ){
            let addonMain   = __.clone(addon);
            __.templateSettings.evaluate = /<#([\s\S]+?)#>/g;
            __.templateSettings.interpolate = /\{\{\{([\s\S]+?)\}\}\}/g;
            __.templateSettings.escape = /\{\{([^\}]+?)\}\}(?!\})/g;
            __.templateSettings.variable = 'data';
            let compiled = __.template(template.innerHTML);
            addonMain.settings.id = addonMain.id;
            this.setState( { htmlContent: compiled(addonMain.settings) } );
        }else{
            if( addon.type === 'addon' && __.isObject(addon.settings) ){
                jQuery.ajax({
                    type: 'POST',
                    url: page_data.ajaxurl,
                    dataType: 'json',
                    data: { action: 'wppb_render_addon', addon: addon },
                    cache: false,
                    async: false,
                    success: function(response) {
                        if (response.success){
                            this.setState( { htmlContent: response.data.html } );
                        }
                    }.bind(this)
                });
            }else if( addon.type === 'widget' && __.isObject(addon.settings) ){ // Widget Output in AJAX
                jQuery.ajax({
                    type: 'POST',
                    url: page_data.ajaxurl,
                    dataType: 'json',
                    data: { action: 'wppb_render_widget', widget: addon },
                    cache: false,
                    success: function(response) {
                        if(response.success){
                            this.setState( { htmlContent: response.data.html } );
                        }
                    }.bind(this)
                });
            }else{
                this.setState( { htmlContent: addon.htmlContent } );
            }
        }
    }

    render() {
        return( <div className="wppb-addon" dangerouslySetInnerHTML={ { __html: this.state.htmlContent } } onClick={this.props.editAddon}/> )
    }
}

export default AddonContent;
