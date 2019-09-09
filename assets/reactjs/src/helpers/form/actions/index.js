export const loadInitialValue = ( addonType, settings, nameOfAddon ) => {
    return {
        type      : 'INIT_VALUE',
        addonName : nameOfAddon,
        addonType : addonType,
        values    : settings
    }
};


export const setRepeatFields = ( fieldName, rfieldIndex ) => {
    return{
        type        : 'ADD_EDIT_REPEAT_FIELD',
        fieldName   : fieldName,
        rfieldIndex : rfieldIndex,
    }
}

export const saveInsideAddon = (values,fieldData) => {
    if (fieldData.addonIndex === '') {
      var actionType = 'SAVE_ADDON_IN';
    } else {
      var actionType = 'UPDATE_ADDON_IN';
    }

    return {
        type        : actionType,
        formVal     : values,
        fieldData   : fieldData
    }
};

export const addonAddEditInside = ( addonName, values, riFieldName, addonIndex ) => {
    return {
        type        : 'ADD_EDIT_ADDON_IN',
        addonName   : addonName,
        addonIndex  : addonIndex,
        values      : values,
        riFieldName : riFieldName
    }
}

export const addonRemoveInside = ( addonIndex, riFieldName, fieldData ) => {
    return {
        type        : 'REMOVE_ADDON_IN',
        addonIndex  : addonIndex,
        riFieldName : riFieldName,
        fieldData   : fieldData
    }
}
