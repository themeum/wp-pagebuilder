import React,{ Component } from 'react';
import { connect } from 'react-redux';
import SectionItem from './SectionItem';

class SectionLibrary extends Component {

    constructor(props){
        super(props);
        this.state = { elements : [], type: '', option: [], currentSection: '', errorMessages : [] }
    }

    componentDidMount() {
        let that = this;
        let xhr = new XMLHttpRequest();
        xhr.open('POST', page_data.ajaxurl, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.responseType = 'json';
        xhr.onload = function () {
            var status = xhr.status;
            if (status === 200) {
                let remoteResponse = xhr.response;
                let responseData = remoteResponse.data;
                if (remoteResponse.success) {
                    let types = __.flatten(__.map(responseData, (element) => {
                        return element.type
                    }));
                    types = __.uniqBy(types, function (e) {
                        return e.value;
                    });
                    if (typeof types[0] != 'undefined') {
                        that.setState({type: types[0].value})
                    }
                    that.setState({elements: responseData, option: types})
                } else {
                    if (typeof responseData !== 'undefined') {
                        let errorMsgs = (typeof responseData.messages !== 'undefined') ? responseData.messages : [];
                        that.setState({errorMessages: errorMsgs});
                    }
                }
            }
        }

        xhr.send("action=wppb_get_blocks");
    }
    getFilteredItems(){
        let newElements = {},
            ThirdpartyElements = {};

        __.forEach( this.state.elements , element => {
            if( Array.isArray( element.type )  ){

                __.forEach( element.type , data => {
                    let Elements    = {};
                    Elements.block  = JSON.parse(JSON.stringify(element.rawData));
                    Elements.title  = element.name;
                    Elements.ID  = element.ID;
                    Elements.banner = element.banner;
                    Elements.pro = ( element.pro ? element.pro : false );
                    Elements.liveurl = element.liveurl;
                    if( element.thirdparty ){
                        if( ! ThirdpartyElements[data.label] ){ ThirdpartyElements[data.label] = [] }
                        ThirdpartyElements[data.label].push( Elements );
                    }else{
                        if( ! newElements[data.label] ){ newElements[data.label] = [] }
                        newElements[data.label].push( Elements );
                    }
                    
                })

            }
        });
        return { newElements, ThirdpartyElements };
    }


    _classEvents( key ){
        if( this.state.currentSection == key ){
            this.setState({ currentSection: '' });
        }else{
            this.setState({ currentSection: key });
        }
    }


    render(){
        let counter = 0;
        let sectionList = this.getFilteredItems();
        return(
            <div className="wppb-builder-section-lib-panel-container">
                <div className="wppb-builder-section-lib-panel active">

                    {!__.isEmpty( this.state.elements ) ?

                            __.map( [ 'newElements', 'ThirdpartyElements' ], ( types, i ) => {
                                return(
                                    <div key={i} className="wppb-tab-fields">
                                        {
                                            __.map( sectionList[types], ( element, index ) => {
                                                counter++;
                                                return(
                                                    <div key={index} className="form-section">
                                                        <div className={'section-title' + ( this.state.currentSection == index ? ' active':'' ) } onClick = {(e) => { this._classEvents(index); }}>{index} <div className="section-title-carat"><i className="fa fa-angle-down"/></div></div>
                                                        <div className={'section-content' + ( this.state.currentSection == index ? ' active':'' ) }>
                                                            {
                                                                __.map( element,(el, i ) => {
                                                                    return ( <SectionItem element={el} key={i} index={i} /> )
                                                                })
                                                            }
                                                        </div>
                                                    </div>
                                                )
                                            })
                                        }
                                    </div>
                                )
                            })
                        :

                        this.state.errorMessages.length ?
                            (
                                this.state.errorMessages.map( (error, index) => {
                                    return <div key={index} className={'wppb_alert_warning'}>{error}</div>
                                } )
                            )
                            :
                            (
                                <div className="wppb-section-loading"><img
                                    src={page_data.pagebuilder_base + 'assets/img/loading-md.svg'} alt="loading"/>
                                </div>
                            )

                    }

                </div>
            </div>
        )
    }
}
export default connect()(SectionLibrary);