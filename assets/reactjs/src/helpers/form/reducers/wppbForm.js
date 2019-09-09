import update from 'react/lib/update';

var intialFormValue = {
  form: '',
  mainForm: {
    addonName: '',
    addonTitle: '',
    addonType: '',
    values: ''
  },
  insideForm: {
    addonName: '',
    addonTitle: '',
    addonType: 'addon',
    values: ''
  },
  activeField: {
    fieldName: '',
    rfieldIndex: '',
    rowIndex: '',
    colIndex: '',
    addonName: '',
    addonTitle: '',
    addonIndex: '',
    riFieldName: ''
  }
};

const wppbForm = (state = intialFormValue, action) => {

    switch ( action.type ) {

        case 'ADD_EDIT_ADDON_IN':

            var newData = update( state, {
              form : { $set : 'insideForm' },
              insideForm  : {
                  addonName   : { $set : action.addonName },
                  values      : { $set : action.values }
              },
              activeField : {
                  rowIndex    : { $set : action.rowIndex },
                  colIndex    : { $set : action.colIndex },
                  addonName   : { $set : action.addonName },
                  riFieldName : { $set : action.riFieldName },
                  addonIndex  : { $set : action.addonIndex }
              }
            });

            return newData;

        case 'INIT_VALUE':
            var newData = update( state, {
              form : { $set : 'mainForm' },
              mainForm : {
                addonName : { $set : action.addonName },
                addonType : { $set : action.addonType },
                values    : { $set : action.values }
              }
            });

            return newData;

        case 'CANCEL_ADDON_IN_FORM':
            return update( state, { form : { $set : 'mainForm' } });

        case 'ADD_EDIT_REPEAT_FIELD':
            return update( state, {
              activeField : {
                fieldName   : { $set : action.fieldName },
                rfieldIndex : { $set : action.rfieldIndex }
              }
            });

        default:
          return state
    }
}

export default wppbForm;
