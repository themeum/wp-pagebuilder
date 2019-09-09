import React,{ Component } from 'react';
import { connect } from 'react-redux'
import { ItemTypes } from './Constants';
import { DragSource } from 'react-dnd';
import { addBlock } from '../actions/index';
import mySectionsData from '../helpers/MySectionsData';

const blockSource = {
	beginDrag(props){
		return { type: 'block', element: props.element }
	}
}

class MySectionItem extends Component {
	deleteThisItem(){
		if (!window.confirm("Do you really want to delete this saved section?")) {
			return;
		}
		jQuery.ajax({
			type: 'POST',
			url: page_data.ajaxurl,
			dataType: 'json',
			data: { action: 'wppb_pagebuilder_section_action' , actionType: 'delete' , 'id': this.props.element.id},
			cache: false,
			beforeSend: function(){
				jQuery('body').append('<div class="loadingMessagePageTool"><i class="wppb-font-trash"></i> Delete Section </div>').fadeIn(500);
			},
			complete:function(response){
				mySectionsData.deleteSection(this.props.index);
				jQuery('.loadingMessagePageTool').remove();
			}.bind(this)
		});
	}

	render(){
		const { element, connectDragPreview, connectDragSource } = this.props;
		return connectDragPreview(connectDragSource(
			<li>
				<div className="wppb-my-saved-section-item">
					<span><i className="wppb-font-puzzle"/>{element.title}</span>
					<span onClick={e => { this.deleteThisItem()}}><i className="wppb-font-close" /></span>
				</div>
			</li>
		))
	}
}

var DragSourceDecorator = DragSource(ItemTypes.BLOCK, blockSource,
	function(connect, monitor) {
		return {
			connectDragSource: connect.dragSource(),
			connectDragPreview: connect.dragPreview(),
			isDragging: monitor.isDragging()
		};
	}
);

const mapStateToProps = ( state ) => {
  return {state};
}

const mapDispatchToProps = ( dispatch ) => {
	return {
		addBlock: ( rowIndex, dragIndex, hoverIndex ) => {
			dispatch(addBlock(rowIndex, dragIndex, hoverIndex))
		}
	}
}

export default connect(
	mapStateToProps,
	mapDispatchToProps
)(DragSourceDecorator(MySectionItem));