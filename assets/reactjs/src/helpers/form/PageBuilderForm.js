import React, { Component } from 'react';
import { formFieldsOptions } from './Common'
import PBFormRender from './PBFormRender'
import { reduxForm } from 'redux-form'
import { connect } from 'react-redux'

class PageBuilderForm extends Component {
    render(){
        const { handleSubmit, state, widgetHtmlForm } = this.props
        let addonOps    = formFieldsOptions( state.wppbForm.mainForm )
        let formClass   = 'form settings-form';

        if ( state.wppbForm.form == 'insideForm' ) {
            formClass += ' no-display';
        }

        return(
            <form className={formClass} onSubmit={ handleSubmit }>
                <PBFormRender addonOps={ addonOps } formName="mainForm" widgetHtmlForm={widgetHtmlForm} />
            </form>
        )
    }
}

const mapStateToProps = (state) => {
    return {
        state,
        initialValues: state.wppbForm.mainForm.values
    };
}

PageBuilderForm = reduxForm({
    form: 'wppbForm',
    enableReinitialize: true,
    destroyOnUnmount: false
})(PageBuilderForm);

PageBuilderForm = connect(
    mapStateToProps
)(PageBuilderForm);

export default PageBuilderForm;
