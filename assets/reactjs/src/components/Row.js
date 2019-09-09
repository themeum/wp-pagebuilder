import React, { Component } from 'react';
import { findDOMNode } from 'react-dom';
import { connect } from 'react-redux'
import { ItemTypes } from './Constants';
import { DragSource, DropTarget } from 'react-dnd';
import RowSettings from './RowSettings';
import Column from './Column';
import { changeColumn, columnSortable, toggleCollapse, addBlock, saveSetting } from '../actions/index';
import AddNewRowButton from './AddNewRowButton'
import { CssGenerator } from './CssGenerator'
import { VideoBackground } from '../helpers/VideoBackground'
import PaddingController from './PaddingController';


const rowSource = {
    beginDrag(props) {
        return {
            id: props.id,
            index: props.index
        }
    }
}

const rowTarget = {
    hover(props, monitor, component) {
        const dragItem = monitor.getItem();
        const dragIndex = dragItem.index;
        const hoverIndex = props.index;

        if (dragIndex === hoverIndex) {
            return;
        }

        const element = findDOMNode(component);
        const hoverBoundingRect = element.getBoundingClientRect();
        const hoverMiddleY = (hoverBoundingRect.bottom - hoverBoundingRect.top) / 2;
        const clientOffset = monitor.getClientOffset();
        const hoverClientY = clientOffset.y - hoverBoundingRect.top;

        if (dragIndex < hoverIndex && hoverClientY < hoverMiddleY) {
            return;
        }

        if (dragIndex > hoverIndex && hoverClientY > hoverMiddleY) {
            return;
        }

        if (dragItem.type == 'block') {

        } else {
            props.moveRow(dragIndex, hoverIndex);
            monitor.getItem().index = hoverIndex;
        }

        if (monitor.isOver({ shallow: true })) {
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
        const item = monitor.getItem();

        if (item.type == 'block') {
            const hoverBoundingRect = findDOMNode(component).getBoundingClientRect();
            const hoverMiddleY = (hoverBoundingRect.bottom - hoverBoundingRect.top) / 2;
            const clientOffset = monitor.getClientOffset();
            const hoverClientY = clientOffset.y - hoverBoundingRect.top;

            let index = props.index;

            if (hoverClientY > hoverMiddleY) {
                index = index + 1;
            }

            props.addBlockAsRow(index, item.element.block);

            findDOMNode(component).classList.remove('wppb-block-bottom-placeholder');
            findDOMNode(component).classList.remove('wppb-block-top-placeholder');
        }
    }
};

class Row extends Component {

    shouldComponentUpdate(nextProps, nextState) {
        if(
            __.isEqual(nextProps.row, this.props.row) &&
            __.isEqual(nextProps.id, this.props.id) &&
            __.isEqual(nextProps.index, this.props.index) &&
            __.isEqual(nextProps.isDragging, this.props.isDragging) &&
            __.isEqual(nextProps.isOver, this.props.isOver) &&
            __.isEqual(nextProps.isOverCurrent, this.props.isOverCurrent)) {
            return false;
        }
        return true;
    }

    createCustomDragSource() {
        let img = new Image();
        img.src = page_data.pagebuilder_base + 'assets/img/row.png';
        return img
    }

    componentDidMount() {
        const { row, connectDragPreview } = this.props
        connectDragPreview(this.createCustomDragSource());
        CssGenerator(row, 'row', 'setinline');
    }

    componentDidUpdate(prevProps) {
        const { row, connectDragPreview } = this.props

        connectDragPreview(this.createCustomDragSource());

        // CSS Generator
        if( !__.isEqual( this.props.row.settings, prevProps.row.settings ) ||
            !__.isEqual( this.props.row.layout, prevProps.row.layout ) ||
            !__.isEqual( this.props.id, prevProps.id ) ) {
            CssGenerator(row, 'row', 'setinline');
        }
    }

    render() {
        const { id, row, index, isOver, canDrop, isDragging, connectDropTarget, connectDragPreview, connectDragSource, isOverCurrent } = this.props;
        const rowIndex = index;
        const { settings } = row;

        let overClass = [ 'wppb-row-parent' ];
        if(isDragging && !isOver){ overClass.push( 'wppb-builder-row-drag' ) } // Drag & Drop Class
        if(!row.visibility){ overClass.push( 'wppb-builder-row-disable' ) } // Disable Class
        if(settings && settings.row_class){ overClass.push( settings.row_class ) } // Extra Row Class

        // Animation
        let attribute = { key:id, id:(settings && settings.row_id ? settings.row_id : null), 'data-row-index':index }
        if (settings && typeof settings.row_animation !== 'undefined' && settings.row_animation.itemOpen){
            if (settings.row_animation.name){ overClass.push( 'wppb-wow', 'wppb-animated', settings.row_animation.name ) }
            if (settings.row_animation.delay){ attribute['data-wow-delay'] = settings.row_animation.delay + 'ms' }
            if (settings.row_animation.duration){ attribute['data-wow-duration'] = settings.row_animation.duration + 'ms' }
        }

        let rowContainer = ['wppb-container']
        if (settings && settings.row_screen && settings.row_screen == 'row-container-stretch') { rowContainer.push( 'wppb-container-full' ) }
        if (settings && settings.row_screen && settings.row_screen == 'container-stretch-no-gutter') { rowContainer.push( 'wppb-container-full', 'wppb-contaner-no-gutter' ) }
        if (!settings || settings.row_screen === 'row-default') {
            rowContainer.push( 'wppb-container-row-default wppb-row-'+row.id )
        } else {
            overClass.push( 'wppb-row-'+row.id )
        }


        let shapeName = ((settings && settings['row_shape']) ? settings.row_shape.shapeStyle : '')
        let shapeNameBottom = ((settings && settings['row_shape_bottom']) ? settings.row_shape_bottom.shapeStyle : '')
        
        return connectDragPreview(connectDropTarget(
            <div className={ 'wppb-row-placeholder' + ( isOverCurrent ? ' wppb-builder-show-placeholder' : '' ) }>
                <div className="addon-placeholder-top"></div>
                <div {...attribute} className={overClass.join(' ')}>
                    <div className="wppb-builder-row-tools">
                        {connectDragSource(<span title="Drag Row" className="wppb-builder-drag-row"><i className="wppb-font-arrows"></i></span>)}
                        <RowSettings row={row} index={index} />
                    </div>
                    { settings && settings['row_background'] &&
                        VideoBackground(settings, 'row')
                    }
                    { (settings && settings['row_shape'] && settings['row_shape'].itemOpenShape == 1 && settings.row_screen != 'row-default') &&
                        <div className="wppb-shape-container wppb-top-shape" dangerouslySetInnerHTML={{ __html: atob(page_data.SvgShape[shapeName]) }} />
                    }
                    { (settings && settings['row_shape_bottom'] && settings['row_shape_bottom'].itemOpenShape == 1 && settings.row_screen != 'row-default') &&
                        <div className="wppb-shape-container wppb-bottom-shape" dangerouslySetInnerHTML={{ __html: atob(page_data.SvgShape[shapeNameBottom]) }} />
                    }
                    <div className={rowContainer.join(' ')}>
                        { (settings && settings['row_shape'] && settings['row_shape'].itemOpenShape == 1 && settings.row_screen == 'row-default') &&
                            <div className="wppb-shape-container wppb-top-shape" dangerouslySetInnerHTML={{ __html: atob(page_data.SvgShape[shapeName]) }} />
                        }
                        { (settings && settings['row_shape_bottom'] && settings['row_shape_bottom'].itemOpenShape == 1 && settings.row_screen == 'row-default') &&
                            <div className="wppb-shape-container wppb-bottom-shape" dangerouslySetInnerHTML={{ __html: atob(page_data.SvgShape[shapeNameBottom]) }} />
                        }
                        <div className="wppb-row">
                            { settings && settings.overlay &&
                                <div className="wppb-row-overlay" style={(settings.overlay ? { backgroundColor: settings.overlay } : '')}></div>
                            }
                            { row.columns.map((column, index) => {
                                return ( <Column colLength={this.props.colLength} key={column.id} row={row} id={column.id} column={column} rowIndex={rowIndex} index={index} colLength={row.columns.length} columnMove={this.props.columnSortable} /> )})
                            }
                        </div>
                    </div>
                    <AddNewRowButton single={'true'} rows={index}/>
                    <PaddingController
                        paddingObj={row.settings.row_padding}
                        row={row}
                        rowIndex={index}
                    />
                </div>
                <div className="addon-placeholder-bottom"></div>
            </div>
        ))
    }
}

let DragSourceDecorator = DragSource(ItemTypes.ROW, rowSource,
    function (connect, monitor) {
        return {
            connectDragSource: connect.dragSource(),
            connectDragPreview: connect.dragPreview(),
            isDragging: monitor.isDragging()
        };
    }
);

let DropTargetDecorator = DropTarget([ItemTypes.ROW, ItemTypes.BLOCK], rowTarget,
    function (connect, monitor) {
        return {
            connectDropTarget: connect.dropTarget(),
            isOver: monitor.isOver(),
            canDrop: monitor.canDrop(),
            isOverCurrent: monitor.isOver({ shallow: true })
        };
    }
);

const mapStateToProps = (state) => {
    return { state };
}

const mapDispatchToProps = (dispatch) => {
    return {
        addBlockAsRow: (rowIndex, rowData) => {
            dispatch(addBlock(rowIndex, rowData))
        },
        columnSortable: (rowIndex, dragIndex, hoverIndex) => {
            dispatch(columnSortable(rowIndex, dragIndex, hoverIndex))
        },
        changeColumnGen: (colLayout, current, rowIndex) => {
            dispatch(changeColumn(colLayout, current, rowIndex))
        },
        toggleCollapse: (id) => {
            dispatch(toggleCollapse(id))
        }
    }
}

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(DropTargetDecorator(DragSourceDecorator(Row)));
