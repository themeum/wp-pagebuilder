import { reducer as formReducer } from 'redux-form'
import update from 'react/lib/update';
import deepCopy from 'deepcopy'

let continueNodeId = (new Date).getTime();

var miniPageBuilder = [];


const formReducers = formReducer.plugin({
        wppbForm: (state, action) => {   // <----- 'wppbForm' is name of form given to reduxForm()
            switch(action.type) {
                case 'SAVE_ADDON_IN':
                case 'UPDATE_ADDON_IN':
                case 'REMOVE_ADDON_IN':
                    const { fieldData } = action
                    var cloneItem = jQuery.extend(true, {}, state.values[fieldData.fieldName][fieldData.rfieldIndex])
                    var newItem = changeObjectId(cloneItem, action);
                    return update(state, {
                      values: {
                          [fieldData.fieldName]: {
                              $splice: [[fieldData.rfieldIndex, 1, newItem]]
                          }
                      }
                    });

                default:
                    return state
            }
        }
    });


const changeObjectId = (item, action) => {
    const { fieldData } = action

    switch (action.type) {

      case 'SAVE_ADDON_IN':
        var contents = item[fieldData.riFieldName];
        if (contents == undefined || contents == '') {

          var newMiniPageBuilder = deepCopy(miniPageBuilder);

          newMiniPageBuilder.push({
                id: continueNodeId++,
                name: fieldData.addonName,
                settings: action.formVal
            })
            item[fieldData.riFieldName] = newMiniPageBuilder
        } else {
          item[fieldData.riFieldName].push({
                id: continueNodeId++,
                name: fieldData.addonName,
                settings: action.formVal
            })
        }
        return item;

      case 'UPDATE_ADDON_IN':
          item[fieldData.riFieldName][fieldData.addonIndex].settings = action.formVal
          return item;

      case 'REMOVE_ADDON_IN':

        return update(item, {
              [action.riFieldName] : {
                $splice: [
                  [action.addonIndex, 1]
                ]
              }
            });

        default:
          return item;
    }
}
export default formReducers;
