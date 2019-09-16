import React, { Component } from 'react'
import { connect } from 'react-redux'
import { DragSource } from 'react-dnd'
import { ItemTypes } from './Constants'
import { saveSetting } from '../actions/index'
import EditPanelManager from '../helpers/EditPanelManager'

const defaultClass = {
    pages: 'wppb-font-file-alt', calendar: 'wppb-font-calender-alt', archives: 'wppb-font-folder', media_audio: 'wppb-font-audio', 
    media_image: 'wppb-font-image3', media_gallery: 'wppb-font-image', media_video: 'wppb-font-video', 
    meta: 'wppb-font-blog-template', search: 'wppb-font-search', text: 'wppb-font-text', categories: 'wppb-font-sheet', 'recent-posts': 'wppb-font-open-book-alt', 'recent-comments': 'wppb-font-chat2', rss: 'wppb-font-mail-cursor', tag_cloud: 'wppb-font-cloud', nav_menu: 'wppb-font-menu', custom_html: 'wppb-font-heading',
}

const widgetSource = {
    beginDrag(props){
        return {
            type: 'ADD_ADDON',
            name: props.widget.name,
            addon: props.widget
        }
    },

    endDrag(props, monitor, component){
        let result = monitor.getDropResult();
        if(result && result.status){
            let newAddonId = (new Date).getTime();
            let addonName = props.widget.name;
            let widget_id_base = props.widget.id_base;
            let widget_id = props.widget.id;

            let indexPosition = result.index;
            if(result.dropPosition == 'bottom'){
                indexPosition = result.index + 1;
            }

            let newAddon = {
                type: result.type,
                index: result.rowIndex,
                settings: {
                    indexPosition: indexPosition,
                    colIndex: result.colIndex,
                    addonIndex: '',
                    addonId: newAddonId,
                    htmlContent: '',
                    addonName: addonName,
                    formData: '',
                    type: 'widget',
                }
            };

            if(result.type == 'inner_addon'){
                newAddon.settings.innerRowIndex = result.innerRowIndex;
                newAddon.settings.innerColIndex = result.innerColIndex;
                newAddon.settings.addonIndex = result.innerRowIndex;
            }

            jQuery.ajax({
                type: 'POST',
                url: page_data.ajaxurl,
                dataType: 'json',
                data: {
                    action: 'render_widget_form_data',
                    id: newAddonId,
                    name: addonName,
                    widget_id_base: widget_id_base,
                    widget_id: widget_id,
                },
                success: function(response){
                    newAddon.settings.htmlContent = response.html;
                    newAddon.settings.formData = response.formData;
                    newAddon.settings.type = 'widget';
                    props.onSettingsClick(newAddon);
                    let addedAddon = newAddon;
                    addedAddon.settings.addonIndex = indexPosition;
                    EditPanelManager.setAddon(addedAddon);
                    EditPanelManager.setType('widget');
                    EditPanelManager.showEditPanel();
                }.bind(this)
            });
           
        }
    }
}


class WidgetListItem extends Component {
    render() {
        const {connectDragPreview, connectDragSource, widget} = this.props;
        return(connectDragPreview(
            <span title={widget.name}>
                {connectDragSource(
                    <span>
                        { widget.id_base in defaultClass ?
                             (defaultClass[widget.id_base].indexOf('fa-') !== -1) ?
                                <i className={ 'fas '+ defaultClass[widget.id_base] }/>
                                :
                                <i className={ defaultClass[widget.id_base] }/>
                            :
                            <i className={ 'wppb-font-wordpress'}/> 
                        }
                        <span>{widget.name}</span>
                    </span>
                )}
            </span>
            )
        )
    }
}

var DragSourceDecorator = DragSource(ItemTypes.ADDON, widgetSource,
    function(connect, monitor) {
        return {
            connectDragSource: connect.dragSource(),
            connectDragPreview: connect.dragPreview(),
            isDragging: monitor.isDragging()
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
)(DragSourceDecorator(WidgetListItem));