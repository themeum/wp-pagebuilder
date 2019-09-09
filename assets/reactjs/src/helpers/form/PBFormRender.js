import React, { Component } from 'react'
import { CssGenerator } from '../../components/CssGenerator'
import FieldsRender from './FieldsRender'
import { connect } from 'react-redux'


class PBFormRender extends Component {
    constructor( props ){
        super( props );
        this.state = { tabName: 'general' }
    }

    componentDidUpdate(){
        if (wp.textWidgets !== undefined) {
            wp.textWidgets.widgetControls = {}; // WordPress 4.8 Text Widget
        }
        if (wp.mediaWidgets !== undefined) {
            wp.mediaWidgets.widgetControls = {}; // WordPress 4.8 Media Widgets
        }

        jQuery('.widget').each(function() {
            let widget = jQuery(this);

            if( ! widget.hasClass('react-rendered')){
                widget.addClass('react-rendered');
                if( widget.is( '[id*=black-studio-tinymce]' ) ) {
                    bstw( widget ).deactivate().activate();
                }
                jQuery( document ).trigger('widget-added', [widget]);
            }
        });
    }

    tabChanged( tabName ){
        this.setState({tabName})
    }

    render(){
        const { addonOps, widgetHtmlForm } = this.props;
        let opsKeys = Object.keys(addonOps.attr);

        if(addonOps.is_widget){
            var values = {};
            CssGenerator( { settings:__.pickBy( this.props.state.form.wppbForm.values, function(value, key) { return __.startsWith(key, "addon_"); }), id: addonOps.id }, 'widget' , 'setinline' );
        }else{
            if( this.props.formName == 'mainForm' ){
                if(typeof this.props.state.form.wppbForm !== 'undefined'){
                    var values = this.props.state.form.wppbForm.values;
                }
            }else{
                var values = this.props.state.form.insideAddonForm.values;
            }
        }

        return(
            <div className="wppb-builder-fieldset">
                <div id="addon-option-form">
                    <ul className="nav nav-tabs">
                        { opsKeys.map((tabName,index ) => {
                                if( tabName == 'style' && Object.keys(addonOps.attr[tabName]).length == 1 ){ return; }
                                return (
                                    <li key={index} className={ ( this.state.tabName == tabName ? 'active' : '' ) } onClick={ () => this.tabChanged( tabName ) }>
                                        <a id={ 'addon-option-form-tab-' + index } href="#" title={tabName}>{tabName}</a>
                                    </li>
                                )
                            }
                        )}
                    </ul>
                    <div className="tab-content">
                        { opsKeys.map((tabName,index ) => {
                                return(
                                    <div key={ index } className={ ( this.state.tabName == tabName ? 'tab-pane active' : 'tab-pane' ) }>
                                        {
                                            ( addonOps.is_widget && (index === 0) ) ?
                                                <div dangerouslySetInnerHTML={{__html : widgetHtmlForm }}></div>
                                                :
                                                <FieldsRender
                                                    fieldsAttr = { addonOps.attr[tabName] }
                                                    allAttribute = { addonOps.attr }
                                                    values = { values }
                                                />
                                        }
                                    </div>
                                )
                            })
                        }
                    </div>
                </div>
            </div>
        )
    }
}

const mapStateToProps = (state) => {
    return { state };
}

export default connect(
    mapStateToProps
)(PBFormRender);
