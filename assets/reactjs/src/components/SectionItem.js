import React,{ Component } from 'react';
import { connect } from 'react-redux'
import { ItemTypes } from './Constants';
import { DragSource, DropTarget } from 'react-dnd';
import { addBlock } from '../actions/index';

const blockSource = {
    beginDrag(props){
       let blockData = (typeof props.element.block[0] !== 'undefined') ? props.element.block[0] : props.element.block;
        return {
            type: 'block',
            element: { block: blockData }
        }
    }
}

class SectionItem extends Component {
    render(){
        const { element, connectDragPreview, connectDragSource } = this.props;
        if( typeof page_data.WPPB_PRO_VERSION === 'undefined' && element.pro ){
            return connectDragPreview(
                <div className="not-draggable">
                    <img draggable="false" src={`${element.banner}`} />
                    <span className="wppb-pro">{page_data.i18n.pro}</span>
                    <h3>{element.title}</h3>
                </div>
            )
        }else{
            return connectDragPreview(connectDragSource(
                <div className={'blocks-draggable'}>

                    <div className={'blocks-draggable-img'}>
                        <img src={`${element.banner}`} />
                    </div>
                    {
                        element.pro && <span className="wppb-pro">{page_data.i18n.pro}</span>
                    }
                    <div className="wppb-block-preview">
                        <h3>{element.title}</h3>
                        { element.liveurl &&
                            <span><a className="wppb-block-view" target="_blank" href={element.liveurl}><i className="fa fa-share"/>{page_data.i18n.preview}</a></span>
                        }
                    </div>
                </div>
            ))
        }
    }
}

let DragSourceDecorator = DragSource(ItemTypes.BLOCK, blockSource,
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
)(DragSourceDecorator(SectionItem));
