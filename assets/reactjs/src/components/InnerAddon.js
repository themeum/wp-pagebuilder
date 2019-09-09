import React, { Component } from 'react';
import { findDOMNode } from 'react-dom';
import { connect } from 'react-redux'
import { ItemTypes } from './Constants';
import { DragSource, DropTarget } from 'react-dnd';
import AddonSettings from './AddonSettings';
import AddonContent from './AddonContent';
import { saveSetting } from '../actions/index';
import { CssGenerator } from './CssGenerator'
import EditPanelManager from '../helpers/EditPanelManager';

const inenrAddonSource = {
  beginDrag(props){
    EditPanelManager.resetAll();
    return {
      id              : props.id,
      index           : props.index,
      innerRowId      : props.innerRowId,
      innerColId      : props.innerColId,
      rowIndex        : props.rowIndex,
      colIndex        : props.colIndex,
      innerRowIndex   : props.innerRowIndex,
      innerColIndex   : props.innerColIndex,
    }
  }
}

const innerAddonTarget = {

  hover(props, monitor, component) {
    if ( monitor.getItem().id === props.id) {
      return;
    }

    var element = findDOMNode(component);
    const hoverBoundingRect = findDOMNode(component).getBoundingClientRect();
    const hoverMiddleY      = (hoverBoundingRect.bottom - hoverBoundingRect.top) / 2;
    const clientOffset      = monitor.getClientOffset();
    const hoverClientY      = clientOffset.y - hoverBoundingRect.top;

    if(monitor.isOver({ shallow: true })){
      if (hoverClientY < hoverMiddleY) {
        element.classList.remove('bottom-placeholder');
        element.classList.add('top-placeholder');
      }
      if (hoverClientY > hoverMiddleY) {
        element.classList.add('bottom-placeholder');
        element.classList.remove('top-placeholder');
      }
    }
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

    var options = {
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

    if(item.type == 'ADD_ADDON'){
      
      return {
        type: 'inner_addon',
        status: true,
        index: props.index,
        dropPosition: options.dropPosition,
        rowIndex: props.rowIndex,
        colIndex: props.colIndex,
        innerRowIndex: props.innerRowIndex,
        innerColIndex: props.innerColIndex
      };
    }

    if ( typeof item.innerRowIndex === 'undefined') {
      if (item.rowIndex === props.rowIndex && item.colIndex === props.colIndex) {
        options.type = 'ADDON_SORT_INNER_ADDON_COL';
      } else if (item.rowIndex === props.rowIndex && item.colIndex !== props.colIndex){
        options.type = 'ADDON_SORT_INNER_ADDON_ROW';
      } else {
        options.type = 'ADDON_SORT_INNER_ADDON_OUTER_ROW';
      }
    }
    else
    {
      if ( item.innerRowId === props.innerRowId && item.innerColId === props.innerColId ) {
        options.type = 'INNER_ADDON_SORT_INNER_COL';
      } else if ( item.innerRowId === props.innerRowId && item.innerColId !== props.innerColId ) {
        options.type = 'INNER_ADDON_SORT_INNER_ROW';
      } else if ( item.rowIndex === props.rowIndex && item.colIndex === props.colIndex && item.innerRowId !== props.innerRowId ) {
        options.type = 'INNER_ADDON_SORT_OUTER_ROW';
      } else if ( item.rowIndex === props.rowIndex && item.colIndex !== props.colIndex ) {
        options.type = 'INNER_ADDON_SORT_PARENT_ROW';
      } else {
        options.type = 'INNER_ADDON_SORT_PARENT_OUTER_ROW';
      }
    }

    props.innerAddonSort(options);

    if (typeof item.innerRowIndex === 'undefined' && item.rowIndex === props.rowIndex && item.colIndex === props.colIndex) {
      if (monitor.getItem().index < props.innerRowIndex) {
        monitor.getItem().innerRowIndex = (props.innerRowIndex - 1);
      }else{
        monitor.getItem().innerRowIndex = props.innerRowIndex;
      }
    }else{
      monitor.getItem().innerRowIndex = props.innerRowIndex;
    }

    monitor.getItem().index = hoverIndex;
    monitor.getItem().innerRowId    = props.innerRowId;
    monitor.getItem().innerColId    = props.innerColId;
    monitor.getItem().rowIndex      = props.rowIndex;
    monitor.getItem().colIndex      = props.colIndex;
    monitor.getItem().innerColIndex = props.innerColIndex;
  }
};

class InnerAddon extends Component {

	componentDidMount(){
    const { addon, connectDragPreview } = this.props
    connectDragPreview( this.createCustomDragSource() );
    
    if( addon.name ){
			let types = ( addon.type == 'inner_addon' ? 'addon' : addon.type );
			CssGenerator( addon, types , 'setinline' );
		}
	}

	componentDidUpdate(prevProps){
    const { addon, connectDragPreview } = this.props
    connectDragPreview( this.createCustomDragSource() );
    
    // CSS Generator
    if( addon.name && 
      ( !__.isEqual( this.props.addon.settings, prevProps.addon.settings) ||
        !__.isEqual( this.props.addon.id, prevProps.addon.id)
      )
    ){
			let types = ( addon.type == 'inner_addon' ? 'addon' : addon.type );
      CssGenerator( addon, types , 'setinline' );
		}
	}

	createCustomDragSource(){
		let img = new Image();
    img.src = page_data.pagebuilder_base + 'assets/img/addon.png';
		return img
  }
  
  shouldComponentUpdate(nextProps, nextState){
      if( !__.isEqual(nextProps.addon, this.props.addon) ||
          !__.isEqual(nextProps.isDragging, this.props.isDragging) ||
          !__.isEqual(nextProps.isOver, this.props.isOver) ||
          !__.isEqual(nextProps.index, this.props.index) ||
          !__.isEqual(nextProps.colIndex, this.props.colIndex) || 
          !__.isEqual(nextProps.rowIndex, this.props.rowIndex ) ){
            return true;
      }
      return false;
  }

	editOnClickAddon(){
    const { addon, rowIndex, colIndex, index, innerRowIndex, innerColIndex } = this.props;
    
		let editAddon = {
			type: 'inner_addon',
			index: rowIndex,
			settings: {
				colIndex: colIndex,
				addonIndex: innerRowIndex,
				addonId: addon.id,
				htmlContent: addon.htmlContent,
				addonName: addon.name,
				formData: addon.settings,
				innerRowIndex: innerRowIndex,
				innerColIndex: innerColIndex,
				addonInnerIndex: index
			}
    };
    EditPanelManager.resetAll();
		EditPanelManager.setAddon(editAddon);
		EditPanelManager.setType('inner_addon');
		EditPanelManager.showEditPanel();
	}

	render() {
		const { addon, column, isOver, index, rowIndex, colIndex, innerRowIndex, innerColIndex, isDragging, connectDropTarget, connectDragPreview, connectDragSource } = this.props;
		const { settings } = this.props.addon;

		let overClass = [ 'wppb-builder-addon','wppb-addon-' + addon.id ]
		if( isDragging && !isOver ){ overClass.push('wppb-builder-dragging') } // Drag & Drop Class
		if ( isOver && !isDragging ){ overClass.push('wppb-builder-addon-over') }
		if( !addon.visibility ){ overClass.push('wppb-builder-addon-disabled') } // Disable Class
		if( settings.addon_class ){ overClass.push( settings.addon_class ) } // Extra Row Class

		// Animation
		let attribute = { key: addon.id, id:( settings.addon_id ? settings.addon_id : null ) ,  'data-addon-id':addon.id }
		if( typeof settings.addon_animation !== 'undefined' && settings.addon_animation.itemOpen ){
			if( settings.addon_animation.name ){ overClass.push( 'wppb-wow','wppb-animated', settings.addon_animation.name ) }
			if( settings.addon_animation.delay ){ attribute['data-wow-delay'] = settings.addon_animation.delay + 'ms' }
			if( settings.addon_animation.duration ){ attribute['data-wow-duration'] = settings.addon_animation.duration + 'ms' }
		}

		return connectDragPreview(connectDropTarget(
			<div {...attribute} className={overClass.join(' ')}>
				<div className="addon-placeholder-top"></div>
				<div className="wppb-builder-addon-wrap-bordered">
					<div className="wppb-builder-addon-tools">
						<AddonSettings
							addon={addon}
							rowIndex={rowIndex}
							colIndex={colIndex}
							addonIndex={innerRowIndex}
							innerColIndex={innerColIndex}
							addonInnerIndex={index}
							column = { column }
							columnMove = { this.props.columnMove }
							connectDragSource = { connectDragSource } />
					</div>
					<AddonContent addon = { addon } editAddon={this.editOnClickAddon.bind(this)} />
				</div>
				<div className="addon-placeholder-bottom"></div>
			</div>
		))
	}
}

var DragSourceDecorator = DragSource( ItemTypes.INNERADDON, inenrAddonSource,
  function(connect, monitor) {
    return {
      connectDragSource: connect.dragSource(),
      connectDragPreview: connect.dragPreview(),
      isDragging: monitor.isDragging()
    };
  }
);

var DropTargetDecorator = DropTarget( [ ItemTypes.INNERADDON, ItemTypes.ADDON ], innerAddonTarget,
  function(connect,monitor) {
    return {
      connectDropTarget: connect.dropTarget(),
      isOver: monitor.isOver(),
      canDrop: monitor.canDrop()
    };
  }
);

const mapStateToProps = ( state ) => {
  return {
    state: state
  };
}

const mapDispatchToProps = ( dispatch ) => {
  return {
    onSettingsClick: (options) => {
      dispatch(saveSetting(options))
    }
  }
}

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(DropTargetDecorator(DragSourceDecorator(InnerAddon)));
