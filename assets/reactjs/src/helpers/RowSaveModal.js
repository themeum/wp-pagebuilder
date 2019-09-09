import React, { Component } from 'react';
import { Modal, ModalManager } from './index';
import mySectionsData from './MySectionsData';

class RowSaveModal extends Component {
	getRowName(e){
		var name 		= this.refs.rowName.value;
		var row 		= this.props.row;
		let nextNodeId 	= (new Date).getTime();
		jQuery.ajax({
			type: 'POST',
			url: page_data.ajaxurl,
			dataType: 'json',
			data: { action: 'wppb_pagebuilder_section_action' ,'title': name ,'id': nextNodeId , actionType: 'save', section_data : JSON.stringify(row) },
			cache: false,
			beforeSend: function(){
				jQuery('body').append('<div class="loadingMessagePageTool"><i class="wppb-font-save"></i> Save Section</div> ').fadeIn(500);
			},
			complete:function(res){
				mySectionsData.addSection({
					title: name,
					block: row,
					id: parseInt( nextNodeId )
				});
				jQuery('.loadingMessagePageTool').remove();
			}.bind(this)
		});
		ModalManager.close();
	}
	render() {
		return(
			<Modal onRequestClose={this.props.onRequestClose} title={page_data.i18n.save_to_library} customClass="wppb-builder-modal-small" openTimeoutMS={0} closeTimeoutMS={0}>
				<div>
					<div className="wppb-builder-form-group" style={{ marginTop: '10px' }}>
						<input type="text" ref="rowName" name="row_name" className="wppb-form-control" placeholder={page_data.i18n.title_of_the_custom_section} />
					</div>
					<div className="wppb-btn-modal-save">
						<span className="wppb-builder-btn wppb-btn-success" onClick={ () => this.getRowName() }><i className="wppb-font-save"/> {page_data.i18n.save}</span>
						<span className="wppb-builder-btn wppb-btn-danger" onClick={ e => ModalManager.close() }><i className="fa fa-times-circle"/> {page_data.i18n.discard}</span>
					</div>
				</div>
			</Modal>
		)
	}
}

export default RowSaveModal;
