import React, { Component, PropTypes } from 'react';
import { findDOMNode } from 'react-dom';
import { connect } from 'react-redux'
import { ItemTypes } from './Constants';
import { DragSource, DropTarget } from 'react-dnd';
import RowSettings from './RowSettings';
import InnerColumn from './InnerColumn';
import { changeInnerColumn, innerColumnSortable, saveSetting } from '../actions/index';
import { CssGenerator } from './CssGenerator'
import { VideoBackground } from '../helpers/VideoBackground'
import ResponsiveManager from '../helpers/ResponsiveManager';
import PaddingController from './PaddingController';

const innerRowSource = {
	beginDrag(props){
		return {
			id: props.id,
			index: props.index,
			rowIndex: props.rowIndex,
			colIndex: props.colIndex
		}
	}
}

const innerRowTarget = {
	hover(props, monitor, component) {
		const item          = monitor.getItem();
		const dragIndex     = item.index;
		const hoverIndex    = props.index;

		if ( monitor.getItem().id === props.id) {
			return;
		}

		let elementId 			= findDOMNode(component).getAttribute('id');
		const hoverBoundingRect = findDOMNode(component).getBoundingClientRect();
		const hoverMiddleY      = (hoverBoundingRect.bottom - hoverBoundingRect.top) / 2;
		const clientOffset      = monitor.getClientOffset();
		const hoverClientY      = clientOffset.y - hoverBoundingRect.top;
		jQuery('#'+elementId).addClass('inner-row-placeholder');
	},

	drop(props, monitor, component) {
		const item          = monitor.getItem();
		const dragIndex     = item.index;
		const hoverIndex    = props.index;

		if ( monitor.getItem().id === props.id) {
			return;
		}

		const hoverBoundingRect = findDOMNode(component).getBoundingClientRect();
		const hoverMiddleY      = (hoverBoundingRect.bottom - hoverBoundingRect.top) / 2;
		const clientOffset      = monitor.getClientOffset();
		const hoverClientY      = clientOffset.y - hoverBoundingRect.top;

		let options = {
			drag        : item,
			dragIndex   : dragIndex,
			drop        : props,
			hoverIndex  : hoverIndex
		};

		if (hoverClientY < hoverMiddleY) {
			options.dropPosition = 'top';
		}

		if (hoverClientY > hoverMiddleY) {
			options.dropPosition = 'bottom';
		}

		if (typeof item.innerRowIndex === 'undefined') {
			if (item.rowIndex === props.rowIndex && item.colIndex === props.colIndex) {
				options.type = 'ADDON_SORT_COL_INNER';
			} else if (item.rowIndex === props.rowIndex && item.colIndex !== props.colIndex){
				options.type = 'ADDON_SORT_COL';
			} else {
				options.type = 'ADDON_SORT_OUTER_ROW';
			}
		} else {
			if (item.rowIndex === props.rowIndex && item.colIndex === props.colIndex){
				options.type = 'ADDON_SORT_PARENT_COL_INNER';
			} else if (item.rowIndex === props.rowIndex && item.colIndex !== props.colIndex){
				options.type = 'ADDON_SORT_PARENT_COL';
			} else {
				options.type = 'ADDON_SORT_PARENT_OUTER_ROW';
			}
		}
		props.addonSort(options);
		monitor.getItem().index         = hoverIndex;
		monitor.getItem().innerRowId    = props.innerRowId;
		monitor.getItem().innerColId    = props.innerColId;
		monitor.getItem().rowIndex      = props.rowIndex;
		monitor.getItem().colIndex      = props.colIndex;
		monitor.getItem().innerRowIndex = props.innerRowIndex;
		monitor.getItem().innerColIndex = props.innerColIndex;
	}
};

class InnerRow extends Component {

	componentDidMount(){
		const { data, connectDragPreview } = this.props
		connectDragPreview( this.createCustomDragSource() );

		// CSS Generator
		CssGenerator( data, 'row', 'setinline' );
	}

	shouldComponentUpdate(nextProps, nextState){
        if( !__.isEqual(nextProps.data, this.props.data) ||
            !__.isEqual(nextProps.isDragging, this.props.isDragging) ||
			!__.isEqual(nextProps.isOver, this.props.isOver) ||
			!__.isEqual(nextProps.colIndex, this.props.colIndex) ||
			!__.isEqual(nextProps.index, this.props.index) ||
			!__.isEqual(nextProps.rowIndex, this.props.rowIndex) ||
			!__.isEqual(nextProps.colIndex, this.props.colIndex) ) {
            return true;
		}
        return false;
    }

	componentDidUpdate(prevProps){
		const { data, connectDragPreview } = this.props
		connectDragPreview( this.createCustomDragSource() );

		// CSS Generator
		if( !__.isEqual( this.props.data.settings, prevProps.data.settings ) ||
			!__.isEqual( this.props.data.id, prevProps.data.id ) ||
			!__.isEqual( this.props.data.layout, prevProps.data.layout )
		) {
			CssGenerator( data, 'row', 'setinline' );
		}
	}

	createCustomDragSource(){
		let img = new Image();
		img.src = page_data.pagebuilder_base + 'assets/img/addon.png';
		return img
	}

	_updateRowPadding() {
        let { data, colIndex, index } = this.props
    	this.props.updateInnerRowPadding(index, colIndex, data.settings)
    }

    _onDragOverActionUpdatePadding(padding) {
		let { data } = this.props
        if (typeof data.settings.row_padding !== 'undefined'){ 
            data.settings.row_padding[ResponsiveManager.device] = padding
        }
        this.setState({ v: Math.random() })
    }


	render() {
		const { data, rowIndex, isOver, colIndex, index, isDragging, connectDragPreview, connectDragSource, isOverCurrent } = this.props;
		const { settings } = data;
	
		let overClass = [ 'wppb-row-parent', 'wppb-inner-row-parent', 'wppb-row-'+data.id ]
		if( isDragging && !isOver ){ overClass.push( 'wppb-builder-row-drag' ) } // Drag & Drop Class
		if( !data.visibility ){ overClass.push( 'wppb-builder-row-disable' ) } // Disable Class
		if( settings && settings.row_class ){ overClass.push( settings.row_class ) } // Extra Row Class
		if( isOverCurrent ){ overClass.push( 'wppb-builder-show-placeholder' ) } // Row when Draging

		// Animation
		let attribute = { key:data.id, id:( (settings && settings.row_id) ? settings.row_id : null ), 'data-row-index':index };
		if( settings && typeof settings.row_animation !== 'undefined' && settings.row_animation.itemOpen ){
			if( settings.row_animation.name ){ overClass.push( 'wppb-wow', 'wppb-animated', settings.row_animation.name ) }
			if( settings.row_animation.delay ){ attribute['data-wow-delay'] = settings.row_animation.delay + 'ms' }
			if( settings.row_animation.duration ){ attribute['data-wow-duration'] = settings.row_animation.duration + 'ms' }
		}

		return connectDragPreview(
			<div {...attribute} className={overClass.join(' ')}>
				<div className="wppb-builder-row-tools">
					{ connectDragSource( <span title={page_data.i18n.drag_inner_row} className="wppb-builder-drag-row"><i className="wppb-font-arrows"/></span> )}
					<RowSettings
						row={data}
						index={rowIndex}
						colIndex={colIndex}
						innerRowIndex={index}/>
				</div>
				<PaddingController 
					paddingObj={settings.row_padding}
					row={data}
					rowIndex={rowIndex}
					colIndex={colIndex}
					addonIndex={index}
				/>
				{ settings && settings['row_background'] &&
					VideoBackground(settings,'row')
				}
				<div className="wppb-container">
					<div className="wppb-row">
						{ (settings && settings.overlay) &&
							<div className="wppb-row-overlay" style={ ( row.settings.overlay ? { backgroundColor: row.settings.overlay } : '' ) }></div>
						}
						{ data.columns.map( (column, ind ) =>
							{ return(
								<InnerColumn 
									key={column.id}
									id = {column.id}
									index = { ind }
									innerRow = { data }
									column = {column}
									rowIndex = {rowIndex}
									colIndex = {colIndex}
									addonIndex = {index}
									innerRowId = {data.id}
									innerColumnMove = {this.props.innerColumnSortable}
									innerColLength = {data.columns.length}/> 
							)}
						)}
					</div>
				</div>
			</div>
		)
	}
}

let DragSourceDecorator = DragSource( ItemTypes.INNERROW, innerRowSource,
	function(connect, monitor) {
		return {
			connectDragSource: connect.dragSource(),
			connectDragPreview: connect.dragPreview(),
			isDragging: monitor.isDragging()
		};
	}
);

let DropTargetDecorator = DropTarget( [ ItemTypes.ADDON, ItemTypes.INNERROW, ItemTypes.INNERADDON ], innerRowTarget,
	function(connect,monitor) {
		return {
			connectDropTarget: connect.dropTarget(),
			isOver: monitor.isOver(),
			canDrop: monitor.canDrop()
		};
	}
);

const mapStateToProps = ( state ) => {
  	return {};
}

const mapDispatchToProps = ( dispatch ) => {
	return {
		innerColumnSortable: ( rowIndex, colIndex, addonIndex, dragIndex, hoverIndex ) => {
			dispatch(innerColumnSortable(rowIndex, colIndex, addonIndex, dragIndex, hoverIndex))
		},
		changeInnerColumnGen: ( colLayout, current, rowIndex, colIndex, innerRowIndex ) => {
			dispatch(changeInnerColumn( colLayout, current, rowIndex, colIndex, innerRowIndex ))
		},
		updateInnerRowPadding : (addonIndex, colIndex, settings) => {
			let option = {type:'inner_row', settings: { formData: settings, colIndex: colIndex, addonIndex: addonIndex } }
			dispatch(saveSetting(option))
		}
	}
}

export default connect(
	mapStateToProps,
	mapDispatchToProps
)(DropTargetDecorator(DragSourceDecorator(InnerRow)));