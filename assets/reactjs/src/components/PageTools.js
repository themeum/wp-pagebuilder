import React, { Component } from 'react'
import { connect } from 'react-redux'
import { addRow, saveSetting, importTemplate, changeColumnWidth, pageEmptyClick } from '../actions/index'
import { ActionCreators } from 'redux-undo'
import { importPage } from '../actions/index'
import AllAddonList from './AllAddonList'
import EditPanel from './EditPanel'
import SectionLibrary from './SectionLibrary'
import MySection from './MySection'
import ResponsiveManager from '../helpers/ResponsiveManager'
import withDragDropContext from '../helpers/withDragDropContext'
import EditPanelManager from '../helpers/EditPanelManager'
import {CssGenerator} from './CssGenerator'
import PageListModal from '../helpers/PageListModal'
import { ModalManager } from '../helpers/index'

const deviceList = [
                    { device: 'md', name: 'desktop', icon: 'fas fa-laptop' },
                    { device:'sm', name: 'tablet', icon: 'fas fa-tablet-alt' },
                    { device: 'xs', name: 'mobile', icon: 'fas fa-mobile-alt'}
                ];

class PageTools extends Component{
    constructor(props) {
        super(props);
        this.updateState = this.updateState.bind(this);
        this.updateResponsiveData = this.updateResponsiveData.bind(this)
        this.state = {
                    isCtrl: false,
                    requireSave: false,
                    errorMsg: '',
                    successMsg: '',
                    currentPanel: 'addons',
                    savebtnClass: 'wppb-font-save',
                    toggleType: EditPanelManager.type,
                    addonToEdit: EditPanelManager.addon,
                    colIndex: EditPanelManager.colIndex,
                    rowIndex: EditPanelManager.rowIndex,
                    isEditPanelOn: EditPanelManager.show,
                    mediaDevice: ResponsiveManager.device,
                    colSettings: EditPanelManager.colSettings,
                    rowSettings: EditPanelManager.rowSettings,
                    innerColIndex: EditPanelManager.innerColIndex,
                    innerRowIndex: EditPanelManager.innerRowIndex,

                    dropDownVisibility: false,
                    lastPanel:''
                };
        this.onUnload = this.onUnload.bind(this);
    }

    componentDidMount(){
        ResponsiveManager.on('change', this.updateResponsiveData);
        EditPanelManager.on('change', this.updateState);

        //Disable alert in debug mode
        let isScriptDebug = parseInt(page_data.script_debug);
        if (isScriptDebug !== 1){
            window.addEventListener("beforeunload", this.onUnload)
        }
    }

    componentWillUnmount(){
       ResponsiveManager.removeListener('change', this.updateResponsiveData);
       window.removeEventListener("beforeunload", this.onUnload)
    }

    onUnload(event) {
        if( this.state.requireSave ){
            event.returnValue = "You have some unsaved changes."
        }
    }
   
    updateResponsiveData() {
        let iframe = document.getElementById('wppb-builder-view');
        if(ResponsiveManager.device === 'sm'){
            iframe.classList.add('wppb-tabel-view');
            iframe.classList.remove('wppb-mobile-view');
        } else if(ResponsiveManager.device === 'xs'){
            iframe.classList.add('wppb-mobile-view');
            iframe.classList.remove('wppb-tabel-view');
        } else {
            iframe.classList.remove('wppb-tabel-view');
            iframe.classList.remove('wppb-mobile-view');
        }
    
        this.setState({ mediaDevice: ResponsiveManager.device });
      }

    onChangeDevice(e){
        let newDevice       = e.currentTarget;
        let deviceId        = newDevice.dataset.device;
        let iframe          = document.getElementById('wppb-builder-view');
        let deviceName;

        if(deviceId === 'tablet'){
            iframe.classList.add('wppb-tabel-view');
            iframe.classList.remove('wppb-mobile-view');
            deviceName = 'sm';
        } else if(deviceId === 'mobile'){
            iframe.classList.add('wppb-mobile-view');
            iframe.classList.remove('wppb-tabel-view');
            deviceName = 'xs';
        } else {
            iframe.classList.remove('wppb-tabel-view');
            iframe.classList.remove('wppb-mobile-view');
            deviceName = 'md';
        }
        ResponsiveManager.setDevice(deviceName)

        this.setState({ mediaDevice: deviceName })
    }

    updateState(){
        this.setState({
            isEditPanelOn: EditPanelManager.show,
            addonToEdit: EditPanelManager.addon,
            toggleType: EditPanelManager.type,
            rowIndex: EditPanelManager.rowIndex,
            colIndex: EditPanelManager.colIndex,
            innerRowIndex: EditPanelManager.innerRowIndex,
            innerColIndex: EditPanelManager.innerColIndex,
            rowSettings: EditPanelManager.rowSettings,
            colSettings: EditPanelManager.colSettings,
        });

        if( !EditPanelManager.show ){
            this.setState({ currentPanel: 'addons' })
        }

        if (typeof EditPanelManager.addon.settings !== 'undefined' && 
            typeof EditPanelManager.addon.settings.formData !== 'undefined'  && 
            ! __.isEmpty(EditPanelManager.addon.settings.formData.addon_type) 
            && EditPanelManager.addon.settings.formData.addon_type === 'widget' ){
                this.setState({ toggleType : 'widget' });
        }

        if (typeof EditPanelManager.addon.settings !== 'undefined' && EditPanelManager.addon.settings.type === 'widget'){
            this.setState({ toggleType : EditPanelManager.addon.settings.type });
        }
    }

    uploadPage(){
        let file = jQuery('#upload-file').prop('files')[0];
        if (typeof file === 'undefined') {
            return;
        }
        let that        = this.props;
        let fileName    = file.name;
        fileName        = fileName.slice(-5);
        fileName        = fileName.toLowerCase();

        if ( fileName === '.json' ) {
            var reader = new FileReader();
            reader.readAsText(file, 'UTF-8');
            reader.onload = function(evt) {
                that.importTemplate( JSON.parse( evt.target.result ) );
            }
        }
    }

    saveSettings(values){
        if(this.state.toggleType === 'addon' || this.state.toggleType === 'inner_addon'){
            let editedAddon = {
                type: this.state.toggleType,
                index: this.state.addonToEdit.index,
                settings: {
                    colIndex:   this.state.addonToEdit.settings.colIndex,
                    addonIndex: this.state.addonToEdit.settings.addonIndex,
                    addonId:    this.state.addonToEdit.settings.addonId,
                    htmlContent:this.state.addonToEdit.settings.htmlContent,
                    addonName:  this.state.addonToEdit.settings.addonName,
                    formData:   values,
                    type: this.state.toggleType,
                }
            };
            if(this.state.toggleType === 'inner_addon') {
                editedAddon.settings.innerRowIndex   =  this.state.addonToEdit.settings.innerRowIndex;
                editedAddon.settings.innerColIndex   =  this.state.addonToEdit.settings.innerColIndex;
                editedAddon.settings.addonInnerIndex =  this.state.addonToEdit.settings.addonInnerIndex;
            }
            
            this.props.onSettingsClick( editedAddon );
        } else if(this.state.toggleType === 'row' || this.state.toggleType === 'inner_row'){
            let editedRow = {
                type:   this.state.toggleType,
                index:  this.state.rowIndex,
                settings: {
                    colIndex:   this.state.colIndex,
                    addonIndex: this.state.innerRowIndex,
                    formData:   values,
                }
            };
            this.props.onSettingsClick(editedRow);
        }  else if(this.state.toggleType === 'column' || this.state.toggleType === 'inner_column' ){

            if(typeof values.col_custom_width !== 'undefined' && typeof values.col_custom_width.layout !== 'undefined'){
                let actionParam = {}

                actionParam.type = 'column'                
                actionParam.newColLayout = values.col_custom_width.layout
                actionParam.index = this.state.rowIndex
                delete values.col_custom_width.layout

                if( this.state.toggleType === 'inner_column' ) {
                    actionParam.type = 'inner_column'
                    actionParam.settings = {
                            colIndex : this.state.colIndex,
                            addonIndex : this.state.innerRowIndex
                        }
                }
                
                this.props.onChangeColumnWidth(actionParam)
            }

            let editedCol = {
                type:  this.state.toggleType,
                index: this.state.rowIndex,
                settings: {
                    formData:       values,
                    colIndex:       this.state.colIndex,
                    addonIndex:     this.state.innerRowIndex,
                    innerColIndex:  this.state.innerColIndex,
                }
            };
            this.props.onSettingsClick(editedCol);
        }

        this.setState( { requireSave: true} );
    }

    savePage(){
        let pageBuilder = Object.assign( {}, this.props.state.pageBuilder )
        var wppb_form_widget = jQuery('.wppb-form-widget');

        let widgetFormData = {};
        if (wppb_form_widget.length){
            let id_base = wppb_form_widget.find('[name="id_base"]').val();
            let widget_input_base_name = jQuery('[name="widget_input_base_name"]').val();
            let wppb_widget_id = wppb_form_widget.find('[name="widget-id"]').val();
            wppb_widget_id = parseInt(wppb_widget_id.replace('widget-', ''));

            let widgetFormInput = wppb_form_widget.closest('form').serializeArray();

            if (widgetFormInput.length){
                __.forEach(widgetFormInput, function(input, index){
                    if (__.startsWith(input.name, widget_input_base_name)){
                        let input_name = input.name.replace(widget_input_base_name, '');
                        input_name = input_name.replace('[', '').replace(']', '');

                        widgetFormData[input_name] = input.value;
                    }
                });
                widgetFormData['wppb_widget_id'] = wppb_widget_id;
                widgetFormData['wppb_widget_id_base'] = id_base;
                widgetFormData['addon_type'] = 'widget';
            }

            /**
             * Setting widget form data to addons
             */
            __.forEach(pageBuilder.history.present, function(rowValue, rowKey){ // Looping Row
                __.forEach(rowValue, function(colValue, colKey){ // Looping Columns
                    __.forEach(colValue, function(addonValue, addonKey){ //Looping Addon
                        if ( ! __.isEmpty(addonValue.addons) && addonValue.addons.length > 0 ){
                            __.forEach(addonValue.addons, function (addon, key) {
                                if (addon.type === 'widget'){
                                    if (addon.id === wppb_widget_id){ // Setting widget input
                                        addon.htmlContent = '';
                                        addon.settings = widgetFormData;
                                    }
                                }else if(addon.type === 'inner_row'){ // This is inner row
                                    if (typeof addon.columns !== 'undefined' && addon.columns.length){
                                        __.forEach(addon.columns, function(colValue, colKey){
                                            __.forEach(colValue.addons, function(innerAddon, colKey){
                                                if (innerAddon.id === wppb_widget_id){ // Setting widget input
                                                    innerAddon.htmlContent = '';
                                                    innerAddon.settings = widgetFormData;
                                                }
                                            });
                                        });
                                    }
                                }
                            });
                        }
                    });
                })
            });

            //Same data settings at pagebuilder present
            __.forEach(pageBuilder.present, function(rowValue, rowKey){ // Looping Row
                __.forEach(rowValue, function(colValue, colKey){ // Looping Columns
                    __.forEach(colValue, function(addonValue, addonKey){ // Looping Addon
                        if ( ! __.isEmpty(addonValue.addons) && addonValue.addons.length > 0 ){
                            __.forEach(addonValue.addons, function (addon, key) { // checking if addon, or inner row
                                if (addon.type === 'widget'){
                                    if (addon.id === wppb_widget_id){ // Setting widget input
                                        addon.htmlContent = '';
                                        addon.settings = widgetFormData;
                                    }
                                }else if(addon.type === 'inner_row'){ // This is inner row
                                    if (typeof addon.columns !== 'undefined' && addon.columns.length){
                                        __.forEach(addon.columns, function(colValue, colKey){
                                            __.forEach(colValue.addons, function(innerAddon, colKey){
                                                if (innerAddon.id === wppb_widget_id){
                                                    innerAddon.htmlContent = '';
                                                    innerAddon.settings = widgetFormData;
                                                }
                                            });
                                        });
                                    }
                                }
                            });
                        }
                    });
                })
            });
        }

        // Getting CSS
        let addonPresentSettings = JSON.stringify(pageBuilder.history.present);
        let pageID = jQuery('#wppb-builder-view').attr('data-page-id');
        let wppb_page_css = '';
        __.forEach(pageBuilder.present, function(rowValue, rowKey){ // Getting CSS
            wppb_page_css += CssGenerator(rowValue, 'row', 'return');
            __.forEach(rowValue, function(colValue, colKey){ // Looping Row
                wppb_page_css += CssGenerator(colValue, 'col', 'return');
                if (colKey === 'columns' && __.isObject(colValue) && colValue.length){ // Generate css for columns within inner row
                    __.forEach(colValue, function(innerCol, innerColKey){
                        wppb_page_css += CssGenerator(innerCol, 'col', 'return');
                    });
                }
                __.forEach(colValue, function(addonValue, addonKey){ // Looping Columns
                    if ( ! __.isEmpty(addonValue.addons) && addonValue.addons.length > 0 ){ // Looping Addon
                        __.forEach(addonValue.addons, function (addon, key) {
                            if (addon.type === 'addon'){
                                let addon_generated_css = CssGenerator(addon, addon.type, 'return');
                                if ( ! __.isObject(addon_generated_css)){
                                    wppb_page_css += addon_generated_css;
                                }
                            }else if (addon.type === 'inner_row'){
                                wppb_page_css += CssGenerator(addon, 'row', 'return');
                                __.forEach(addon.columns, function(innerCol, innerColKey){
                                    wppb_page_css += CssGenerator(innerCol, 'col', 'return');
                                    __.forEach(innerCol.addons, function(innerAddon, innerAddonKey){
                                        if (typeof innerAddon.type !== 'undefined'){
                                            wppb_page_css += CssGenerator(innerAddon, innerAddon.type.replace('inner_', ''), 'return');
                                        }
                                    });

                                });
                            }
                        });
                    }
                });
            })
        });

        let that = this;
        jQuery.ajax({
            type: 'POST',
            url: page_data.ajaxurl,
            dataType: 'json',
            data: { 
                action: 'wppb_page_save', 
                page_id: pageID,
                page_builder_data: addonPresentSettings, 
                wppb_page_css: wppb_page_css
            },
            cache: false,
            beforeSend: function(){
                that.setState({ savebtnClass: 'wppb-font-sync fa-spin color-green' });
            },
            success: function(response){
                if( typeof response.data.msg_error !== 'undefined' ){
                    that.setState({ errorMsg: response.data.msg_error, successMsg: '' });
                } else {
                    that.setState({ successMsg: response.data.msg, errorMsg: '' });
                }
            },
            complete:function(){
                that.setState({ savebtnClass: 'wppb-font-save',requireSave:false , requireSave: false });
                setTimeout(function() { that.setState({ successMsg: '', errorMsg: '' }); }, 1000);
            }.bind(this)
        });
    }

    goBackToAddonList(){
        let pageBuilder = __.clone(this.props.state.pageBuilder);

        var wppb_form_widget = jQuery('.wppb-form-widget');

        let widgetFormData = {};
        if (wppb_form_widget.length){
            let id_base = wppb_form_widget.find('[name="id_base"]').val();
            let widget_input_base_name = jQuery('[name="widget_input_base_name"]').val();
            let wppb_widget_id = wppb_form_widget.find('[name="widget-id"]').val();
            wppb_widget_id = parseInt(wppb_widget_id.replace('widget-', ''));

            let widgetFormInput = wppb_form_widget.closest('form').serializeArray();

            if (widgetFormInput.length){
                __.forEach(widgetFormInput, function(input, index){
                    if (__.startsWith(input.name, widget_input_base_name)){
                        let input_name = input.name.replace(widget_input_base_name, '');
                        input_name = input_name.replace('[', '').replace(']', '');
                        widgetFormData[input_name] = input.value;
                    }
                });

                widgetFormData['wppb_widget_id'] = wppb_widget_id;
                widgetFormData['wppb_widget_id_base'] = id_base;
                widgetFormData['addon_type'] = 'widget';
            }

            /**
             * Setting widget form data to addons
             */
            //Setting data in history.present
            __.forEach(pageBuilder.history.present, function(rowValue, rowKey){ // Looping Row
                __.forEach(rowValue, function(colValue, colKey){ // Looping Columns
                    __.forEach(colValue, function(addonValue, addonKey){ // Looping Addon
                        if ( ! __.isEmpty(addonValue.addons) && addonValue.addons.length > 0 ){
                            __.forEach(addonValue.addons, function (addon, key) {
                                if (addon.type === 'widget'){
                                    if (addon.id === wppb_widget_id){ // Setting widget input
                                        addon.htmlContent = '';
                                        addon.settings = widgetFormData;
                                    }
                                } else if (addon.type === 'inner_row'){ // This is inner row
                                    if (typeof addon.columns !== 'undefined' && addon.columns.length){
                                        __.forEach(addon.columns, function(colValue, colKey){
                                            __.forEach(colValue.addons, function(innerAddon, colKey){
                                                if (innerAddon.id === wppb_widget_id){ // Setting widget input
                                                    innerAddon.htmlContent = '';
                                                    innerAddon.settings = widgetFormData;
                                                }
                                            });
                                        });
                                    }
                                }
                            });
                        }
                    });
                })
            });

            //Same data settings at pagebuilder present
            __.forEach(pageBuilder.present, function(rowValue, rowKey){ // Looping Row
                __.forEach(rowValue, function(colValue, colKey){ // Looping Columns
                    __.forEach(colValue, function(addonValue, addonKey){ // Looping Addon
                        if ( ! __.isEmpty(addonValue.addons) && addonValue.addons.length > 0 ){
                            __.forEach(addonValue.addons, function (addon, key) { // checking if addon, or inner row
                                if (addon.type === 'widget'){
                                    if (addon.id === wppb_widget_id){ // Setting widget input
                                        addon.htmlContent = '';
                                        addon.settings = widgetFormData;
                                    }
                                }else if(addon.type === 'inner_row'){ // This is inner row
                                    if (typeof addon.columns !== 'undefined' && addon.columns.length){
                                        __.forEach(addon.columns, function(colValue, colKey){
                                            __.forEach(colValue.addons, function(innerAddon, colKey){
                                                if (innerAddon.id === wppb_widget_id){
                                                    innerAddon.htmlContent = '';
                                                    innerAddon.settings = widgetFormData;
                                                }
                                            });
                                        });
                                    }
                                }
                            });
                        }
                    });
                })
            });
        }

    }

    exportLayout(){
		const { present } = this.props.state.pageBuilder;
		if ( present.length == 0 ) { return; }

		let elementsData = document.createElement('a');
		elementsData.setAttribute( 'href', 'data:application/octet-stream,' + encodeURIComponent(JSON.stringify(present)) );
		elementsData.setAttribute('download', 'Export-'+ Math.floor(Math.random() * 10000) +'.json');
		elementsData.style.display = 'none';
		document.body.appendChild(elementsData);
		elementsData.click();
        document.body.removeChild(elementsData);
	}

    leftMenuController( type ){
        EditPanelManager.setType(type);
        EditPanelManager.hideEditPanel();
        let { lastPanel, currentPanel, dropDownVisibility } = this.state;
        if( type === 'settings' ){
            dropDownVisibility = !dropDownVisibility
        }
        if( type !== currentPanel ){
            if( type === 'settings' ){
                lastPanel = currentPanel
            }else{
                lastPanel = ''
                dropDownVisibility = false
            }
        }
        let rootDomElement = document.querySelector('.inactive-wppb-editor')

        if(rootDomElement && typeof rootDomElement !== 'null' && rootDomElement.classList.contains('wppb-pagetoops-editor-hide') ){
            rootDomElement.classList.remove('wppb-pagetoops-editor-hide')
        }

        this.setState({ currentPanel : type, lastPanel, dropDownVisibility })
    }

    // ( CTRL + S ) ( COMMAND + S )
    onKeyUp(e) {
        if(e.keyCode === 17 ){ this.setState( {isCtrl:false} ) }
    }
    onKeyDown(e) {
        if( navigator.platform.match(/(Mac|iPhone|iPod|iPad)/i) ? true : false ){
            if( e.keyCode === 91 ){
                this.setState( { isCtrl:true } )
            }else{
                this.setState( { isCtrl:false } ) 
            }
        }else{
            if( e.keyCode === 17 ){
                this.setState( { isCtrl:true } )
            }else{
                this.setState( { isCtrl:false } )
            }
        }
        if( e.keyCode === 83 && this.state.isCtrl == true ) {
            e.preventDefault();
            this.savePage();
            return false;
        }
        
        if( e.keyCode === 90 && this.state.isCtrl == true ) {
            this.props.pageUndoClick();
            return false;
        }
    }

    render(){
        const { pageBuilder } = this.props.state;

        let sectionListClass = '';
        let mySectionListClass = '';

        if( this.state.isEditPanelOn || this.state.currentPanel !== 'section'){
            sectionListClass = 'wppb-hidden';
        }

        if( this.state.isEditPanelOn || this.state.currentPanel !== 'mysection'){
            mySectionListClass = 'wppb-hidden';
        }

        if( this.state.lastPanel === 'section' ){
            sectionListClass = ''
        }
            
        if( this.state.lastPanel === 'mysection' ){
            mySectionListClass = '';
        }

        let panelTitle = '';
        let uniqueId = 1223123124142134;

        if((this.state.toggleType == 'addon' || this.state.toggleType == 'inner_addon' || this.state.toggleType == 'widget' || this.state.toggleType == 'library') && !__.isEmpty(this.state.addonToEdit.settings)){
            panelTitle = this.state.addonToEdit.settings.addonName.split( '_' ).join(' ').replace( 'wppb ', '' );
            uniqueId = this.state.addonToEdit.settings.addonId
        } else if(this.state.toggleType == 'row') {
            panelTitle = 'Row Settings'
            uniqueId = this.state.rowSettings.id
        } else if(this.state.toggleType == 'inner_row') {
            panelTitle = 'Inner Section Settings'
            uniqueId = this.state.rowSettings.id
        } else if(this.state.toggleType == 'column' ) {
            panelTitle = 'Column Settings'
            uniqueId = this.state.colSettings.id
        } else if( this.state.toggleType == 'inner_column' ){
            panelTitle = 'Inner Column Settings'
            uniqueId = this.state.colSettings.id
        }else if (this.state.currentPanel === 'mysection'){ 
            panelTitle = 'Library'
        }else if (this.state.currentPanel === 'section'){ 
            panelTitle = 'Blocks'
        }else if (this.state.currentPanel === 'settings'){
            panelTitle = 'Tools'
        }

        return(
            <div 
                key={uniqueId}
                className="clearfix"
                onKeyUp={(e) => this.onKeyUp(e)}
                onKeyDown={(e) => this.onKeyDown(e)}
                tabIndex="0" >
                { this.state.successMsg &&
                    <div className={ 'wppb_toastr wppb-toastr-success' }>{ this.state.successMsg }</div>
                }
                { this.state.errorMsg &&
                    <div className={ 'wppb_toastr wppb-toastr-error' }>{ this.state.errorMsg }</div>
                }
                <input type="file" name="upload-file" id="upload-file" accept=".json" style={{ display:'none'}} onChange={ (e) => { this.uploadPage(); }} />

                <div className="wppb-builder-topbar">
                    { this.state.isEditPanelOn || this.state.currentPanel !== 'addons' ?
                        <div className="pagetools">
                            <span className="wppb-builder-addon-edit">
                                <button className="wppb-builder-close-edit" onClick={ e => { EditPanelManager.hideEditPanel(); this.goBackToAddonList();}}><i className="wppb-font-left-arrow"/> {__.capitalize(panelTitle)} </button>
                                
                            </span>
                            <div className="wppb-edit-show-hide"><a className="wppb-edit-show-toggle" href="#"><i className="fas fa-angle-left"/></a></div>
                        </div>
                        :
                        <div className="pagetools default-mode">
                            <div className="wppb-edit-show-hide"><a className="wppb-edit-show-toggle" href="#"><i className="fas fa-angle-left"/></a></div>
                        </div>
                    }
                </div>
                <div className="wppb-builder-logo-wrap">
                    <span className="wppb-builder-logo-text">WP Page Builder</span> 
                    <span className="wppb-builder-edit-view">
                        <a title={page_data.i18n.dashboard} onClick={ (e) => { window.open( page_data.admin_url, '_blank' ); } } target={'_self'}><i className="wppb-close wppb-font-dashboard"></i></a>
                        <a title={page_data.i18n.edit_page} onClick={ (e) => { window.open( page_data.dashboard_page, '_blank' ); } } target={'_self'}><i className="wppb-close wppb-font-edit"></i></a>
                        <a title={page_data.i18n.view_page} href={page_data.view_page} onClick={ (e) => {
                            if( this.state.requireSave ){
                                if( !confirm( 'Are you sure to leave this page?' ) ){ e.preventDefault() }
                            }
                        } } target={'_self'}><i className="wppb-close wppb-font-close"></i></a>
                    </span>
                </div>
                <div className="wppb-builder-main-tab">
                    <span className="wppb-builder-main-logo"> <img src={page_data.pagebuilder_base + 'assets/img/logo.svg'} alt="logo"/>  </span>
                    <ul className="clearfix pos-top">
                        
                        <li onClick={e => { EditPanelManager.hideEditPanel(); this.goBackToAddonList(); }}>
                            <span className={ this.state.currentPanel == 'addons' ? 'active' : '' } onClick={ () => this.leftMenuController('addons')}>
                                <i className="wppb-font-add"></i>{page_data.i18n.addons}
                            </span>
                        </li>
                        <li>
                            <span className={ this.state.currentPanel == 'section' ? 'active' : '' } onClick={ () => this.leftMenuController('section')}>
                                <i className="wppb-font-Page-grid"></i>{page_data.i18n.blocks}
                            </span>
                        </li>
                        <li>
                            <span onClick={ e => {  ModalManager.open( <PageListModal importTemplate={this.props.importTemplate} onRequestClose={() => true } />) }}>
                                <i className="wppb-font-layout"></i>{page_data.i18n.layouts}
                            </span>
                        </li>
                        <li>
                            <span className={ this.state.currentPanel == 'mysection' ? 'active' : '' } onClick={ () => this.leftMenuController('mysection')}>
                                <i className="wppb-font-library"></i>{page_data.i18n.library}
                            </span>
                        </li>
                        <li>
                            <span className={ this.state.currentPanel == 'settings' && this.state.dropDownVisibility ? 'active' : '' } onClick={ () => this.leftMenuController('settings')}>
                                <i className="wppb-font-settings"></i>{page_data.i18n.tools}
                            </span>
                            { this.state.dropDownVisibility && this.state.currentPanel === 'settings'
                                ?  
                                <div className="dropdown-settings-menu">
                                    <ul>
                                        <li onClick={ () => document.getElementById('upload-file').click() }> <i className="wppb-font-download-alt"></i> {page_data.i18n.import}</li>
                                        <li onClick={ () => this.exportLayout() }> <i className="wppb-font-modal"></i> {page_data.i18n.export}</li>
                                        <li onClick={ () => this.props.pageEmptyClick() }> <i className="wppb-font-trash"></i> {page_data.i18n.clear_page_content}</li>
                                    </ul>
                                </div>
                                : null 
                            }
                        </li>
                    </ul>
                    <div className="wppb-builder-device-option-ui pos-bottom">
                        <ul>
                            <li>
                                <span title={page_data.i18n.view}><a href={page_data.view_page} target={'_blank'}><i className="wppb-font-eye-on"></i>{page_data.i18n.view}</a></span>
                            </li>
                            <li>
                                <span title={page_data.i18n.save} onClick={ () => this.savePage()}>
                                    <i className={this.state.savebtnClass+' '+( this.state.requireSave ? 'color-green' : '' )}/> {page_data.i18n.save} 
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                { this.state.isEditPanelOn &&
                    <EditPanel
                        uniqueId = { uniqueId }
                        addon = { this.state.addonToEdit }
                        onSaveSettings = { this.saveSettings.bind(this) }
                        toggleType = { this.state.toggleType }
                        rowSettings = { this.state.rowSettings.settings }
                        colSettings = { this.state.colSettings.settings }
                    />
                }
                <div className="sectionWarpper"> 
                    <div className={ (this.state.isEditPanelOn || this.state.currentPanel != 'addons' && this.state.lastPanel !='addons' ) ? 'wppb-hidden' : '' }><AllAddonList /></div>
                    
                    { sectionListClass != 'wppb-hidden' &&
                        <div className={sectionListClass}><SectionLibrary /></div>
                    }

                    { mySectionListClass != 'wppb-hidden' &&
                        <div className={mySectionListClass}><MySection /></div>
                    }

                    <div className="wppb-builder-action-settings-bar">
                        <div className="wppb-builder-action-list">
                            <div className="wppb-builder-undo-redo-box wppb-builder-redo-box">
                                <button title={page_data.i18n.undo} type="button" className="" 
                                    disabled={
                                        !pageBuilder.past.length&&
                                        'disabled'
                                    }
                                    onClick={ (e) => {
                                        this.props.pageUndoClick();
                                        EditPanelManager.hideEditPanel();
                                    }}>
                                        <span><i className="wppb-font-undo-arrow"></i></span>
                                </button>
                            </div>
                            
                            <div className="wppb-builder-responsive-device-list">
                                <ul>
                                    { deviceList.map((obj,key)=> {
                                        let deviceClass = '';
                                        if(obj.device == this.state.mediaDevice){
                                            deviceClass = 'active'
                                        }
                                        return(
                                            <li title={ __.capitalize(obj.name)} key={key}><span data-device={obj.name} className={deviceClass} onClick={this.onChangeDevice.bind(this)}><i className={obj.icon}/></span></li>
                                        )
                                    }) }
                                </ul>
                            </div>
                            <div className="wppb-builder-undo-redo-box wppb-builder-undo-box">
                                <button title={page_data.i18n.redo} type="button" className=""
                                    disabled={
                                        !pageBuilder.future.length &&
                                        'disabled'
                                    }
                                    onClick={ (e) => {
                                        this.props.pageRedoClick();
                                        EditPanelManager.hideEditPanel();
                                    }}>
                                    <span><i className="wppb-font-redo-arrow"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

const mapStateToProps = ( state ) => {
    return {state};
}

const mapDispatchToProps = ( dispatch ) => {
    return {
        importTemplate: ( data ) => {
            dispatch(importTemplate(data))
        },
        addNewRow: () => {
            dispatch(addRow())
        },
        pageUndoClick: () => {
            dispatch(ActionCreators.undo())
        },
        pageEmptyClick: () => {
            if (confirm("Do you want to clear page content?")) {
                dispatch(pageEmptyClick({}))
            }
        },
        pageRedoClick: () => {
            dispatch(ActionCreators.redo())
        },
        importPage: ( page ) => {
            dispatch(importPage(page))
        },
        onSettingsClick: (options) => {
            dispatch(saveSetting(options))
        },
        onChangeColumnWidth: (data) => {
            dispatch(changeColumnWidth(data))
        }
    }
}
export default connect(
    mapStateToProps,
    mapDispatchToProps
)(withDragDropContext(PageTools));
