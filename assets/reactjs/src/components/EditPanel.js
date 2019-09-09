import React, { Component } from 'react'
import deepcopy from 'deepcopy'
import AddonForm from '../helpers/AddonForm'
import WidgetForm from '../helpers/WidgetForm'

class EditPanel extends Component {
    
    render(){
        const { addon, onSaveSettings, toggleType, rowSettings, colSettings, uniqueId } = this.props;
        let settings, addonData, addonName;

        if(toggleType == 'addon' || toggleType == 'inner_addon' || toggleType == 'widget') {
            addonData = deepcopy(addon)
            addonName = addonData.settings.addonName
            settings = addonData.settings.formData
        } else if(toggleType == 'row' || toggleType == 'inner_row') {
            settings = rowSettings
        } else if(toggleType == 'column' || toggleType == 'inner_column') {
            settings = colSettings
        }

        return(
            <div key={uniqueId} className="wppb-builder-edit-panel">
                { (toggleType == 'widget') &&
                    <WidgetForm
                        uniqueId = {uniqueId}
                        addonName={addonName}
                        htmlData={settings}
                        onSaveSettings={onSaveSettings}
                        toggleType={toggleType} />
                }
                { (toggleType != 'widget') &&
                    <AddonForm
                        uniqueId = {uniqueId}
                        addonName={addonName}
                        settings={settings}
                        onSaveSettings={onSaveSettings}
                        toggleType={toggleType} />
                }
            </div>
        )
    }
}
export default EditPanel;