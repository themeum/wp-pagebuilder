import React, { Component } from 'react'
import { findDOMNode } from 'react-dom'
import { connect } from 'react-redux'
import { ItemTypes } from './Constants'
import { DragSource, DropTarget } from 'react-dnd'
import AddonSettings from './AddonSettings'
import AddonContent from './AddonContent'
import { saveSetting } from '../actions/index'
import { CssGenerator } from './CssGenerator'
import EditPanelManager from '../helpers/EditPanelManager';

const addonSource = {
    beginDrag(props){
        EditPanelManager.resetAll();
        return {
            id: props.id,
            index: props.index,
            rowIndex: props.rowIndex,
            colIndex: props.colIndex
        }
    }
}

const addonTarget = {
    hover( props, monitor, component ) {
        const item          = monitor.getItem();
        if ( monitor.getItem().id === props.id) {
            return;
        }

        let element = findDOMNode(component)

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

    drop( props, monitor, component ) {
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
                type: 'addon',
                status: true,
                index: props.index,
                dropPosition: options.dropPosition,
                rowIndex: props.rowIndex,
                colIndex: props.colIndex
            };
        }

        if (typeof item.innerRowIndex === 'undefined') {
            if (item.rowIndex === props.rowIndex && item.colIndex === props.colIndex) {
                options.type = 'ADDON_SORT_COL_INNER';
            } else if (item.rowIndex === props.rowIndex && item.colIndex !== props.colIndex){
                options.type = 'ADDON_SORT_COL';
                options.drugInnerCol = 'Yes';
            } else {
                options.type = 'ADDON_SORT_OUTER_ROW';
            }
        } else {
            if (item.rowIndex === props.rowIndex && item.colIndex === props.colIndex) {
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

class Addon extends Component {

    componentDidMount(){
        const { addon, connectDragPreview } = this.props
        connectDragPreview( this.createCustomDragSource() );

        // CSS Generator
        if( addon.name ){
            CssGenerator( addon, addon.type , 'setinline' );
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
            CssGenerator( addon, addon.type , 'setinline' );
        }
    }

    shouldComponentUpdate(nextProps, nextState){
        if( __.isEqual(nextProps.addon, this.props.addon) && 
            __.isEqual(nextProps.colIndex, this.props.colIndex) && 
            __.isEqual(nextProps.rowIndex, this.props.rowIndex) && 
            __.isEqual(nextProps.isDragging, this.props.isDragging) &&
            __.isEqual(nextProps.isOver, this.props.isOver) &&
            __.isEqual(nextProps.index, this.props.index)) {
            return false;
        }
        return true;
    }

    createCustomDragSource(){
        let img = new Image();
        img.src = page_data.pagebuilder_base + 'assets/img/addon.png';
        return img
    }

    editOnClickAddon(){
        const { addon, rowIndex, colIndex, index } = this.props;
        let editAddon = {
            type: 'addon',
            index: rowIndex,
            settings: {
                colIndex: colIndex,
                addonIndex: index,
                addonId: addon.id,
                htmlContent: addon.htmlContent,
                addonName: addon.name,
                formData: addon.settings
            }
        };
        EditPanelManager.setAddon(editAddon);
        EditPanelManager.setType('addon');
        EditPanelManager.showEditPanel();
    }

    render() {
        const { addon , isOver, isDragging, connectDropTarget, connectDragPreview } = this.props;
        const { settings } = this.props.addon;

        let overClass = [ 'wppb-builder-addon wppb-addon-' + addon.id ];
        if( isDragging && !isOver ){ overClass.push( 'wppb-builder-dragging' ) } // Drag & Drop Class
        if ( isOver && !isDragging ){ overClass.push( 'wppb-builder-addon-over' ) }
        if( !addon.visibility ){ overClass.push( 'wppb-builder-addon-disabled') } // Disable Class
        if( settings.addon_class ){ overClass.push( settings.addon_class ) } // Extra Row Class

        // Animation
		let attribute = { key: addon.id, id:( settings.addon_id ? settings.addon_id : null ), 'data-addon-id':addon.id };
		if( typeof settings.addon_animation !== 'undefined' && settings.addon_animation.itemOpen ){
			if( settings.addon_animation.name ){ overClass.push( 'wppb-wow','wppb-animated', settings.addon_animation.name ) }
			if( settings.addon_animation.delay ){ attribute['data-wow-delay'] = settings.addon_animation.delay + 'ms' }
			if( settings.addon_animation.duration ){ attribute['data-wow-duration'] = settings.addon_animation.duration + 'ms' }
        }

        return connectDragPreview(connectDropTarget(
            <div {...attribute} className={overClass.join(' ')}>
                <div className="addon-placeholder-top"></div>
                <div className="wppb-builder-addon-tools">
                    { addon.name &&
                        <AddonSettings
                            addon = { addon }
                            rowIndex = { this.props.rowIndex }
                            colIndex = { this.props.colIndex }
                            addonIndex = { this.props.index }
                            column = { this.props.column }
                            columnMove = { this.props.columnMove }
                            connectDragSource = { this.props.connectDragSource }
                        />
                    }
                </div>
                <AddonContent addon = { addon } editAddon={this.editOnClickAddon.bind(this)} />
                <div className="addon-placeholder-bottom"></div>
            </div>
        ))
    }
}

var DragSourceDecorator = DragSource( ItemTypes.ADDON, addonSource,
    function(connect, monitor) {
        return {
            connectDragSource: connect.dragSource(),
            connectDragPreview: connect.dragPreview(),
            isDragging: monitor.isDragging()
        };
    }
);

var DropTargetDecorator = DropTarget( [ ItemTypes.ADDON, ItemTypes.INNERROW, ItemTypes.INNERADDON ], addonTarget,
    function(connect,monitor) {
        return {
            connectDropTarget: connect.dropTarget(),
            isOver: monitor.isOver({ shallow: true }),
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
)(DropTargetDecorator(DragSourceDecorator(Addon)));
