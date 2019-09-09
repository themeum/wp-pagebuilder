import React from 'react'
import ReactDOM from 'react-dom'
import { createStore,combineReducers } from 'redux'
import { Provider } from 'react-redux'
import Pagebuilder from './components/Pagebuilder'
import PageTools from './components/PageTools'
import undoable from 'redux-undo'
import pageBuilder from './reducers/pageBuilder'

let store = createStore( combineReducers({ pageBuilder: undoable(pageBuilder) }) );

window.frames['wppb-builder-view'].window.onload = () => {
    ReactDOM.render(
        <Provider store={store}><Pagebuilder /></Provider>,
        window.frames['wppb-builder-view'].window.document.getElementById('wppb-builder-container')
    );
    jQuery("#wppb-builder-view").contents().find("body").attr('id', 'wppb-page-builder');

    // Anchor Click Prevent
    jQuery( window.frames['wppb-builder-view'].window.document ).on('click','a',function(e){
        e.preventDefault();
    });
}
ReactDOM.render( <Provider store={store}><PageTools /></Provider>,document.getElementById('wppb-builder-page-tools') );