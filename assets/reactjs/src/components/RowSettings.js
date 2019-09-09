import React, { Component } from 'react'
import { connect } from 'react-redux'
import { ModalManager} from '../helpers/index'
import EditPanelManager from '../helpers/EditPanelManager'
import RowSaveModal from '../helpers/RowSaveModal'

import {
  shiftUpRow,
  shiftDownRow,
  toggleRow,
  deleteRow,
  cloneRow,
  saveSetting,
  pasteRow,
  deleteAddon,
  innerCloneRow,
  innerToggleRow,
  innerPasteRow
} from '../actions/index';

class RowSettings extends Component {
	_getSettingObjects(){
		return{
			index: this.props.index,
			settings: { colIndex: this.props.colIndex, addonIndex: this.props.innerRowIndex }
		}
	}

	_duplicateRowClickHandle(){
		const options = this._getSettingObjects();
		
		typeof this.props.innerRowIndex === 'undefined'
		? this.props.cloneRow(this.props.index)
		: this.props.innerCloneRow(options)
	}

	_rowVisbilityToggleHandle(){
		const options = this._getSettingObjects();

		typeof this.props.innerRowIndex === 'undefined'
		? this.props.toggleRow(this.props.row.id)
		: this.props.innerToggleRow(options)
	}

	_pasteClickHandle(){
		let dataType = '';
		if (typeof this.props.innerRowIndex === 'undefined') {
			dataType = 'row';
		} else {
			dataType = 'inner_row';
		}
		ModalManager.open(
			<PasteModal
				dataType={dataType}
				pasteSave={this.props.pasteSave}
				rowIndex={ this.props.index }
				colIndex={ this.props.colIndex }
				addonIndex={ this.props.innerRowIndex }
				onRequestClose={() => true}/>
		);
	}

	_deleteRowClickHandle(){
		// if (window.confirm( "Do you really want to delete this row?" )) {
			typeof this.props.innerRowIndex === 'undefined'
			? this.props.deleteRow(this.props.index)
			: this.props.innerDeleteRow( this._getSettingObjects() )
		// }
	}

	_shiftUpRowClickHandle(){
		if( this.props.index > 0 ){
			this.props.shiftUpRow( this.props.index )
		}
	}

	_shiftDownRowClickHandle(){
		if( this.props.state.pageBuilder.present.length > (this.props.index + 1) ){
			this.props.shiftDownRow( this.props.index )
		}
	}

	_saveRowAsSection(){
		ModalManager.open( <RowSaveModal row={this.props.row} /> );
	}

	render(){
		const {row} = this.props;
		return(
			<ul>
				{ row.visibility &&
					<li title="Row Settings" onClick={()=>{
						
						EditPanelManager.resetAll();
						if (typeof this.props.innerRowIndex === 'undefined') {
						  	EditPanelManager.setType('row');
						} else {
							EditPanelManager.setType('inner_row');
							EditPanelManager.setColIndex(this.props.colIndex);
							EditPanelManager.setInnerRowIndex(this.props.innerRowIndex);
						}
						EditPanelManager.setRowIndex(this.props.index);
						EditPanelManager.setRowSettings(this.props.row);
						EditPanelManager.showEditPanel();
						
					}}>
					<i className="wppb-font-settings"/>
					</li>
				}
				
				{ row.visibility &&
					<li title={page_data.i18n.duplicate_row} onClick={() =>{ this._duplicateRowClickHandle()}}><i className="wppb-font-sheet"/></li>
				}
				
				{ row.visibility &&
				  this.props.innerRowIndex === undefined &&
					<li title={page_data.i18n.save_row} onClick={() =>{ this._saveRowAsSection() }}><i className="wppb-font-save"/></li>
				}
				
				<li title={page_data.i18n.disable_row} onClick={ () => { this._rowVisbilityToggleHandle(); }}>
					{ row.visibility ? <i className="wppb-font-eye-off"/> : <i className="wppb-font-eye-on"/> }
				</li>

				{ row.visibility &&
					this.props.innerRowIndex === undefined &&
					<li title={page_data.i18n.move_up} onClick={()=>{ this._shiftUpRowClickHandle(); }}><i className="wppb-font-angle-up"/></li>
				}

				{ row.visibility &&
					this.props.innerRowIndex === undefined &&
					<li title={page_data.i18n.move_down} onClick={()=>{ this._shiftDownRowClickHandle(); }}><i className="wppb-font-angle-down"/></li>
				}

				{ row.visibility &&
					<li title={page_data.i18n.delete_row} onClick={()=>{ EditPanelManager.hideEditPanel(); this._deleteRowClickHandle(); }}><i className="wppb-font-trash"/></li>
				}

			</ul>
		)
	}
}


const mapStateToProps = (state) => {
  	return {state};
}

const mapDispatchToProps = (dispatch) => {
  return {
    onSettingsClick: (options) => {
      dispatch(saveSetting(options))
    },
    cloneRow: (index) => {
      dispatch(cloneRow(index))
    },
    toggleRow: (id) => {
      dispatch(toggleRow(id))
    },
    deleteRow: (index) => {
      dispatch( deleteRow( index ) )
    },
    innerCloneRow: (options) => {
      dispatch( innerCloneRow( options ) )
    },
    innerToggleRow: (options) => {
      dispatch( innerToggleRow( options ) )
    },
    innerDeleteRow: (options) => {
      dispatch( deleteAddon( options ) )
    },
    shiftDownRow: (index) => {
      dispatch( shiftDownRow( index ) )
    },
    shiftUpRow: (index) => {
      dispatch( shiftUpRow( index ) )
    },
    pasteSave: (options) => {
      if (options.type === 'row') {
        dispatch( pasteRow( options ) );
      } else {
        dispatch( innerPasteRow( options ) )
      }
    }
  }
}

export default  connect(
  mapStateToProps,
  mapDispatchToProps
)(RowSettings)
