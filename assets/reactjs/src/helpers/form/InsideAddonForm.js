import React, { Component } from 'react'
import { formFieldsOptions } from './Common'
import PBFormRender from './PBFormRender'
import { reduxForm } from 'redux-form'
import { connect } from 'react-redux'


class InsideAddonForm extends Component{
    render(){
        const { handleSubmit, state } = this.props
        let addonOps = formFieldsOptions( state.wppbForm.insideForm )
        return(
            <form className="wppb-inside-form" onSubmit={ handleSubmit }>
                <div>
                    <button type="submit" className="wppb-builder-btn wppb-btn-success"><i className="far fa-check-square-o"/></button>
                    <span className="wppb-builder-btn wppb-btn-default" onClick ={(e)=>{ this.props.cancelInsideAddonForm(); }}>
                        <i className="fas fa-times-circle"/>
                    </span>
                </div>
                <PBFormRender addonOps={ addonOps } formName="insideForm" />
                <div>
                    <button type="submit" className="wppb-builder-btn wppb-btn-success"><i className="far fa-check-square-o"/> Apply</button>
                    <span className="wppb-builder-btn wppb-btn-default" onClick ={(e)=>{ this.props.cancelInsideAddonForm(); }}>
                        <i className="fas fa-times-circle"/> {page_data.i18n.cancel}
                    </span>
                </div>
            </form>
        )
    }
}

const mapStateToProps = (state) => {
    return {
        state,
        initialValues: state.wppbForm.insideForm.values
    };
}

const mapDispatchToProps = ( dispatch ) => {
    return {
        cancelInsideAddonForm: () => {
            dispatch( { type: 'CANCEL_ADDON_IN_FORM' } )
        }
    }
}

InsideAddonForm = reduxForm({
    form: 'insideAddonForm',
    enableReinitialize: true,
    destroyOnUnmount: false
})(InsideAddonForm);

InsideAddonForm = connect(
    mapStateToProps,
    mapDispatchToProps
)(InsideAddonForm);

export default InsideAddonForm;
