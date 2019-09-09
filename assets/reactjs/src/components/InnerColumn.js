import React, { Component } from 'react'
import { findDOMNode } from 'react-dom'
import { connect } from 'react-redux'
import { ItemTypes } from './Constants'
import { DragSource, DropTarget } from 'react-dnd'
import { colPercent } from '../actions/index'
import ColumnSettings from './ColumnSettings'
import InnerAddonList from './InnerAddonList'
import { ColResizable } from '../helpers/ColResizable'
import ResponsiveManager from '../helpers/ResponsiveManager';
import { CssGenerator } from './CssGenerator'

const innerColumnSource = {
	beginDrag(props){
		return {
			id          : props.id,
			index       : props.index,
			innerRowId  : props.innerRowId,
			rowIndex    : props.rowIndex,
			colIndex    : props.colIndex,
			addonIndex  : props.addonIndex
		}
	}
}

const innerColumnTarget = {
	canDrop( props, monitor ) {
		if ( monitor.getItem().innerRowId !== props.innerRowId ) {
			return;
		}
		return true;
	},

	hover(props, monitor, component) {
		if (monitor.getItem().innerRowId !== props.innerRowId) {
			return;
		}

		const dragIndex 	= monitor.getItem().index;
		const hoverIndex 	= props.index;

		if (dragIndex === hoverIndex) {
			return;
		}

		const hoverBoundingRect = findDOMNode(component).getBoundingClientRect();
		const hoverMiddleY 		= (hoverBoundingRect.bottom - hoverBoundingRect.top) / 2;
		const clientOffset 		= monitor.getClientOffset();
		const hoverClientY 		= clientOffset.y - hoverBoundingRect.top;
		if (dragIndex < hoverIndex && hoverClientY < hoverMiddleY) {
			return;
		}

		if (dragIndex > hoverIndex && hoverClientY > hoverMiddleY) {
			return;
		}
	},

	drop( props, monitor ) {
		const dragIndex = monitor.getItem().index;
		const hoverIndex = props.index;
		
		props.innerColumnMove(props.rowIndex, props.colIndex, props.addonIndex, dragIndex, hoverIndex);
		monitor.getItem().index = hoverIndex;
	}
};

class InnerColumn extends Component {
	constructor(props) {
		super(props);
		this.state = { move: false, index: this.props.index };
	}

	componentDidMount(){
		this.props.connectDragPreview( this.createCustomDragSource() );
		
		var thatProps = this.props;
        ColResizable();
        jQuery(document).on('wppb_col_resized', function( e, layout, indexOfNodes ) {
			if(ResponsiveManager.device == 'md' && indexOfNodes.length == 4) {
				thatProps.colPercent( indexOfNodes, layout ); // Node means Row, Column, InnerRow, InnerColumn
			}
		});

		// CSS Generator
		const { index, innerRow, column } = this.props
		let colLayoutArray = String(innerRow.layout).split(','),
			columnWidth = colLayoutArray[index],
			newColumn = _.clone(column);
		newColumn.settings.col_custom_width.md = columnWidth;

		CssGenerator( newColumn, 'col', 'setinline' );
	}

	shouldComponentUpdate( nextProps, nextState ) {
        if( !__.isEqual( this.props.column, nextProps.column ) || 
			!__.isEqual( nextProps.isDragging, this.props.isDragging ) ||
			!__.isEqual( nextProps.isOver, this.props.isOver ) ||
			!__.isEqual( nextProps.index, this.props.index ) ||
			!__.isEqual( nextProps.colIndex, this.props.colIndex) || 
			!__.isEqual( nextProps.innerRow.layout, this.props.innerRow.layout ) ||
			!__.isEqual( nextProps.rowIndex, this.props.rowIndex ) ) {
            	return true;
		}
        return false;
    }

	componentDidUpdate(prevProps){
		const { index, innerRow, column } = this.props
		if ( index != this.state.index ){
			this.setState({ move: false, index: index })
		}
		this.props.connectDragPreview( this.createCustomDragSource() );

		if( !__.isEqual( this.props.column.settings, prevProps.column.settings ) ||
			!__.isEqual( this.props.column.id, prevProps.column.id ) ||
			!__.isEqual( this.props.index, prevProps.index ) ||
			!__.isEqual( this.props.innerRow.layout, prevProps.innerRow.layout )
		) {
			let colLayoutArray = String(innerRow.layout).split(','),
				columnWidth = colLayoutArray[index],
				newColumn = _.clone(column);
			newColumn.settings.col_custom_width.md = columnWidth;

			CssGenerator( newColumn, 'col', 'setinline' );

			ColResizable();
		}
	}

	createCustomDragSource(){
		let img = new Image();
		img.src = page_data.pagebuilder_base + 'assets/img/column.png';
		return img
	}

	_activeMoveButton(move){
		this.setState({ move: move });
	}

	render() {
		const { rowIndex, innerRow, colIndex, addonIndex, innerRowId, index, column, isOver, isDragging, connectDropTarget, connectDragPreview, connectDragSource,isOverCurrent } = this.props;
		const { settings } = column;

		let overClass = [ 'wppb-column-parent wppb-column-parent-editor', 'wppb-col-'+column.id ]
		if( isDragging && !isOver ){ overClass.push('wppb-builder-col-drag') } // Drag & Drop Class
		if( !column.visibility ){ overClass.push('wppb-builder-col-disable') } // Disable Class
		if( settings.col_class ){ overClass.push(settings.col_class) } // Extra Row Class
		if( isOverCurrent ){ overClass.push('wppb-builder-show-placeholder') } // Row when Draging

		if(index < (innerRow.columns.length -1 )){
            overClass.push('ui-resizable')
        }

		// Animation
		let attribute = { key:column.id, id:( settings.col_id ? settings.col_id : null ), 'data-col-index': index }
		if( typeof settings.col_animation !== 'undefined' && settings.col_animation.itemOpen ){
			if( settings.col_animation.name ){ overClass.push( 'wppb-wow', 'wppb-animated', settings.col_animation.name ) }
			if( settings.col_animation.delay ){ attribute['data-wow-delay'] = settings.col_animation.delay + 'ms' }
			if( settings.col_animation.duration ){ attribute['data-wow-duration'] = settings.col_animation.duration + 'ms' }
		}
		
		return connectDragPreview(connectDropTarget(
			<div {...attribute} className={overClass.join(' ')}>
				{ this.state.move &&
					<div className="wppb-builder-column-drag-movable">
						<span className="close-column-movable" onClick={() => { this.setState({ move:false }) }} ><i className="fa fa-close"/></span>
						<div className="wppb-builder-column-drag">
							{ connectDragSource(<div className="wppb-builder-drag-column"><i className="wppb-font-arrows"/></div>) }
						</div>
					</div>
				}
				<div className={'wppb-column' + ( __.isEmpty( column.addons ) ? ' wppb-col-empty' : '' )}>
					<div className="wppb-builder-column-tools">
						<ColumnSettings 
							rowIndex = { rowIndex }
							colIndex = { colIndex }
							innerColIndex = { index }
							innerRow = { innerRow }
							addonIndex = { addonIndex }
							column = { column }
							innerColLength = { this.props.innerColLength }
							columnMove = { this._activeMoveButton.bind(this) }
							connectDragSource = { connectDragSource }/>
					</div>
					<InnerAddonList
						key={ column.id }
						innerRowId={ innerRowId }
						innerColId={ column.id }
						rowIndex={ rowIndex }
						colIndex={ colIndex }
						innerRowIndex={ addonIndex }
						innerColIndex={ index }
						column={ column }
						addons={ column.addons }
						dropInnerAddon = {this.props.dropInnerAddon}
						moveButton={ this._activeMoveButton.bind(this)} />
				</div>
				{ index < (innerRow.columns.length -1 ) &&
					<div className={'wppb-col-resize-handler'}>
						<div className={'resizeDot'}></div>
						<div className={'resizeDot'}></div>
					</div>
				}
			</div>
		))
	}
}

let DragSourceDecorator = DragSource( ItemTypes.INNERCOLUMN, innerColumnSource,
	function(connect, monitor) {
		return {
			connectDragSource: connect.dragSource(),
			connectDragPreview: connect.dragPreview(),
			isDragging: monitor.isDragging()
		};
	}
);

let DropTargetDecorator = DropTarget( ItemTypes.INNERCOLUMN, innerColumnTarget,
	function( connect, monitor) {
		return {
			connectDropTarget: connect.dropTarget(),
			isOver: monitor.isOver(),
			canDrop: monitor.canDrop()
		};
	}
);

const mapStateToProps = ( state ) => {
	return { state: state };
}

const mapDispatchToProps = ( dispatch ) => {
	return {
		dropInnerAddon: (options) => {
			dispatch(options)
		},
		colPercent: ( indexOfNodes, layout ) => {
            dispatch(colPercent( indexOfNodes, layout ))
        }
	}
}

export default connect(
	mapStateToProps,
	mapDispatchToProps
)(DropTargetDecorator(DragSourceDecorator(InnerColumn)));
