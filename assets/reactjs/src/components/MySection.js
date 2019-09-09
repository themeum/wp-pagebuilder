import React, { Component } from 'react';
import { connect } from 'react-redux';
import mySectionsData from '../helpers/MySectionsData';
import MySectionItem from './MySectionItem';


class MySection extends Component {
    constructor(props){
        super(props);
        this.getMySection = this.getMySection.bind(this)
        this.state = {
            saveElements : mySectionsData.getAllSections()
        }
    }

    componentWillMount(){
        mySectionsData.on('change', this.getMySection)
    }

    componentWillUnmount(){
        mySectionsData.removeListener('change', this.getMySection);
    }

    changeObjectEmptyAddon(rows){
        __.forEach(rows, function( row ){
            __.forEach(row.block.columns,function( column ){
                if( !column.hasOwnProperty('addons') ){
                    column.addons = [];
                } else {
                    __.forEach(column.addons,function( addon ){
                        if( addon.hasOwnProperty('type') ){
                            if( addon.type === 'inner_row'  ){
                                __.forEach(addon.columns,function( innerColumn ){
                                    if( !innerColumn.hasOwnProperty('addons') ){
                                        innerColumn.addons = [];
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });
        return rows;
    }

    componentDidMount(){
        jQuery.ajax({
            type: 'POST',
            url: page_data.ajaxurl,
            dataType: 'json',
            data: { action: 'wppb_pagebuilder_section_action' , actionType: 'get'},
            cache: false,
            complete:function(response){
                if( response.responseText ){
                    let responseData = this.changeObjectEmptyAddon( JSON.parse( response.responseText ) );
                    mySectionsData.setAllSections( __.map( responseData , (n) => {
                        n.id = parseInt(n.id);
                        return n;
                    } ) );
                }
                jQuery('.wppb-section-loading').html( 'No Library Data Found.' );
            }.bind(this)
        });
    }

    getMySection(){
        let sections = mySectionsData.getAllSections();
        this.setState({ saveElements: sections })
    }

    render(){
        return(
            <div className="wppb-builder-my-section-lib-panel">
                { this.state.saveElements.length ?
                    <ul>
                        { this.state.saveElements.map((element, index) => { return( <MySectionItem element={element} key={index} index={index} /> )}) }
                    </ul>
                    :
                    <div className="wppb-section-loading"><img src={page_data.pagebuilder_base + 'assets/img/loading-md.svg'} alt="loading"/></div>
                }
            </div>
        )
    }
}

export default connect()(MySection);