import React, { Component } from 'react'
import { connect } from 'react-redux'
import { ItemTypes } from './Constants'
import { DropTarget } from 'react-dnd'
import Addon from './Addon'
import InnerRow from './InnerRow'
import { saveSetting } from '../actions/index'
import EditPanelManager from '../helpers/EditPanelManager'

const addonListTarget = {
    drop(props, monitor, component){
        const item = monitor.getItem();

        if(item.type == 'ADD_ADDON' && monitor.isOver({ shallow: true })){
            return {
                type: 'addon',
                status: true,
                index: 0,
                dropPosition: 'top',
                rowIndex: props.rowIndex,
                colIndex: props.colIndex
            };
        } else if(monitor.isOver({ shallow: true })){
            const dragIndex     = item.index;
            const hoverIndex    = props.index;
            
            let options = {
                drag        : item,
                dragIndex   : dragIndex,
                drop        : props,
                hoverIndex  : hoverIndex
            };

            if (typeof item.innerRowIndex === 'undefined'){
                if ( props.rowIndex === item.rowIndex) {
                    options.type = 'ADDON_SORT_COL';
                } else {
                    options.type = 'ADDON_SORT_OUTER_ROW';
                }
            } else {
                if ( props.rowIndex === item.rowIndex) {
                    options.type = 'ADDON_SORT_PARENT_COL_INNER';
                } else {
                    options.type = 'ADDON_SORT_PARENT_OUTER_ROW';
                }
            }
            props.dropAddon( options );
            monitor.getItem().index         = 0;
            monitor.getItem().innerRowId    = props.innerRowId;
            monitor.getItem().innerColId    = props.innerColId;
            monitor.getItem().rowIndex      = props.rowIndex;
            monitor.getItem().colIndex      = props.colIndex;
            monitor.getItem().innerRowIndex = props.innerRowIndex;
            monitor.getItem().innerColIndex = props.innerColIndex;
        }
    }
};



class AddonList extends Component {
    emptyData(){
        return(
            <div className="wppb-builder-add-addon-empty">
                <div className="wppb-builder-add-addon-wrap" onClick={ e => { EditPanelManager.resetAll(); }}><i className="wppb-font-add-alt"/></div>
            </div> 
        )
    }
    render() {
        const { column, addons , rowIndex, colIndex, connectDropTarget } = this.props;

        let addonsClass = "wppb-builder-addons";
        if(!addons.length) { addonsClass = addonsClass + ' wppb-builder-no-addons'; }
        if(this.props.isOverCurrent){ addonsClass = addonsClass + ' wppb-builder-show-placeholder'; }

        return connectDropTarget(
            <div className={addonsClass}>
                    { addons.length ?
                        addons.some(function (val) {  return (val.type == 'addon' || val.type == 'widget') }) ?
                            null
                            :
                            <div className="wppb-builder-no-addons">{ this.emptyData() }</div>
                        :
                        this.emptyData()
                    }
                    {
                    addons.map( ( addon, index) => addon &&
                        <div key={index}  className={ addon.type == 'inner_row' ? 'wppb-inner-row-addons' : null }>
                            { addon.type === 'inner_row' ?
                            <InnerRow
                                key={addon.id}
                                id={addon.id}
                                rowIndex={rowIndex}
                                colIndex={colIndex}
                                data={addon}
                                index={index}
                                addonSort={ this.props.addonSortable } />
                            :
                            <Addon
                                key={addon.id}
                                id={addon.id}
                                rowIndex={rowIndex}
                                addon={addon}
                                column={column}
                                colIndex={colIndex}
                                index={index}
                                addonSort={this.props.addonSortable}
                                columnMove={this.props.moveButton} />
                            }
                        </div>
                    )
                }
            </div>
        )
    }
}

var DropTargetDecorator = DropTarget( [ ItemTypes.ADDON, ItemTypes.INNERROW, ItemTypes.INNERADDON ], addonListTarget,
    function( connect, monitor ) {
        return {
            connectDropTarget: connect.dropTarget(),
            isOver: monitor.isOver(),
            canDrop: monitor.canDrop(),
            isOverCurrent: monitor.isOver({ shallow: true })
        };
    }
);

const mapStateToProps = ( state ) => {
    return { state: state };
}

const mapDispatchToProps = ( dispatch ) => {
    return {
        addonSortable : ( options ) => {
            dispatch(options);
        },
        onSettingsClick: (options) => {
            dispatch(saveSetting(options))
        }
    }
}

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(DropTargetDecorator(AddonList));
