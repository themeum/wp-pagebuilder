import React, { Component } from 'react'
import { DragSource, DropTarget } from 'react-dnd'
import { colPercent } from '../actions/index'
import ColumnSettings from './ColumnSettings'
import { findDOMNode } from 'react-dom'
import { ItemTypes } from './Constants'
import { connect } from 'react-redux'
import AddonList from './AddonList'
import { ColResizable } from '../helpers/ColResizable'
import { CssGenerator } from './CssGenerator'
import ResponsiveManager from '../helpers/ResponsiveManager';
import { VideoBackground } from '../helpers/VideoBackground'

const columnSource = {
    beginDrag(props){
        return {
            id: props.id,
            index: props.index,
            rowIndex: props.rowIndex
        }
    }
}

const columnTarget = {

    canDrop( props, monitor ){
        if ( monitor.getItem().rowIndex !== props.rowIndex ) {
            return;
        }
        return true;
    },

    hover(props, monitor, component) {
        if (monitor.getItem().rowIndex !== props.rowIndex) {
            return;
        }

        const dragIndex = monitor.getItem().index;
        const hoverIndex = props.index;

        if (dragIndex === hoverIndex) {
            return;
        }

        const hoverBoundingRect = findDOMNode(component).getBoundingClientRect();
        const hoverMiddleY = (hoverBoundingRect.bottom - hoverBoundingRect.top) / 2;
        const clientOffset = monitor.getClientOffset();
        const hoverClientY = clientOffset.y - hoverBoundingRect.top;
    },

    drop( props, monitor ){
        const dragIndex = monitor.getItem().index;
        const hoverIndex = props.index;

        props.columnMove(props.rowIndex, dragIndex, hoverIndex);
        monitor.getItem().index = hoverIndex;
    }
};

class Column extends Component {

    constructor(props) {
        super(props);
        this.state = { move: false, index: this.props.index };
    }

    componentDidMount(){
        this.props.connectDragPreview( this.createCustomDragSource() );
        var thatProps = this.props;
        
        ColResizable();
        jQuery(document).on('wppb_col_resized', function(e, layout, indexOfNodes) {
            if(thatProps.rowIndex == indexOfNodes[0]){
                if( ResponsiveManager.device == 'md' && indexOfNodes.length == 2 ) {
                    thatProps.colPercent( indexOfNodes, layout ); // Node means Row, Column, InnerRow, InnerColumn
                }
            }
        });

        // CSS Generator
        const { index, row, column } = this.props
        let colLayoutArray = String(row.layout).split(','),
            columnWidth = colLayoutArray[index],
            newColumn = _.clone(column);
        
        if (typeof newColumn.settings.col_custom_width !== 'undefined'){
            newColumn.settings.col_custom_width.md = columnWidth;
        }

        CssGenerator( newColumn, 'col', 'setinline' );
    }

    shouldComponentUpdate( nextProps, nextState ) {
        if( __.isEqual( this.props.column, nextProps.column ) ||
            __.isEqual(nextProps.isDragging, this.props.isDragging) ||
            __.isEqual(nextProps.isOver, this.props.isOver) ||
            __.isEqual(nextProps.index, this.props.index) ||
            __.isEqual(nextProps.rowIndex, this.props.rowIndex) ||
            __.isEqual(nextProps.row.layout, this.props.row.layout)
        ) {
            return true;
        }
        return false;
    }

    componentDidUpdate(prevProps){
        const { index, row, column, connectDragPreview } = this.props
        if ( index != this.state.index ) {
            this.setState({ move: false, index: index })
        }
        connectDragPreview( this.createCustomDragSource() );
        
        // CSS Generator
        if( !__.isEqual( this.props.column.settings, prevProps.column.settings ) ||
            !__.isEqual( this.props.column.id, prevProps.column.id ) ||
            !__.isEqual( this.props.index, prevProps.index ) ||
            !__.isEqual( this.props.row.layout, prevProps.row.layout)
        ){
            let colLayoutArray = String(row.layout).split(','),
                columnWidth = colLayoutArray[index],
                newColumn = _.clone(column);

            if (typeof newColumn.settings.col_custom_width !== 'undefined'){
                newColumn.settings.col_custom_width.md = columnWidth;
            }

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
        const { column, row, rowIndex, isOver, index, isDragging, connectDropTarget, connectDragPreview, connectDragSource, isOverCurrent } = this.props;
        const { settings } = column;

        let overClass = [ 'wppb-column-parent wppb-column-parent-editor', 'wppb-col-'+column.id ]

        if( isDragging && !isOver ){ overClass.push('wppb-builder-col-drag') }
        if( !column.visibility ){ overClass.push('wppb-builder-col-disable') }
        if( settings.col_class ){ overClass.push(settings.col_class) }
        if( isOverCurrent ){ overClass.push('wppb-builder-show-placeholder') }

        if(index < (row.columns.length -1 )){
            overClass.push('ui-resizable')
        }
        
        // Animation
		let attribute = { key:column.id, id:( settings.col_id ? settings.col_id : null ), 'data-col-index':index };
		if( typeof settings.col_animation !== 'undefined' && settings.col_animation.itemOpen ){
			if( settings.col_animation.name ){ overClass.push( 'wppb-wow', 'wppb-animated', settings.col_animation.name ) }
			if( settings.col_animation.delay ){ attribute['data-wow-delay'] = settings.col_animation.delay + 'ms' }
			if( settings.col_animation.duration ){ attribute['data-wow-duration'] = settings.col_animation.duration + 'ms' }
        }

        return connectDragPreview( connectDropTarget(
            <div {...attribute} className={overClass.join(' ')}>
                <div style={{ width: '100%', paddingLeft : '0px', paddingRight: '0px' }}>
                    { this.state.move &&
                        <div className="wppb-builder-column-drag-movable">
                            <span className="close-column-movable" onClick={() => { this.setState({ move:false }) }} ><i className="fa fa-close"/></span>
                            <div className="wppb-builder-column-drag">
                                { connectDragSource(<div className="wppb-builder-drag-column"><i className="wppb-font-arrows"/></div>) }
                            </div>
                        </div>
                    }

                    { settings && settings['col_background'] &&
                        VideoBackground(settings, 'col')
                    }

                    <div className={ 'wppb-column' + ( __.isEmpty( column.addons ) ? ' wppb-col-empty' : '' ) }>
                        <div className="wppb-builder-column-tools">
                            <ColumnSettings 
                                rowIndex = { rowIndex } 
                                colIndex = { index } 
                                column = { column }
                                row = { row }
                                colLength = { this.props.colLength }
                                columnMove = { this._activeMoveButton.bind(this) } 
                                connectDragSource = { connectDragSource } />
                        </div>
                        <AddonList 
                            key={ column.id } 
                            column={ column } 
                            addons={ column.addons } 
                            rowIndex={ rowIndex } 
                            colIndex={ index } 
                            dropAddon={ this.props.dropAddon } 
                            moveButton={ this._activeMoveButton.bind(this)} />
                    </div>
                    { index < (row.columns.length -1 ) &&
                        <div className={'wppb-col-resize-handler'}>
                            <div className={'resizeDot'}></div>
                            <div className={'resizeDot'}></div>
                        </div>
                    }
                </div>
            </div>
        ))
    }
}


let DragSourceDecorator = DragSource(ItemTypes.COLUMN, columnSource,
    function(connect, monitor) {
        return {
            connectDragSource: connect.dragSource(),
            connectDragPreview: connect.dragPreview(),
            isDragging: monitor.isDragging()
        };
    }
);

let DropTargetDecorator = DropTarget(ItemTypes.COLUMN, columnTarget,
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
        dropAddon: (options) => {
            dispatch(options);
        },
        colPercent: ( indexOfNodes, layout ) => {
            dispatch(colPercent( indexOfNodes, layout)) // Node means Row, Column, InnerRow, InnerColumn
        }
    }
}

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(DropTargetDecorator(DragSourceDecorator(Column)));