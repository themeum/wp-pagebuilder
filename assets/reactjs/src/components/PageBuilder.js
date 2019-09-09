import React, { Component } from 'react';
import { findDOMNode } from 'react-dom';
import { connect } from 'react-redux'
import { DropTarget } from 'react-dnd';
import { addRow, rowSortable, addBlock /*, dropAddonsDirect */ } from '../actions/index';
import { ItemTypes } from './Constants';
import Row from './Row';
import withDragDropContext from '../helpers/withDragDropContext';
import AddNewRowButton from './AddNewRowButton';
import {setInternalStyle} from './CssGenerator'

class Pagebuilder extends Component{
	componentDidMount(){
		let commonCss = document.getElementById('wppb-tmpl-common-css').innerHTML;
		if( commonCss ){
			setInternalStyle( commonCss , 'common-css' )
		}
	}

  	render(){
		const page = this.props.state.pageBuilder;
		return(
			<div>
				{ page.present.length ?
					page.present.map( (row, index) => { return ( <Row key={row.id} id={row.id} index={index} moveRow={this.props.rowSortable} colLength={row.columns.length} row={row} /> )} )
					:
					null
				}
				{ this.props.connectDropTarget(
					<div className={ "wppb-builder-blank-page-tools" + ( this.props.isOver ? ' wppb-block-placeholder-show' : '' ) }>
						<AddNewRowButton rows={this.props.state.pageBuilder.present.length}/>
					</div>
				)}
			</div>
		)
	}
}

const mapStateToProps = ( state ) => {
	return {
		state: state
	};
}

const mapDispatchToProps = ( dispatch ) => {
	return {
		addBlockAsRow: ( rowIndex, rowData ) => {
			dispatch(addBlock(rowIndex, rowData))
		},
		rowSortable: ( dragIndex, hoverIndex ) => {
			dispatch(rowSortable(dragIndex,hoverIndex))
		},
		addNewRow: () => {
			dispatch(addRow())
		},
		dropAddonsDirect: ( page ) => {
			dispatch(dropAddonsDirect(page))
		},
	}
}

const rowTarget = {
	hover( props, monitor, component ){
		const dragItem = monitor.getItem();
		if(dragItem.type == 'block'){
			findDOMNode(component).classList.add('wppb-block-can-drag');
		}
	},
	drop( props, monitor, component ){
		const item = monitor.getItem();
		if( item.type == 'block' ){
			props.addBlockAsRow(props.index, item.element.block);
			findDOMNode(component).classList.remove('wppb-block-can-drag');
		}
	}
};

var DropTargetDecorator = DropTarget([ItemTypes.ROW, ItemTypes.BLOCK/*, ItemTypes.ADDON*/ ], rowTarget,
    function(connect, monitor) {
        return {
            connectDropTarget: connect.dropTarget(),
            isOver: monitor.isOver(),
            canDrop: monitor.canDrop()
        };
    }
);

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(withDragDropContext(DropTargetDecorator(Pagebuilder)));
