import React, { Component } from 'react'
import { DragSource, DropTarget } from 'react-dnd';
import { setRepeatFields } from './actions/index'
import FieldsRender from './FieldsRender'
import { findDOMNode } from 'react-dom'
import { ItemTypes } from './Constants'
import { connect } from 'react-redux'

const itemSource = { beginDrag(props){ return { id: props.id, index: props.index } } }

const itemTarget = {
	hover(props, monitor, component) {
		const dragIndex = monitor.getItem().index;
		const hoverIndex = props.index;

		if (dragIndex === hoverIndex) {
			return;
		}

		const hoverBoundingRect = findDOMNode(component).getBoundingClientRect();
		const hoverMiddleY = (hoverBoundingRect.bottom - hoverBoundingRect.top) / 2;
		const clientOffset = monitor.getClientOffset();
		const hoverClientY = clientOffset.y - hoverBoundingRect.top;

		if (dragIndex < hoverIndex && hoverClientY < hoverMiddleY) {
		return;
		}

		if (dragIndex > hoverIndex && hoverClientY > hoverMiddleY) {
		return;
		}

		props.fields.swap(dragIndex, hoverIndex);
		monitor.getItem().index = hoverIndex;
	}
};

class RepeatItem extends Component {
	handleItemClick(value){
		const { parentKey, state:{ wppbForm } } = this.props
		this.props.onHandleRowClick( value );
		// if ( value !='none' ) {
		// 	if ( wppbForm.mainForm.addonName == 'accordion' || wppbForm.mainForm.addonName == 'tab' || wppbForm.mainForm.addonName == 'sp_carouselpro' || wppbForm.mainForm.addonName == 'carouselpro' ) {
		// 		if (wppbForm.form == 'mainForm') {
		// 			this.props.setRepeatFields( parentKey, value )
		// 		}
		// 	}
		// }
	}

	RepeatItemClone(index){
		const { fields } = this.props
		let currentFieldVal = __.clone( fields.get(index));
		if ( __.isObject(currentFieldVal.content) ) {
			currentFieldVal.content.filter(function(item){
				item.id = (new Date).getTime()
				return item;
			})
		}
		fields.push(currentFieldVal);
	}

	render(){
		const { index, openRow, element, isDragging, parentKey, flOptions, state, thisFormName, connectDropTarget, connectDragPreview, connectDragSource } = this.props

		let repeatFieldValues = {}
		const dragStyle={ opacity:isDragging?'.5':'1' }

		if ( thisFormName == "wppbForm" ) {
				if (typeof state.form.wppbForm.values[parentKey] !== 'undefined'){
					repeatFieldValues = state.form.wppbForm.values[parentKey][index]
				}
			}else if( thisFormName == "insideAddonForm" ){
				if (typeof state.form.insideAddonForm.values[parentKey] !== 'undefined'){
					repeatFieldValues = state.form.insideAddonForm.values[parentKey][index]
				}
		}
		return connectDragPreview(connectDropTarget(
			<div className={ "wppb-repeatable-field wppb-clearfix "+openRow } style={dragStyle}>
				<div className="wppb-repeatable-field-title">
					{ openRow == 'none' &&
						connectDragSource( <span className="wppb-move-repeat-item"><i className="fa fa-ellipsis-v"/></span> )
					}
					<span className="wppb-repeat-item-title" onClick={ (e) => { this.handleItemClick(index)} }> { ( this.props.fields.get(index)[this.props.flOptions.label] ? this.props.fields.get(index)[this.props.flOptions.label] : ( this.props.flOptions.labelDefault ? this.props.flOptions.labelDefault+' ' : 'Item ' ) + ( this.props.index + 1 ) ) } </span>
					<span className="wppb-repeat-item-action-btns" style={{marginLeft: 'auto'}}>
						{ openRow != index ?
							<span className="wppb-repeatable-field-action-btn">
								<button onClick={ (e) => { this.handleItemClick(index)}} ><i className="fa fa-pencil" /></button>
								<button onClick={ (e) => { this.RepeatItemClone(index)}} ><i className="fa fa-clone" /></button>
								<button className="wppb-repeatable-field-delete-btn" onClick={ (e) => {
									if (!window.confirm("Do you really want to delete this item?")){ return; }
										this.props.onHandleRemoveItemRowClick(index)
									}}><i className="fa fa-trash-o" /></button>
							</span>
							:
							<button className="wppb-repeatable-field-apply" onClick={ (e) => { this.handleItemClick('none')}} ><i className="fa fa-check" /> {page_data.i18n.apply}</button>
						}
					</span>
				</div>
				{ openRow == index &&
					<div className="wppb-repeatable-fields">
					<FieldsRender
						fieldsAttr = { flOptions.attr }
						values = { repeatFieldValues }
						parentKey = { parentKey }
						index = { index }
						element = { element } />
					</div>
				}
				{ openRow == index &&
					<div className="wppb-repeatable-field-footer wppb-text-right">
						<button onClick={ (e) => { this.handleItemClick('none')}} ><i className="fa fa-check" /> {page_data.i18n.apply}</button>
					</div>
				}
			</div>
		))
	}
}

var DragSourceDecorator = DragSource(ItemTypes.FORMREITEM, itemSource,
	function(connect, monitor) {
		return {
			connectDragSource: connect.dragSource(),
			connectDragPreview: connect.dragPreview(),
			isDragging: monitor.isDragging()
		};
	}
);

var DropTargetDecorator = DropTarget(ItemTypes.FORMREITEM, itemTarget,
	function(connect) {
		return { connectDropTarget: connect.dropTarget() };
	}
);

const mapStateToProps = (state) => {
  	return { state };
}

const mapDispatchToProps = ( dispatch ) => {
	return {
		setRepeatFields: ( fieldName, rfieldIndex ) => {
			dispatch( setRepeatFields( fieldName, rfieldIndex ) )
		}
	}
}

export default connect(
	mapStateToProps,
	mapDispatchToProps
)(DropTargetDecorator(DragSourceDecorator(RepeatItem)));