import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux'
import { ItemTypes } from './Constants';
import { DropTarget } from 'react-dnd';
import InnerAddon from './InnerAddon';
import { saveSetting } from '../actions/index';
import EditPanelManager from '../helpers/EditPanelManager';

const innerAddonListTarget = {
  drop(props, monitor, component) {
    const item          = monitor.getItem();

    if(item.type == 'ADD_ADDON' && monitor.isOver({ shallow: true })){
      return {
        type: 'inner_addon',
        status: true,
        index: 0,
        dropPosition: 'top',
        rowIndex: props.rowIndex,
        colIndex: props.colIndex,
        innerRowIndex: props.innerRowIndex,
        innerColIndex: props.innerColIndex
      };
    } else if(monitor.isOver({ shallow: true })){
      const dragIndex     = item.index;
      const hoverIndex    = props.index;

      if (item.innerColId === props.innerColId){
        return;
      }

      var options = {
        drag        : item,
        dragIndex   : dragIndex,
        drop        : props,
        hoverIndex  : hoverIndex
      };

      if (typeof item.innerRowIndex === 'undefined') {
        if (item.rowIndex === props.rowIndex && item.colIndex === props.colIndex) {
          options.type = 'ADDON_SORT_INNER_ADDON_COL';
        }else if(item.rowIndex === props.rowIndex && item.colIndex !== props.colIndex){
          options.type = 'ADDON_SORT_INNER_ADDON_ROW';
        }else{
          options.type = 'ADDON_SORT_INNER_ADDON_OUTER_ROW';
        }
      } else {
        if ( item.innerRowId === props.innerRowId && item.innerColId !== props.innerColId ) {
          options.type = 'INNER_ADDON_SORT_INNER_ROW';
        } else if ( item.rowIndex === props.rowIndex && item.colIndex === props.colIndex && item.innerRowId !== props.innerRowId ) {
          options.type = 'INNER_ADDON_SORT_OUTER_ROW';
        } else if ( item.rowIndex === props.rowIndex && item.colIndex !== props.colIndex ) {
          options.type = 'INNER_ADDON_SORT_PARENT_ROW';
        } else {
          options.type = 'INNER_ADDON_SORT_PARENT_OUTER_ROW';
        }
      }

      props.dropInnerAddon(options);

      if (typeof item.innerRowIndex === 'undefined' && item.rowIndex === props.rowIndex && item.colIndex === props.colIndex) {
        if (monitor.getItem().index < props.innerRowIndex) {
          monitor.getItem().innerRowIndex = (props.innerRowIndex - 1);
        }else{
          monitor.getItem().innerRowIndex = props.innerRowIndex;
        }
      }else{
        monitor.getItem().innerRowIndex = props.innerRowIndex;
      }

      monitor.getItem().index         = 0;
      monitor.getItem().innerRowId    = props.innerRowId;
      monitor.getItem().innerColId    = props.innerColId;
      monitor.getItem().rowIndex      = props.rowIndex;
      monitor.getItem().colIndex      = props.colIndex;
      monitor.getItem().innerColIndex = props.innerColIndex;
    }
    
  }
};

class InnerAddonList extends Component {
	render() {
		const { addons, column, rowIndex, colIndex, innerRowId, innerColId, innerRowIndex, innerColIndex, connectDropTarget, isOverCurrent } = this.props;

		var addonsClass = "wppb-builder-addons";
		if(!addons.length) { addonsClass = addonsClass + ' wppb-builder-no-addons'; }
    if(isOverCurrent){ addonsClass = addonsClass + ' wppb-builder-show-placeholder'; }

		return connectDropTarget(
			<div className={addonsClass}>
				{ !(addons.length > 0) &&
					<div className="addon-placeholder-top"></div>
        }

				{ addons.length > 0 ?
				addons.map(
					( addon, index) =>
					<InnerAddon
					key = {addon.id}
					id = {addon.id}
					addon = {addon}
					column = { column }
					index = {index}
					innerRowId = {innerRowId}
					innerColId = {innerColId}
					rowIndex = {rowIndex}
					colIndex = {colIndex}
					innerRowIndex = {innerRowIndex}
					innerColIndex = {innerColIndex}
					innerAddonSort = {this.props.addonInnerSortable}
					columnMove = { this.props.moveButton } />
				)
				:
				<div className="wppb-builder-add-addon-empty"><div className="wppb-builder-add-addon-wrap" onClick={e => { EditPanelManager.resetAll();}}><i className="wppb-font-add-alt"/></div></div>
				}
			</div>
		)
	}
}

var DropTargetDecorator = DropTarget( [ ItemTypes.ADDON, ItemTypes.INNERADDON ], innerAddonListTarget,
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
  return {
    state: state
  };
}

const mapDispatchToProps = ( dispatch ) => {
  return {
    addonInnerSortable: (options) => {
      dispatch(options)
    },
    onSettingsClick: (options) => {
      dispatch(saveSetting(options))
    }
  }
}

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(DropTargetDecorator(InnerAddonList));
