import React, { Component } from 'react'
import EditPanelManager from '../helpers/EditPanelManager'
import { saveSetting } from '../actions/index'
import { ItemTypes } from './Constants'
import { DragSource } from 'react-dnd'
import { connect } from 'react-redux'


const addonSource = {
    beginDrag(props){
        return {
            type: 'ADD_ADDON',
            name: props.addon.addon_name,
            addon: props.addon
        }
    },

    endDrag(props, monitor, component){
        let result = monitor.getDropResult();
        if(result && result.status){
            var newAddonId = (new Date).getTime();
            var addonName = props.addon.addon_name;

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
                    formData: props.addon.default,
                    type: result.type,
                    addonInnerIndex: ''
                }
            };

            if(result.type == 'inner_addon'){
                newAddon.settings.innerRowIndex = result.innerRowIndex;
                newAddon.settings.innerColIndex = result.innerColIndex;
                newAddon.settings.addonIndex = result.innerRowIndex

            }

            let addonAttrGeneral = Object.assign( {}, page_data.addonsJSON[addonName].attr.general , page_data.addonsJSON[addonName].attr.style );

            let addonFormData = {};
            __.forEach(addonAttrGeneral, function(value, key){
                if ( ! __.isEmpty(value.std)) {
                    addonFormData[key] = value.std;
                } else {
                    addonFormData[key] = "";
                }
            });

            if(props.addon.js_template) {
                newAddon.settings.htmlContent = '<div id="wppb-addon-' + newAddonId + '" class="clearfix" ></div>';
            }

            newAddon.settings.formData = addonFormData;
            props.onSettingsClick(newAddon);
            let addedAddon = newAddon;
            if(result.type == 'inner_addon'){
                addedAddon.settings.addonInnerIndex = indexPosition;
            } else {
                addedAddon.settings.addonIndex = indexPosition;
            }
            
            EditPanelManager.setAddon(addedAddon);
            EditPanelManager.setType( result.type );
            EditPanelManager.showEditPanel();
        }
    }
}


class AllAddonListItem extends Component {
    render() {
        const {connectDragPreview, connectDragSource, addon} = this.props;
        return(connectDragPreview(
            <span title={addon.title}>
                {connectDragSource(
                    <span>
                        { (addon.icon.indexOf('/') !== -1) &&
                            <img src={addon.icon} alt={addon.title} />
                        }
                        { (addon.icon.indexOf('fa-') !== -1) &&
                            <i className={ 'fas '+addon.icon }/>
                        }
                        { (addon.icon.indexOf('wppb-font-') !== -1) &&
                            <i className={ addon.icon }/>
                        }
                        <span> {addon.title}</span>
                    </span>
                )}
            </span>
        ))
    }
}

let DragSourceDecorator = DragSource(ItemTypes.ADDON, addonSource,
    function(connect, monitor) {
        return {
            connectDragSource: connect.dragSource(),
            connectDragPreview: connect.dragPreview(),
            isDragging: monitor.isDragging()
        };
    }
);

const mapStateToProps = ( state ) => {
    return { state: state };
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
)(DragSourceDecorator(AllAddonListItem));