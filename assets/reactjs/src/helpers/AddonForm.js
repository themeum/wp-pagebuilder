import React, { Component } from 'react';
import { createStore, combineReducers } from 'redux'
import wppbForm from './form/reducers/wppbForm'
import formReducers from './form/reducers/FormReducer'
import PageBuilderFormWrap from './PageBuilderFormWrap'
import { Provider } from 'react-redux'

const reducer = combineReducers({
    wppbForm,
    form: formReducers,
});

const store = createStore(reducer);

class AddonForm extends Component{
    render() {
        return(
            <div className="wppb-builder-modal-small">
                <Provider store={store}>
                    <PageBuilderFormWrap
                        addonName={this.props.addonName}
                        onSubmit={this.props.onSaveSettings}
                        settings={this.props.settings}
                        toggleType={this.props.toggleType}
                    />
                </Provider>
            </div>
        )
    }
}

export default AddonForm;
