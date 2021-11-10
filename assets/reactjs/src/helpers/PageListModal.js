import React, { Component } from 'react';
import { Modal, ModalManager } from './index'

class PageListModal extends Component {

    constructor(props) {
        super(props);
        this.state = {
            status: false,
            data: '',
            category: [],
            layer: 'multiple',
            templateCounter:0,
            layoutCounter:0,
            searchContext:'',
            isSearchEnable: false,
            notFoundMessage : 'Sorry we couldn\'t find your match request!',
            requestFailedMsg : '',
            lastTempalteCachedTime : '',
            spinner: false
        };
    }

    componentDidMount(){
        let that = this;
        let requestFailedMsg = [];
        let xhr = new XMLHttpRequest();
        xhr.open('POST', page_data.ajaxurl, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.responseType = 'json';
        xhr.onload = function  () {
            if ( xhr.status === 200) {

                let finalFilter = {},
                    templates = [],
                    counter = 0,
                    layoutCount = 0;

                if (xhr.response.success) {
                    __.forEach(xhr.response.data, arr => {

                        if (arr.category) {
                            if (arr.parentID) {
                                counter++;
                            }else{
                                layoutCount++;
                            }

                            __.forEach(arr.category, a => {
                                if (a.name in finalFilter) {
                                    finalFilter[a.name].push(arr)
                                } else {
                                    finalFilter[a.name] = [];
                                    finalFilter[a.name].push(arr)
                                }

                                let index = -1;
                                templates.forEach((change, i) => {
                                    if (a.name == change.name) {
                                        index = i
                                    }
                                });
                                if (index === -1) {
                                    templates.push({name: a.name, active: false})
                                }
                            })
                        }
                    });

                    that.setState({status: true, data: finalFilter,layoutCounter: layoutCount, category: templates, templateCounter: counter});

                    if (xhr.response.cached_at){
                        that.setState({lastTempalteCachedTime: xhr.response.cached_at});
                    }

                }else {
                    that.setState({status: false, requestFailedMsg: xhr.response.data.messages});
                }
            }else{
                requestFailedMsg.push(xhr.status+' : '+xhr.statusText);
                that.setState({requestFailedMsg: requestFailedMsg });
            }
        };
        xhr.send("action=wppb_load_page_template&security="+page_data.ajax_nonce);
    }

    getCurrentData( type ){
        let data = [];
        let hasActiveCat = false;
        let tempDataID = [];

        if( type === 'single' ){
            this.state.category.map( (cat, i) => {
                if( cat.active === true ){
                    hasActiveCat = true;
                    __.forEach( this.state.data[cat.name] , value => {
                        if( value.parentID  && ! (tempDataID.indexOf(value.ID) > -1 )  ) {
                            data.push( value );
                            tempDataID.push(value.ID);
                        }
                    } )
                }
            });
            if( hasActiveCat === false ){
                __.forEach( this.state.data, cat => cat.forEach( value => {
                    if( value.parentID && ! (tempDataID.indexOf(value.ID) > -1 )  ) {
                        data.push( value );
                        tempDataID.push(value.ID);
                    }
                } ) )
            }
        }else if( type === 'multiple' ){
            this.state.category.map( (cat, i) => {
                if( cat.active === true ){
                    hasActiveCat = true;
                    __.forEach( this.state.data[cat.name] , value => {
                        if( ! value.parentID   && ! (tempDataID.indexOf(value.ID) > -1 ) ){
                            if( __.find(value.category, { 'name': cat.name } ) ) {
                                tempDataID.push(value.ID);
                                data.push( value );
                            }
                        }
                    })
                }
            });

            if( hasActiveCat === false ){
                __.forEach( this.state.data, cat => cat.forEach( value => {
                    if( ! value.parentID && ! (tempDataID.indexOf(value.ID) > -1 ) ) {
                        data.push( value );
                        tempDataID.push(value.ID);
                    }
                } ) )
            }
        }else{
            // Multiple Entities(multiple_entity)
            let parentID = this.state.parent_id;
            __.forEach( this.state.data, cat => cat.forEach( value => {
                if( value.parentID && parentID === value.parentID ) {
                    data.push( value );
                    tempDataID.push(value.ID);
                }
            } ) )
            data = __.uniqBy(data, function (e) { return e.name; } );
        }
        if( this.state.isSearchEnable && data.length > 0 ){
            let filterData = data.filter( item => item.name.toLowerCase().search(this.state.searchContext.toLowerCase()) !== -1 );
            return filterData
        }
        return data
    }

    importTemplate(template_id , isPro, fileUrl ){
        if( typeof page_data.WPPB_PRO_VERSION === 'undefined' && isPro == true ){
            //
        }else{
            this.setState({spinner:template_id})
            let that = this;
            let xhr = new XMLHttpRequest();
            xhr.open('POST', page_data.ajaxurl, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.responseType = 'json';
            xhr.onload = function  () {
                if ( xhr.status === 200) {
                    if (xhr.response.success) {
                        let pageData = xhr.response.data;
                        that.props.importTemplate(pageData);
                        ModalManager.close();
                    }
                }
            };
            xhr.send("action=wppb_import_single_page_template&template_id="+template_id+"&fileUrl="+fileUrl+"&security="+page_data.ajax_nonce);
        }
    }

    onClickSingleEntity(val, template_id) {
        this.setState({ layer:'multiple_entity', currentName: val, parent_id : template_id })
    }

    resetAllCategory(){
        let { category } = this.state;
        category.map( (cat, i) => {
            cat.active = false
        });
        this.setState({ category })
    }

    _OnSelectTemplateCategory(index, event){
        event.preventDefault();
        let { category } = this.state;
        category[index].active = !category[index].active
        if( this.state.layer === 'multiple_entity' ){
            this.setState({ category, layer: 'multiple', currentName:'' })
        }else{
            this.setState({ category })
        }
    }

    _OnSearchTemplate(event){
        let { isSearchEnable } = this.state;
        isSearchEnable = event.target.value === '' ? false : true
        this.setState({ isSearchEnable , searchContext: event.target.value })
    }

    _backgroundImage(url){
        if (!url){
            return page_data.pagebuilder_base+'assets/img/placeholder/wppb-medium.jpg';
        }
        return url;
    }

    render() {
        let currentTemples = this.getCurrentData( this.state.layer );
        let types = typeof page_data.WPPB_PRO_VERSION === 'undefined' ? 'inactive' : 'active'
        return (
            <Modal className="wppb-builder-modal-pages-list" customClass="wppb-builder-modal-template-list" onRequestClose={this.props.onRequestClose} openTimeoutMS={0} closeTimeoutMS={0}>
                { this.state.status ?
					<div className="wppb-template-list-modal">
						<div className="wppb-builder-template-controller">
							<div className="template-search-box">
								<input type="text" onChange={this._OnSearchTemplate.bind(this)} value={this.state.searchContext} placeholder={page_data.i18n.search} className="form-control"/>
								<i className="wppb-font-search"></i>
							</div>
							<hr className="hr-line"/>
							<h3 className="sub-title">{page_data.i18n.categories}</h3>
							<ul className="wppb-template-cats">
                                { this.state.category.map( ( data, index ) => {
                                    let active = ( data.active == true ) ? 'wppb-cat-active' : ''
                                    return(
                                        <li key={index} onClick={this._OnSelectTemplateCategory.bind(this, index) } className={active}>
                                            <span className="checkmark"></span>
                                            <input type="checkbox" onChange={this._OnSelectTemplateCategory.bind(this, index) } checked={data.active} value={data.name}/>
                                            <span className={active}> {data.name} </span>
                                        </li>
                                    )
                                })}
                            </ul>
                            {
                                this.state.lastTempalteCachedTime &&
                                <p className="wppb_template_cached_time">{this.state.lastTempalteCachedTime}</p>
                            }
                        </div>
                        <div className="wppb-builder-template-list-container">
                            <div className="template-list-header">
                                { (this.state.layer === 'multiple_entity') ?
                                    <div className="wppb-builder-template-notification">
                                        <div className="wppb-builder-template-back-button" onClick={ e=> this.setState({ layer:'multiple', currentName:''})}>
                                            <span className="back-icon fas fa-reply"></span>
                                        </div>
                                        <div className="wppb-builder-template-notification-message">
                                            <h3 className="active-template-name"> {this.state.currentName} </h3>
                                            <span className="number-of-template-list"> {currentTemples.length} {page_data.i18n.pages} </span>
                                        </div>
                                    </div>
                                    :
                                    <h3 className="template-list-title"> 
                                        <i className="wppb-font-layout"></i> { this.state.layer === 'multiple' ? this.state.layoutCounter+' Layout Bundles' : this.state.templateCounter+' Layouts' }
                                    </h3>
                                }
								<div className="template-options">
									<ul>
										<li className={this.state.layer === 'multiple' || this.state.layer === 'multiple_entity' ? 'active' : ''}> <i className="wppb-font-folders" onClick={ e => this.setState({ layer:'multiple' }) } /></li>
										<li className={this.state.layer === 'single' ? 'active' : ''}> <i className="wppb-font-Page-grid" onClick={ e => this.setState({ layer:'single' }) } /> </li>
									</ul>
								</div>
							</div>


                            <ul className="wppb-builder-page-templates">
                                { this.state.layer == 'single' &&
                                currentTemples.map((page, index) =>
                                    <li key={index} className={ ( types == 'inactive' && page.pro == true ) ? 'inactive' : '' }>
                                        <div>
                                            <div className="wppb-default-template-image">
                                            <img src={this._backgroundImage(page.preview_m)} srcSet={this._backgroundImage(page.preview)+ ' 2x'}/>
                                            { page.pro &&
                                                <span className="wppb-pro">{page_data.i18n.pro}</span>
                                            }
                                            { page.liveurl &&
                                            <div className="wppb-layout-wrap">
                                                <a className="wppb-layout-view" target="_blank" href={page.liveurl}><i className="fas fa-share"/>{page_data.i18n.preview}</a>
                                            </div>
                                            }
                                            </div>
                                            <div className="wppb-tmpl-info">
                                                <span className="wppb-tmpl-title" dangerouslySetInnerHTML={{__html:page.name}}/>
                                                <span className="wppb-builder-btn wppb-btn-success" onClick={(e) => { this.importTemplate(page.ID,page.pro,( page.file ? page.file : false ) ) }}>
                                                { this.state.spinner == page.ID ?
                                                    <i className="fas wppb-font-sync fa-spin" />
                                                    :
                                                    <i className="wppb-font-download-alt" />
                                                } {page_data.i18n.import}</span>
                                            </div>
                                        </div>
                                    </li>
                                )}
                                { this.state.layer == 'multiple' &&
                                currentTemples.map((page, index) =>
                                    <li key={index}>
                                        <div className="multiple-template-view" onClick={ () => this.onClickSingleEntity( page.name, page.ID ) } >
                                            <div className="wppb-default-template-image"><img src={this._backgroundImage(page.preview_m)} srcSet={this._backgroundImage(page.preview)+ ' 2x'}/>
                                            { page.pro &&
                                                <span className="wppb-pro">{page_data.i18n.pro}</span>
                                            }</div>
                                            <div className="wppb-tmpl-info">
                                                <span className="wppb-tmpl-title" dangerouslySetInnerHTML={{__html:page.name}}/>
                                            </div>
                                        </div>
                                    </li>
                                )}

                                { this.state.layer == 'multiple_entity' &&
                                currentTemples.map((page, index) =>
                                    <li key={index} className={ ( types == 'inactive' && page.pro == true ) ? 'inactive' : '' }>
                                        <div>
                                            <div className="wppb-default-template-image"><img src={this._backgroundImage(page.preview_m)} srcSet={this._backgroundImage(page.preview)+ ' 2x'}/>
                                                { page.pro &&
                                                    <span className="wppb-pro">{page_data.i18n.pro}</span>
                                                }
                                                { page.liveurl &&
                                                    <div className="wppb-layout-wrap">
                                                        <a className="wppb-layout-view" target="_blank" href={page.liveurl}><i className="fas fa-share"/>{page_data.i18n.preview}</a>
                                                    </div>
                                                }
                                            </div>
                                            <div className="wppb-tmpl-info">
                                                <span className="wppb-tmpl-title">{__.split(page.name,'&#8211;')[1]}</span>
                                                <span className="wppb-builder-btn wppb-btn-success" onClick={(e) => this.importTemplate(page.ID,page.pro,( page.file ? page.file : false )) }>
                                                { this.state.spinner == page.ID ?
                                                    <i className="fas wppb-font-sync fa-spin" />
                                                    :
                                                    <i className="wppb-font-download-alt" />
                                                } {page_data.i18n.import} </span>
                                            </div>
                                        </div>
                                    </li>
                                )}
                            </ul>
                            { currentTemples.length === 0 ?
                                <div className="wppb-builder-template-found-empty"><h3 className="wppb-builder-empty-title"> {this.state.notFoundMessage} </h3></div>
                                : null
                            }
                        </div>
                        <span className="wppb-builder-close-modal" onClick={e => { ModalManager.close() }}><i className="wppb-font-close"></i></span>
                    </div>
                    :
                    <div>
                        <div style={{ height: "350px"}}>
                            { this.state.requestFailedMsg ?
                                this.state.requestFailedMsg.map( (error, index) => <p key={index}>{error}</p> )
                                :
                                <div className="wppb-modal-loader"><img src={page_data.pagebuilder_base + 'assets/img/loading-md.svg'} alt="loading"/></div>
                            }
                            <span className="wppb-builder-close-modal" onClick={e => { ModalManager.close() }}><i className="wppb-font-close"></i></span>
                        </div>
                    </div>
                }
            </Modal>
        )
    }
}

export default PageListModal;
