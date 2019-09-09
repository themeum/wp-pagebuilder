import React, { Component } from 'react'
import { createStore, combineReducers } from 'redux'
import wppbForm from './form/reducers/wppbForm'
import formReducers from './form/reducers/FormReducer'
import PageBuilderFormWrap from './PageBuilderFormWrap'
import { Provider, connect } from 'react-redux'

const reducer = combineReducers({
  wppbForm,
  form: formReducers,
})

const store = createStore(reducer)

class WidgetForm extends Component {

    render() {
        const { addonName, settings, htmlData, toggleType } = this.props;

        let changedHtmlData = htmlData;

        if (__.isObject(htmlData) && htmlData.addon_type === 'widget' ) {
            jQuery.ajax({
                type: 'POST',
                url: page_data.ajaxurl,
                dataType: 'json',
                cache: false,
                async: false,
                data: {
                    action: 'render_widget_form_data',
                    widget: {settings: htmlData, id: htmlData.wppb_widget_id},
                },
                success: function (response) {
                    changedHtmlData = response.formData
                }.bind(this),
            });
        }

        return(
            <div className="wppb-builder-modal-small">
                <Provider store = { store }>
                    <PageBuilderFormWrap
                        addonName = { addonName }
                        onSubmit = { this.props.onSaveSettings }
                        settings = { settings }
                        htmlData = { changedHtmlData }
                        widgetId = { this.props.uniqueId }
                        toggleType={ toggleType }
                    />
                </Provider>
            </div>
        )
    }
}

export default WidgetForm;
