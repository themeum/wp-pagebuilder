import React, { Component } from 'react';
import { connect } from 'react-redux'
import PageBuilderForm from './form/PageBuilderForm'
import InsideAddonForm from './form/InsideAddonForm'
import { saveInsideAddon, loadInitialValue } from './form/actions/index'
import deepEqual from 'deep-equal'

class PageBuilderFormWrap extends Component {

    constructor(props) {
        super(props);
        this.insideHandleForm= this.insideHandleForm.bind(this);
        this.state = {
            settingUpdated: true
        }
    }

    insideHandleForm(values){
        var fieldData = this.props.state.wppbForm.activeField
        this.props.saveInsideAddon( values,fieldData )
    }

    componentWillReceiveProps(nextProps){
        if(!deepEqual(this.props.settings, nextProps.settings)){
            this.initValuesOnUpdate(nextProps);
        }
    }

    componentDidMount() {
        this.initValuesOnUpdate(this.props);
    }

    initValuesOnUpdate(props){
        const { addonName, toggleType, settings, htmlData } = props

        var addonOps, newSettings;
        if (__.isEmpty( settings )) {
            if ( toggleType == 'addon' || toggleType == 'inner_addon' ) {
                addonOps = page_data.addonsJSON[addonName];
                newSettings = addonOps.default
            } else if ( toggleType == 'column' || toggleType == 'inner_column' ) {
                newSettings = page_data.colSettings.default
            } else if ( toggleType == 'row' || toggleType == 'inner_row' ) {
                newSettings = page_data.rowSettings.default;
            }
        } else {
            newSettings = settings;
        }

        if (toggleType === 'widget'){
            newSettings = props;
        }

        this.props.loadInitialValue( toggleType, newSettings, addonName )
    }

    render(){
        const { toggleType, htmlData } = this.props

        let onchangeCB = null;
        let onchangeCbInside = null;
        let showButtons = true;
        if(toggleType == 'addon' || toggleType == 'inner_addon'){
            onchangeCB = this.props.onSubmit;
            showButtons = false;
            if(this.props.state.sppbForm && page_data.addonsJSON[this.props.state.sppbForm.activeField.addonName] !== undefined && page_data.addonsJSON[this.props.state.sppbForm.activeField.addonName].js_template && this.props.state.sppbForm.form == 'insideForm'){
                onchangeCbInside = this.insideHandleForm;
            }
        }else if(toggleType == 'row' || toggleType == 'inner_row' || toggleType == 'column' || toggleType == 'inner_column'){
            onchangeCB = this.props.onSubmit;
        }else if (toggleType == 'widget'){
            onchangeCbInside = this.insideHandleForm;
        }

        return(
                <div>
                    { this.props.state.wppbForm.form !='' &&
                        <PageBuilderForm onSubmit = { this.props.onSubmit } onChange={ onchangeCB } showButtons={showButtons} onCloseModal = { this.props.onCloseModal } widgetHtmlForm={htmlData} />
                    }
                    { this.props.state.wppbForm.form == 'insideForm' &&
                        <InsideAddonForm onSubmit = { this.insideHandleForm } onChange={ onchangeCbInside } onCloseModal = { this.props.onCloseModal } />
                    }
                </div>
        )
    }
}

const mapStateToProps = (state) => {
    return {
        state
    };
}

const mapDispatchToProps = ( dispatch ) => {
    return {
        saveInsideAddon: (values,fieldData) => {
            dispatch( saveInsideAddon(values,fieldData) )
        },
        loadInitialValue: ( addonType, settings, nameOfAddon ) => {
            dispatch( loadInitialValue( addonType, settings, nameOfAddon ) )
        }
    }
}

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(PageBuilderFormWrap);
