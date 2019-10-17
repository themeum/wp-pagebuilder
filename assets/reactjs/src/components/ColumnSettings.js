import React, { Component } from 'react';
import { connect } from 'react-redux';
import EditPanelManager from '../helpers/EditPanelManager';
import { cloneColumn, cloneInnerColumn, innerExtraColumn, addExtraColumn, addInnerRow, deleteColumn, deleteInnerColumn, disableColumn, disableInnerColumn, saveSetting, pasteAddon, pasteAddonInner } from '../actions/index';

class ColumnSettings extends Component{
    constructor( props ){
        super( props );
    };

    _getSettingObjects(){
        const { rowIndex, colIndex, addonIndex, innerColIndex } = this.props;
        return{
            index: rowIndex,
            settings: {
                colIndex: colIndex,
                addonIndex: addonIndex,
                innerColIndex: innerColIndex
            }
        }
    }

    _deleteColumnClickHandle(){
        const { rowIndex, colIndex } = this.props;
        const options = this._getSettingObjects();
        
        // if (window.confirm( "Do you really want to delete this column?" )) {
            typeof this.props.innerColIndex === 'undefined'
                ? this.props.deleteColumn( rowIndex, colIndex )
                : this.props.deleteInnerColumn(options);
        // }
    }

    _disableColumnClickHandle(){
        const { rowIndex, colIndex, column } = this.props;
        const options = this._getSettingObjects();

        typeof this.props.innerColIndex === 'undefined'
            ? this.props.disableColumn( rowIndex, colIndex, column.id )
            : this.props.disableInnerColumn(options);
    }

    _duplicateColumn(){
        const { rowIndex, colIndex, column } = this.props;
        const options = this._getSettingObjects();

        typeof this.props.innerColIndex === 'undefined'
            ? this.props.cloneColumn( rowIndex,colIndex )
            : this.props.cloneInnerColumn(options);
    }

    _pasteAddonHandle(){
        const { rowIndex, colIndex, column } = this.props;
        const options = this._getSettingObjects();

        typeof this.props.innerColIndex === 'undefined'
            ? this.props.pasteAddon( rowIndex, colIndex, column.id )
            : this.props.pasteAddonInner( options );
    }

    render(){
        const { column, row, innerRow, rowIndex, colIndex , addonIndex, innerColIndex, connectDragSource, pasteAddon, pasteAddonInner } = this.props;
        return(
            <ul>
                { column.visibility &&
                    <li title="Column Settings"
                        onClick = {() => {
                            EditPanelManager.resetAll();
                            
                            if (typeof innerColIndex === 'undefined') {
                                EditPanelManager.setType('column');
                                EditPanelManager.setRowSettings(row);
                            } else {
                                EditPanelManager.setType('inner_column');
                                EditPanelManager.setInnerRowIndex(addonIndex);
                                EditPanelManager.setInnerColIndex(innerColIndex);
                                EditPanelManager.setRowSettings(innerRow);
                            }
                            
                            EditPanelManager.setRowIndex(rowIndex);
                            EditPanelManager.setColIndex(colIndex);
                            EditPanelManager.setColSettings(column);
                            
                            EditPanelManager.showEditPanel();

                        }}>

                        <i className="wppb-font-settings"/>
                    </li>
                }
                { column.visibility &&
                    <li title={page_data.i18n.add_column} onClick = {
                        () => {
                            let total_current_col = this.props.state.pageBuilder.present[rowIndex].columns.length;
                            if (total_current_col > 9){ return; }
                            
                            typeof this.props.innerColIndex === 'undefined'
                            ? this.props.addExtraColumn( rowIndex,colIndex )
                            : this.props.innerExtraColumn( rowIndex, colIndex, addonIndex, innerColIndex )

                        }}>
                        <i className="wppb-font-add-alt"/>
                    </li>
                } 
                { column.visibility &&
                    <li title={page_data.i18n.duplicate_column} onClick = { () => { this._duplicateColumn(); }}><i className="wppb-font-sheet"/></li>
                }
                <li title={page_data.i18n.disable_column} onClick = { () => { this._disableColumnClickHandle(); }}>
                    { column.visibility ? <i className="wppb-font-eye-off"/>:<i className="wppb-font-eye-on"/>}
                </li>
                { typeof this.props.innerColIndex === 'undefined' ?
                    column.visibility &&
                        this.props.colLength > 1 &&
                            <li title={page_data.i18n.delete_column} onClick = { () => { EditPanelManager.hideEditPanel(); this._deleteColumnClickHandle(); }}><i className="wppb-font-trash"/></li>
                    :
                    column.visibility &&
                        this.props.innerColLength > 1 &&
                            <li title={page_data.i18n.delete_column} onClick = { () => { EditPanelManager.hideEditPanel(); this._deleteColumnClickHandle(); }}><i className="wppb-font-trash"/></li>
                }
                { column.visibility &&
                     typeof this.props.innerColIndex === 'undefined' &&
                    <li title={page_data.i18n.add_inner_row} onClick = { () => { this.props.addInnerRow( rowIndex, colIndex ); }}><i className="wppb-font-add-row"/></li>
                }
                <li title="Paste Addon" onClick = { () => { this._pasteAddonHandle(); }}>
                    { column.visibility && 
                        <i className="fa fa-paste"/>
                    }
                </li>
                { connectDragSource(<li title={page_data.i18n.drag_column} onClick ={ (e) => { this.props.columnMove(true); }}><i className="wppb-font-arrows"/></li>) }
                
            </ul>
        )
    }
}


const mapStateToProps = (state) => {
    return { state };
}

const mapDispatchToProps = (dispatch) => {
    return {
        onSettingsClick: (options) => {
            dispatch(saveSetting(options))
        },
        addInnerRow: ( rowIndex, colIndex ) => {
            dispatch(addInnerRow( rowIndex, colIndex ))
        },
        addExtraColumn: ( rowIndex, colIndex ) => {
            dispatch(addExtraColumn( rowIndex, colIndex ))
        },
        innerExtraColumn: ( rowIndex, colIndex, addonIndex, innerColIndex ) => {
            dispatch(innerExtraColumn( rowIndex, colIndex, addonIndex, innerColIndex ))
        },
        cloneColumn: ( rowIndex, colIndex ) => {
            dispatch(cloneColumn( rowIndex, colIndex ))
        },
        cloneInnerColumn: ( options ) => {
            dispatch(cloneInnerColumn( options ))
        },
        deleteColumn: (index,colIndex) => {
            dispatch(deleteColumn(index,colIndex))
        },
        deleteInnerColumn: (options) => {
            dispatch(deleteInnerColumn(options))
        },
        disableColumn: (index, colIndex, id) => {
            dispatch(disableColumn(index, colIndex, id))
        },
        disableInnerColumn: (options) => {
            dispatch(disableInnerColumn(options))
        },
        pasteAddon: ( rowIndex, colIndex, id ) => {
            dispatch(pasteAddon( rowIndex, colIndex, id ))
        },
        pasteAddonInner: ( options ) => {
            dispatch(pasteAddonInner( options ))
        }
    }
}

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(ColumnSettings);
