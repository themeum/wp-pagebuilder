import deepcopy from 'deepcopy'

export const formFieldsOptions = ( formData ) => {

    if ( formData.addonType == 'addon' || formData.addonType == 'inner_addon' || formData.addonType == 'widget' ) {

        var addonOps = {};

        // Tab Seperated Code
        let styleTab = {};
        let generalTab = {};
        let advancedTab = {};

        if (formData.addonType == 'widget'){
            addonOps = { attr: {}, is_widget: true, id: formData.values.widgetId }
        }else{
            addonOps = page_data.addonsJSON[formData.addonName];
        }
        
        if (typeof addonOps.attr.general !== 'undefined') {
            __.forEach(addonOps.attr.general, function (value, key) {
                if (typeof value.tab !== 'undefined') {
                    if (value.tab == 'style') {
                        styleTab[key] = value;
                    }
                } else {
                    generalTab[key] = value;
                }
            });
        }
        addonOps.attr.general = generalTab;

        //Separate to advanced tab
        __.forEach( page_data.globalAttr.advanced , function(value, key) {
            if (typeof value.tab !== 'undefined') {
                if( value.tab == 'style' ){
                    styleTab[key] = value;
                }
            } else {
                advancedTab[key] = value;
            }
        });
        addonOps.attr.advanced = advancedTab;

        //Separate Style Tab
        __.forEach( page_data.globalAttr.style , function(value, key) {
            styleTab[key] = value;
        });



        if (typeof addonOps.attr.style === 'undefined'){
            addonOps.attr.style = {};
        }

        if( !__.isEmpty(styleTab) ){
            __.forEach( styleTab , function(value, key) {
                addonOps.attr.style[key] = value;
            });
        }


        // Rearrange Tab
        let styleTabRearrange = addonOps.attr.style;
        let advancedRearrange = addonOps.attr.advanced;
        let generalTabRearrange = addonOps.attr.general;
        delete addonOps.attr;
        addonOps.attr = {general : generalTabRearrange, style: styleTabRearrange, advanced : advancedRearrange,};
        // End Rearrange Tab

        return addonOps;
    } else if ( formData.addonType == 'column' || formData.addonType == 'inner_column' ) {
        return page_data.colSettings;
    } else if ( formData.addonType == 'row' || formData.addonType == 'inner_row' ) {
        let globalData = deepcopy( page_data.rowSettings );
        if( formData.addonType == 'inner_row' ){
            globalData.attr.style.row_shape = {}
            globalData.attr.style.row_shape_bottom = {}
            globalData.attr.general.row_screen = {}
            globalData.attr.general.row_custom_width = {}
        }
        return globalData;
    }
}

export const imagePosition = [ 
    { value: '', label: 'Default' },
    { value: 'left top', label: 'left top' },
    { value: 'left center', label: 'left center' },
    { value: 'left bottom', label: 'left bottom' },
    { value: 'right top', label: 'right top' },
    { value: 'right center', label: 'right center' },
    { value: 'right bottom', label: 'right bottom' },
    { value: 'center top', label: 'center top' },
    { value: 'center center', label: 'center center' },
    { value: 'center bottom', label: 'center bottom' }];

export const imageAttachment = [ 
    { value: '', label: 'Default' },
    { value: 'scroll', label: 'Scroll' },
    { value: 'fixed', label: 'Fixed' } ];

export const imageRepeat = [ 
    { value: '', label: 'Default' },
    { value: 'no-repeat', label: 'No-repeat' },
    { value: 'repeat', label: 'Repeat' },
    { value: 'repeat-x', label: 'Repeat-x' },
    { value: 'repeat-y', label: 'Repeat-y' } ];

export const imageSize = [ 
    { value: '', label: 'Default' },
    { value: 'auto', label: 'Auto' },
    { value: 'cover', label: 'Cover' },
    { value: 'contain', label: 'Contain' } ];