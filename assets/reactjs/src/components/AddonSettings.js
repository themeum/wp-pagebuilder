import React, { Component } from 'react';
import EditPanelManager from '../helpers/EditPanelManager';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { addInnerRow, deleteColumn, deleteInnerColumn, disableColumn, disableInnerColumn, cloneAddon, deleteAddon, cloneAddonInner, deleteInnerAddon, saveSetting, disableAddon, disableInnerAddon, copyAddon, copyAddonInner } from '../actions/index';


class AddonSettings extends Component{

    constructor( props ){
        super( props );
    }

    _editAddons( rowIndex, colIndex, addonIndex, addonId, htmlContent, addonName, formData, type, innerColIndex, addonInnerIndex ){
        let editAddon = {
            type: 'addon',
            index: rowIndex,
            settings: { colIndex , addonIndex , addonId , htmlContent, addonName , formData , type }
        };
        if (typeof addonInnerIndex !== 'undefined') {
            editAddon.type = 'inner_addon';
            editAddon.settings.innerRowIndex = addonIndex;
            editAddon.settings.innerColIndex = innerColIndex;
            editAddon.settings.addonInnerIndex = addonInnerIndex;
        }
        EditPanelManager.setAddon(editAddon);
        EditPanelManager.setType(editAddon.type);
        EditPanelManager.showEditPanel();
    }

    render(){
        const { addon, rowIndex, colIndex, addonIndex, innerColIndex, addonInnerIndex, cloneAddon, cloneAddonInner, deleteInnerAddon, deleteAddon, disableAddon, disableInnerAddon, connectDragSource, copyAddon, copyAddonInner } = this.props;

        let options = {
            index: rowIndex,
            settings: {
                colIndex: colIndex,
                addonIndex: addonIndex,
                innerColIndex: innerColIndex,
                addonInnerIndex: addonInnerIndex
            }
        };


        return(
            <div>
                <ul>
                    <li title="Drag Addon">
                        { connectDragSource( <i className="wppb-font-arrows"/> ) }
                    </li>

                    {addon.visibility &&
                    <li title="Edit Addon" onClick={ () => { this._editAddons( rowIndex, colIndex, addonIndex, addon.id, addon.htmlContent, addon.name, addon.settings, addon.type, innerColIndex, addonInnerIndex ); }}>
                        <i className="wppb-font-edit"/>
                    </li>
                    }

                    {addon.visibility &&
                    <li title="Duplicate Addon" onClick={ (e) => {
                        typeof addonInnerIndex === 'undefined'
                            ? cloneAddon(options)
                            : cloneAddonInner(options)
                    }}>
                        <i className="wppb-font-sheet"/>
                    </li>
                    }

                    <li title="Disable Addon" onClick={ (e) => {
                        typeof addonInnerIndex === 'undefined'
                            ? disableAddon(options)
                            : disableInnerAddon(options)
                    }}>
                        {addon.visibility?<i className="wppb-font-eye-off"/>:<i className="wppb-font-eye-on"/>}
                    </li>

                    {addon.visibility &&
                    <li title="Delete Addon" onClick={ () => {
                        // if (window.confirm("Do you really want to delete this addon?")) {
                            jQuery(window.frames['wppb-builder-view'].window.document).find('#addon-script-'+addon.id).remove();
                            if( typeof addonInnerIndex === 'undefined' ){
                                deleteAddon(options);
                                EditPanelManager.hideEditPanel();
                            } else {
                                deleteInnerAddon(options);
                                EditPanelManager.hideEditPanel();
                            }
                         // }
                        }}>
                        <i className="wppb-font-trash"/>
                    </li>
                    }
                    {addon.visibility &&
                    <li title="Copy Addon" onClick={ (e) => {
                        typeof addonInnerIndex === 'undefined'
                            ? copyAddon(options)
                            : copyAddonInner(options)
                    }}>
                        <i className="wppb-font-copy-alt"/>
                    </li>
                    }
                </ul>
                <div onClick={ () => { this._editAddons( rowIndex, colIndex, addonIndex, addon.id, addon.htmlContent, addon.name, addon.settings, addon.type, innerColIndex, addonInnerIndex ); }}></div>
            </div>
        )
    }
}

const mapStateToProps = (state) => {
    return { state };
}

function mapDispatchToProps(dispatch) {
    return bindActionCreators({
        onSettingsClick: saveSetting,
        addInnerRow,
        deleteColumn,
        deleteInnerColumn,
        copyAddon,
        copyAddonInner,
        cloneAddon,
        deleteAddon,
        cloneAddonInner,
        deleteInnerAddon,
        disableAddon,
        disableInnerAddon
    }, dispatch);
}

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(AddonSettings);
