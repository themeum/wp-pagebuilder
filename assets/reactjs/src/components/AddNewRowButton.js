import React, { Component } from 'react'
import { connect } from 'react-redux'
import { addRowBottom } from '../actions/index'
import PageListModal from '../helpers/PageListModal'
import { ModalManager } from '../helpers/index'
import { importTemplate } from '../actions/index'

class addNewRowButton extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isOpen: false,
            layouts: [
                { size: '100', icon: [{v:'1',c: '12'}] },
                { size: '50,50', icon: [{v:'1/2',c: '6'},{v:'1/2',c: '6'}] },
                { size: '33.33,33.33,33.33', icon: [{v:'1/3',c: '4'},{v:'1/3',c: '4'},{v:'1/3',c: '4'}] },
                { size: '33.34,66.66', icon: [{v:'1/3',c: '4'},{v:'2/3',c: '8'}] },
                { size: '66.66,33.34', icon: [{v:'2/3',c: '8'},{v:'1/3',c: '4'}] },
                { size: '25,25,25,25', icon: [{v:'1/4',c: '3'},{v:'1/4',c: '3'},{v:'1/4',c: '3'},{v:'1/4',c: '3'}] },
                { size: '41.66,58.34', icon: [{v:'5/12',c: '5'},{v:'7/12',c: '7'}] },
                { size: '25,25,50', icon: [{v:'1/4',c: '3'},{v:'1/4',c: '3'},{v:'1/2',c: '6'}] },
                { size: '50,25,25', icon: [{v:'1/2',c: '6'},{v:'1/4',c: '3'},{v:'1/4',c: '3'}] },
                { size: '25,50,25', icon: [{v:'1/4',c: '3'},{v:'1/2',c: '6'},{v:'1/4',c: '3'}] },
                { size: '20,20,20,20,20', icon: [{v:'1/5',c: '15'},{v:'1/5',c: '15'},{v:'1/5',c: '15'},{v:'1/5',c: '15'},{v:'1/5',c: '15'}] },
                { size: '16.67,16.67,16.67,16.67,16.66,16.66', icon: [{v:'1/6',c: '2'},{v:'1/6',c: '2'},{v:'1/6',c: '2'},{v:'1/6',c: '2'},{v:'1/6',c: '2'},{v:'1/6',c: '2'}] },
            ]
        };
    }

    _rednerDropDown() {
        return (
            this.state.layouts.map((layout, index) =>
                <div key={index} className="wppb-builder-layouts-col" onClick={e => {
                    this.props.addNewRowBottom(this.props.rows, layout.size);
                    this.setState({ isOpen: false })
                    /* jQuery( document ).trigger( "setWidthTrigger" ); */
                    }}>
                    <div className="wppb-builder-layouts-col-in">
                        { layout.icon.map( ( value,ind ) => {
                                return (<div className={'wppb-layouts-col wppb-layouts-col-'+value.c} key={ind}><div>{value.v}</div></div>)
                            }
                        )}
                    </div>
                </div>
            )
        )
    }

    toggleLayout() {
        this.setState({ isOpen: !this.state.isOpen })
    }

    render() {
        const activeClass = this.state.isOpen ? ' wppb-layout-open' : '';
        return (
            <div className={ "wppb-row-add-dropdown" + activeClass }>
                            { this.state.isOpen &&
                    <div className={ "wppb-builder-dropdown-row-layouts"}>
                        <div className="wppb-builder-layouts-container">
                            <div className="wppb-builder-layouts-container-inner">
                                <div className="wppb-builder-layouts-list clearfix">
                                    {this._rednerDropDown()}
                                </div>
                            </div>
                        </div>
                    </div>
                }
                { this.props.single ?
                    <div onClick={ () => this.toggleLayout() } className="wppb-builder-btn"><i className="wppb-font-add-alt"/></div>
                    :
                    <div className="wppb-blank-page-add-dropdown">
                        <div
                            title={page_data.i18n.add_row}
                            onClick={ () => this.toggleLayout() }
                            className="wppb-builder-btn-classic">
                            <i className="wppb-font-add-alt"/>{page_data.i18n.add_row}
                        </div>
                        <div className="wppb-builder-import wppb-builder-btn-import" onClick={(e)=>{ ModalManager.open( <PageListModal importTemplate={this.props.importTemplate} onRequestClose={() => true } />) }}>
                            <i className="wppb-font-layout"/> {page_data.i18n.layouts}
                        </div>
                    </div>
                }

            </div>
        )
    }
}

const mapStateToProps = (state) => {
    return {
        state: state
    };
}

const mapDispatchToProps = (dispatch) => {
    return {
        addNewRowBottom: (index, layout) => {
            dispatch(addRowBottom(index, layout))
        },
        importTemplate: ( page ) => {
			dispatch(importTemplate(page))
		},
    }
}

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(addNewRowButton);
