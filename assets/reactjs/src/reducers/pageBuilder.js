import update from 'react/lib/update'
import deepcopy from 'deepcopy'

var nextNodeId = (new Date).getTime();

const pageBuilder = ( state = page_data.initialState, action ) => {
    switch (action.type){
        case 'EMPTY_PAGE':
            return [];

        case 'TEMPLATE_IMPORT':
            let importData = __.map( action.templateData, changeObjectId );
            return [
                ...state,
                ...importData
            ];

        case 'ROW_SHIFT_UP':
            return [
                ...state.slice( 0, action.rowIndex - 1 ),
                __.clone(state[action.rowIndex]),
                ...state.slice( action.rowIndex - 1, action.rowIndex ),
                ...state.slice( action.rowIndex + 1 )
            ];

        case 'ROW_SHIFT_DOWN':
            return [
                ...state.slice( 0, action.rowIndex ),
                ...state.slice( action.rowIndex + 1, action.rowIndex + 2 ),
                __.clone(state[action.rowIndex]),
                ...state.slice( action.rowIndex + 2 )
            ];

        case 'COLUMN_PERCENT':

           return state.map(function( rowValue, index ){
                if (index != action.index) {
                    return rowValue;
                }
        
                return row( rowValue, action );
            });

        case 'COLUMN_ADD_EXTRA':
            let theRow      = __.clone(state[action.index])
            let newCoulmn   = { id: nextNodeId++, class_name: '', visibility: true, settings: {width:100},  addons: [] };
            theRow.columns  = [
                ...theRow.columns.slice(0,action.settings.colIndex + 1 ),
                newCoulmn,
                ...theRow.columns.slice(action.settings.colIndex + 1 ),
            ]
            theRow = changeLayoutColumn( theRow );
            return [
                ...state.slice( 0, action.index ),
                theRow,
                ...state.slice( action.index + 1 )
            ];

        case 'COLUMN_DELETE':
                let copyState = __.clone(state[action.index]);
                copyState.columns = [
                    ...copyState.columns.slice( 0, Number( action.settings.colIndex ) ),
                    ...copyState.columns.slice( Number( action.settings.colIndex ) + 1 )
                ]
                copyState = changeLayoutColumn( copyState );
                state[action.index] = copyState;
            return state;


        case 'IMPORT_PAGE':
            return action.page;

        case 'ROW_ADD':
            return[
                ...state,
                row(undefined, action)
            ];

        case 'ROW_TOGGLE':
        case 'TOGGLE_COLLAPSE':
            return state.map(t => row(t, action));

        case 'ROW_ADD_BOTTOM':
            return [
                ...state.slice(0,action.index + 1 ),
                row(undefined, action),
                ...state.slice(action.index + 1 )
            ];

        case 'ROW_DELETE':
            return [
                ...state.slice(0,action.index ),
                ...state.slice(action.index + 1 )
            ]

        case 'ROW_CLONE':
            return [
                ...state.slice( 0, action.index + 1 ),
                changeObjectId( deepcopy(state[action.index]) ),
                ...state.slice( action.index + 1 )
            ];

        case 'ROW_PASTE':
            return [
                ...state.slice( 0, action.index ),
                Object.assign({},action.row,{ id: nextNodeId++ }),
                ...state.slice( action.index + 1 )
            ];

        case 'BLOCK_ADD':
            if( typeof action.row == 'string' ){
                action.row = JSON.parse( JSON.stringify(action.row) )
            }
            if( typeof action.index == 'undefined' ){
            return [
                    ...state.slice(),
                    changeObjectId( deepcopy( action.row ) )
                ];
            }else{
                return [
                    ...state.slice( 0, action.index ),
                    changeObjectId( deepcopy(action.row) ),
                    ...state.slice( action.index )
                ];
            }
    
    
        case 'ADDON_EDIT':
        case 'COLUMN_CLONE':
        case 'ADDON_CLONE':
        case 'ADDON_DELETE':
        case 'ADDON_DISABLE':
        case 'ADDON_SETTING':
        case 'ADDON_COPY':
        case 'ADDON_INNER_COPY':
        case 'ADDON_PASTE':
        case 'ADDON_INNER_PASTE':
        case 'ADDON_INNER_SETTING':
        case 'ADDON_INNER_CLONE':
        case 'ADDON_INNER_DELETE':
        case 'ADDON_INNER_EDIT':
        case 'ADDON_INNER_DISABLE':
        case 'COLUMN_CHANGE':
        case 'COLUMN_TOGGLE':
        case 'COLUMN_SETTING':
        case 'COLUMN_INNER_DELETE':
        case 'COLUMN_INNER_CLONE':
        case 'COLUMN_INNER_TOGGLE':
        case 'COLUMN_INNER_CHANGE':
        case 'COLUMN_INNER_SETTING':
        case 'COLUMN_INNER_EXTRA':
        case 'ROW_SETTING':
        case 'ROW_INNER_ADD':
        case 'ROW_INNER_TOGGLE':
        case 'ROW_INNER_PASTE':
        case 'ROW_INNER_CLONE':
        case 'ROW_INNER_SETTING':
        case 'ROW_INNER_ADD_BOTTOM':
        case 'CHANGE_COLUMN_WIDTH':
        case 'INNER_COLUMN_PERCENT':
        case 'CHANGE_INNER_COLUMN_WIDTH':
            return state.map( function( rowValue, index ) {
                if (index != action.index) {
                    return rowValue;
                }
                return row( rowValue, action );
            });

        case 'ROW_SORT':
            return update(state, {
                $splice: [
                    [action.dragIndex, 1],
                    [action.hoverIndex, 0, state[action.dragIndex]]
                ]
            });

        case 'ADDON_SORT_COL_INNER':
            var drag         = action.drag,
                drop         = action.drop,
                dragIndex    = action.dragIndex,
                hoverIndex   = action.hoverIndex;

            var dragAddon    = state[drag.rowIndex].columns[drag.colIndex].addons[dragIndex];

            var tempDrag = dragIndex + 1;
            var tempHover = hoverIndex + 1;

            if ( dragIndex == tempHover && action.dropPosition == 'bottom' ) {
                return state;
            } else if ( dragIndex == tempHover && action.dropPosition == 'top' ) {
            }else if( tempDrag == hoverIndex && action.dropPosition == 'top' ){
                return state;
            } else if( tempDrag == hoverIndex && action.dropPosition == 'bottom' ){
            }else if ( dragIndex > hoverIndex && action.dropPosition == 'bottom' ) {
                hoverIndex = hoverIndex + 1;
            } else if ( dragIndex > tempHover && action.dropPosition == 'top' ) {
            }else if( dragIndex < hoverIndex && action.dropPosition == 'top' ){
                hoverIndex = hoverIndex - 1;
            } else if( dragIndex < hoverIndex && action.dropPosition == 'bottom' ){
            }
            return update(state,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                $splice: [
                                    [dragIndex, 1],
                                    [hoverIndex, 0, dragAddon]
                                ]
                            }
                        }
                    }
                }
            });

        case 'ADDON_SORT_COL':
            var drag        = action.drag,
                drop        = action.drop,
                dragIndex   = action.dragIndex,
                hoverIndex  = action.hoverIndex;

            var dragAddon = state[drag.rowIndex].columns[drag.colIndex].addons[dragIndex];
            if( typeof action.drugInnerCol == 'undefined' ){
                dragAddon.type = 'addon';
            }
            if (action.dropPosition == 'bottom') {
                hoverIndex = hoverIndex + 1;
            }

            return update(state,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                $splice: [
                                    [dragIndex, 1]
                                ]
                            }
                        },
                        [drop.colIndex]:{
                            addons:{
                                $splice: [
                                    [hoverIndex, 0, dragAddon]
                                ]
                            }
                        }
                    }
                }
            });

        case 'ADDON_SORT_OUTER_ROW':
            var drag    = action.drag,
                drop        = action.drop,
                dragIndex   = action.dragIndex,
                hoverIndex  = action.hoverIndex;

            var dragAddon = state[drag.rowIndex].columns[drag.colIndex].addons[dragIndex];

            if (action.dropPosition == 'bottom') {
                hoverIndex = hoverIndex + 1;
            }

            return update(state,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                $splice: [
                                    [dragIndex, 1]
                                ]
                            }
                        }
                    }
                },
                [drop.rowIndex]:{
                    columns:{
                        [drop.colIndex]:{
                            addons:{
                                $splice: [
                                    [hoverIndex, 0, dragAddon]
                                ]
                            }
                        }
                    }
                }
            });

        case 'ADDON_SORT_PARENT_COL':
            var drag        = action.drag,
                drop        = action.drop,
                dragIndex   = action.dragIndex,
                hoverIndex  = action.hoverIndex;
            var dragAddon = innerAddon(state, action);
            dragAddon.type = 'addon';
            return update(state,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                [drag.innerRowIndex]:{
                                    columns:{
                                        [drag.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [dragIndex, 1]
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        [drop.colIndex]:{
                            addons:{
                                $splice: [
                                    [hoverIndex, 0, dragAddon]
                                ]
                            }
                        }
                    }
                }
            });

        case 'ADDON_SORT_PARENT_OUTER_ROW':
            var drag        = action.drag,
                drop        = action.drop,
                dragIndex   = action.dragIndex,
                hoverIndex  = action.hoverIndex;
            var dragAddon = innerAddon(state, action);
            dragAddon.type = 'addon'
            return update(state,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                [drag.innerRowIndex]:{
                                    columns:{
                                        [drag.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [dragIndex, 1]
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                },
                [drop.rowIndex]:{
                    columns:{
                        [drop.colIndex]:{
                            addons:{
                                $splice: [
                                    [hoverIndex, 0, dragAddon]
                                ]
                            }
                        }
                    }
                }
            });

        case 'INNER_ADDON_SORT_INNER_COL':
            var drag        = action.drag,
                drop        = action.drop,
                dragIndex   = action.dragIndex,
                hoverIndex  = action.hoverIndex;
            var tempDrag    = dragIndex + 1;
            var tempHover   = hoverIndex + 1;

            if ( dragIndex == tempHover && action.dropPosition == 'bottom' ) {
                return state;
            } else if ( dragIndex == tempHover && action.dropPosition == 'top' ) {
            }else if( tempDrag == hoverIndex && action.dropPosition == 'top' ){
                return state;
            } else if( tempDrag == hoverIndex && action.dropPosition == 'bottom' ){
            }else if ( dragIndex > hoverIndex && action.dropPosition == 'bottom' ) {
                hoverIndex = hoverIndex + 1;
            } else if ( dragIndex > tempHover && action.dropPosition == 'top' ) {
            }else if( dragIndex < hoverIndex && action.dropPosition == 'top' ){
                hoverIndex = hoverIndex - 1;
            } else if( dragIndex < hoverIndex && action.dropPosition == 'bottom' ){
            }

            var addon = state[drag.rowIndex]
                .columns[drag.colIndex]
                .addons[drag.innerRowIndex];

            var addonIndex = drag.innerRowIndex;
            if(typeof addon ==='undefined'){
                var addonIndex = Number(drag.innerRowIndex-1);
            }

            var dragAddon = innerAddon(state, action);

            return update(state,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                [addonIndex]:{
                                    columns:{
                                        [drag.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [dragIndex, 1],
                                                    [hoverIndex, 0, dragAddon]
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });


        case 'INNER_ADDON_SORT_INNER_ROW':
            var drag        = action.drag,
                drop        = action.drop,
                dragIndex   = action.dragIndex,
                hoverIndex  = action.hoverIndex;
            var dragAddon   = innerAddon(state, action);
            dragAddon.type = 'inner_addon';
            if (action.dropPosition == 'bottom') {
                hoverIndex  = hoverIndex + 1;
            }
            return update(state,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                [drag.innerRowIndex]:{
                                    columns:{
                                        [drag.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [dragIndex, 1]
                                                ]
                                            }
                                        },
                                        [drop.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [hoverIndex, 0, dragAddon]
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });

        case 'INNER_ADDON_SORT_OUTER_ROW':
            var drag        = action.drag,
                drop        = action.drop,
                dragIndex   = action.dragIndex,
                hoverIndex  = action.hoverIndex;

            if (action.dropPosition == 'bottom') {
                hoverIndex = hoverIndex + 1;
            }
            return update(state,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                [drag.innerRowIndex]:{
                                    columns:{
                                        [drag.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [action.dragIndex, 1]
                                                ]
                                            }
                                        }
                                    }
                                },
                                [drop.innerRowIndex]:{
                                    columns:{
                                        [drop.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [hoverIndex, 0, innerAddon(state, action) ]
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });

        case 'INNER_ADDON_SORT_PARENT_ROW':
            var drag        = action.drag,
                drop        = action.drop,
                hoverIndex  = action.hoverIndex;

            if (action.dropPosition == 'bottom') {
                hoverIndex  = hoverIndex + 1;
            }
            return update(state,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                [drag.innerRowIndex]:{
                                    columns:{
                                        [drag.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [action.dragIndex, 1]
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        [drop.colIndex]:{
                            addons:{
                                [drop.innerRowIndex]:{
                                    columns:{
                                        [drop.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [hoverIndex, 0, innerAddon(state, action)]
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });

        case 'INNER_ADDON_SORT_PARENT_OUTER_ROW':
            var drag        = action.drag,
                drop        = action.drop,
                hoverIndex  = action.hoverIndex;

            if (action.dropPosition == 'bottom') {
                hoverIndex = hoverIndex + 1;
            }
            return update(state,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                [drag.innerRowIndex]:{
                                    columns:{
                                        [drag.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [dragIndex, 1]
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                },
                [drop.rowIndex]:{
                    columns:{
                        [drop.colIndex]:{
                            addons:{
                                [drop.innerRowIndex]:{
                                    columns:{
                                        [drop.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [action.dragIndex, 0, innerAddon(state, action)]
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });

        case 'ADDON_SORT_INNER_ADDON_ROW':
            var drag        = action.drag,
                drop        = action.drop,
                hoverIndex  = action.hoverIndex;

            var dragAddon = state[drag.rowIndex].columns[drag.colIndex].addons[action.dragIndex]
            dragAddon.type = 'inner_addon';
            if (action.dropPosition == 'bottom') {
                hoverIndex = hoverIndex + 1;
            }
            return update(state,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                $splice: [
                                    [action.dragIndex, 1]
                                ]
                            }
                        },
                        [drop.colIndex]:{
                            addons:{
                                [drop.innerRowIndex]:{
                                    columns:{
                                        [drop.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [hoverIndex, 0, dragAddon ]
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });

        case 'ADDON_SORT_INNER_ADDON_OUTER_ROW':
            var drag        = action.drag,
                drop        = action.drop,
                hoverIndex  = action.hoverIndex;

            if (action.dropPosition == 'bottom') {
                hoverIndex = hoverIndex + 1;
            }
            return update(state,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                $splice: [
                                    [action.dragIndex, 1]
                                ]
                            }
                        }
                    }
                },
                [drop.rowIndex]:{
                    columns:{
                        [drop.colIndex]:{
                            addons:{
                                [drop.innerRowIndex]:{
                                    columns:{
                                        [drop.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [hoverIndex, 0, state[drag.rowIndex].columns[drag.colIndex].addons[action.dragIndex]]
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });

        case 'ADDON_SORT_PARENT_COL_INNER':
            var drag        = action.drag,
                drop        = action.drop,
                hoverIndex  = action.hoverIndex;
            if (action.dropPosition == 'bottom') {
                hoverIndex = hoverIndex + 1;
            }
            var dragAddon = innerAddon(state, action);
            dragAddon.type = 'addon';

            var newAddon = update(state,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                [drag.innerRowIndex]:{
                                    columns:{
                                        [drag.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [ action.dragIndex, 1 ]
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });
            return update(newAddon,{
                [drop.rowIndex]:{
                    columns:{
                        [drop.colIndex]:{
                            addons:{
                                $splice: [
                                    [hoverIndex, 0, dragAddon]
                                ]
                            }
                        }
                    }
                }
            });

        case 'ADDON_SORT_INNER_ADDON_COL':
            var drag        = action.drag,
                drop        = action.drop,
                hoverIndex  = action.hoverIndex;
            if (action.dropPosition == 'bottom') {
                hoverIndex = hoverIndex + 1;
            }
            var newAddon = update(state,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                [drop.innerRowIndex]:{
                                    columns:{
                                        [drop.innerColIndex]:{
                                            addons:{
                                                $splice: [
                                                    [hoverIndex, 0, state[drag.rowIndex].columns[drag.colIndex].addons[action.dragIndex]]
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });
            return update(newAddon,{
                [drag.rowIndex]:{
                    columns:{
                        [drag.colIndex]:{
                            addons:{
                                $splice: [
                                    [action.dragIndex, 1]
                                ]
                            }
                        }
                    }
                }
            });

        case 'COLUMN_SORT':
        case 'INNER_COLUMN_SORT':
            return state.map(function( rowValue, index ){
                if ( index != action.rowIndex ) {
                    return rowValue;
                }
                return row( rowValue, action );
            });

        case  'TESTING_ACTION_WPPB':
            return {
                rows : state,
                global_settings: {},
                page_settings : {
                    title: 'WordPress Page Builder',
                    slug: 'wordpress-page-builder'
                }
            };

        default:
            return state;
    }
}


const innerAddon = ( state, action ) => {
    var drag        = action.drag;
    var addonIndex = drag.innerRowIndex;
    if(typeof state[drag.rowIndex].columns[drag.colIndex].addons[drag.innerRowIndex] ==='undefined'){
        var addonIndex = Number(drag.innerRowIndex-1);
    }
    return state[drag.rowIndex].columns[drag.colIndex].addons[addonIndex].columns[drag.innerColIndex].addons[action.dragIndex];
}

const initRow = ( layout = '100' /* , addonData = [] */ ) => {
    let newCols = String(layout).split(',');
    let columns = newCols.map( col => {
        return {
            id: nextNodeId++,
            class_name: Number(col),
            visibility: true,
            settings: {
                col_custom_width: {
                    md: Number(col),
                    sm: Number(col),
                    xs: 100
                }
            },
            addons: []
        }
    })
    return {
        id: nextNodeId++,
        visibility: true,
        collapse: false,
        settings: {
            row_padding: { md: { top:'25px', bottom:'25px', left:'0px', right:'0px' } },
            row_screen: 'row-stretch',
            row_opacity: 0.4,
        },
        layout: layout,
        columns: columns,
    }
}


// ----------------------------------------------
// --------- Row Function -----------------------
// ----------------------------------------------
const row = (state,action) => {

    switch(action.type){

        case 'ROW_ADD':
            return initRow( action.layout );


        case 'ROW_TOGGLE':
            if (state.id !== action.id) {
                return state;
            };

            return Object.assign({},state,{
                visibility: !state.visibility
            });

        case 'ROW_ADD_BOTTOM':
            return initRow( action.layout );

        case 'ROW_SETTING':
            return Object.assign({},state,{
                settings: action.settings.formData
            });

        case 'CHANGE_COLUMN_WIDTH':
            return Object.assign({},state,{
                layout: action.newColLayout
            });

        case 'TOGGLE_COLLAPSE':
            if (state.id !== action.id) {
                return state;
            };
            return Object.assign({},state,{
                collapse: !state.collapse
            });

        case 'ADDON_DELETE':
        case 'ADDON_SETTING':
        case 'ADDON_COPY':
        case 'ADDON_INNER_COPY':
        case 'ADDON_PASTE':
        case 'ADDON_INNER_PASTE':
        case 'ADDON_EDIT':
        case 'ADDON_CLONE':
        case 'ADDON_INNER_DELETE':
        case 'ADDON_INNER_EDIT':
        case 'ADDON_INNER_SETTING':
        case 'ADDON_INNER_CLONE':
        case 'ADDON_DISABLE':
        case 'ADDON_INNER_DISABLE':
        case 'COLUMN_TOGGLE':
        case 'COLUMN_INNER_CLONE':
        case 'COLUMN_INNER_CHANGE':
        case 'COLUMN_INNER_DELETE':
        case 'COLUMN_INNER_TOGGLE':
        case 'COLUMN_INNER_SETTING':
        case 'COLUMN_INNER_EXTRA':
        case 'ROW_INNER_ADD':
        case 'ROW_INNER_PASTE':
        case 'ROW_INNER_CLONE':
        case 'ROW_INNER_TOGGLE':
        case 'ROW_INNER_ADD_BOTTOM':
        case 'ROW_INNER_SETTING':
        case 'INNER_COLUMN_PERCENT':
        case 'CHANGE_INNER_COLUMN_WIDTH':
            let startCol  = Number( action.settings.colIndex ),
                endCol    = startCol + 1,
                column    = Object.assign({}, state.columns[startCol]);

            return Object.assign( {},state,{
                columns: [
                    ...state.columns.slice( 0, startCol ),
                    addons( column,action ),
                    ...state.columns.slice( endCol )
                ]
            });

        case 'COLUMN_PERCENT':
            let cloneCol = __.clone(state.columns);
            let newColumns = changeColumnLayoutDnD(cloneCol, action)

            return Object.assign({},state,{
                layout: action.settings.layout.join(','),
                columns: newColumns
            });

        case 'COLUMN_CHANGE':
            let colObj = changeColumnLayout( jQuery.extend(true, {}, state.columns) , action );
            return Object.assign({},state,{
                layout: colObj.layout,
                columns: colObj.columns
            });

        case 'COLUMN_SETTING':
            var clonedColumn = Object.assign({}, state.columns[action.settings.colIndex]);
                clonedColumn.settings = action.settings.formData;
            return Object.assign({},state,{
                columns: [
                    ...state.columns.slice( 0, action.settings.colIndex ),
                    clonedColumn,
                    ...state.columns.slice( action.settings.colIndex + 1 )
                ]
            });


        case 'COLUMN_CLONE':
            return changeLayoutColumn(
                Object.assign({},state,{
                    columns: [
                        ...state.columns.slice( 0, action.settings.colIndex + 1 ),
                        changeObjectId( deepcopy( state.columns[action.settings.colIndex] ) ),
                        ...state.columns.slice( action.settings.colIndex + 1 )
                    ]
                })
            );

        case 'COLUMN_SORT':
            let dragIndex = action.dragIndex,
                hoverIndex = action.hoverIndex;

            const { columns, layout } = state;

            var colLayout = String(layout).split(','),
                colData = colLayout[dragIndex]

            var newColLayout = update(colLayout,{
                $splice: [
                    [dragIndex, 1],
                    [hoverIndex, 0, colData]
                ]
            })

            var newLayout = newColLayout.join(',');
            
            const dragCol = columns[dragIndex];

            return update(state, {
                layout: { $set: newLayout },
                columns: {
                    $splice: [
                        [dragIndex, 1],
                        [hoverIndex, 0, dragCol]
                    ]
                }
            });

        case 'INNER_COLUMN_SORT':

            var colIndex    = action.colIndex,
                addonIndex  = action.addonIndex,
                dragIndex   = action.dragIndex,
                hoverIndex  = action.hoverIndex,
                innerRow    = state.columns[colIndex].addons[addonIndex],
                dragColumn  = innerRow.columns[dragIndex],
                layout      = innerRow.layout;

            var colLayout = String(layout).split(','),
                colData = colLayout[dragIndex]

            var newColLayout = update(colLayout,{
                $splice: [
                    [dragIndex, 1],
                    [hoverIndex, 0, colData]
                ]
            })
            var newLayout = newColLayout.join(',');

            return update(state, {
                columns: {
                    [colIndex]:{
                        addons:{
                            [addonIndex]:{
                                layout: { $set: newLayout },
                                columns:{
                                    $splice: [
                                        [dragIndex, 1],
                                        [hoverIndex, 0, dragColumn]
                                    ]
                                }
                            }
                        }
                    }
                }
            });

        default:
            return state;
    }
}


// ----------------------------------------------
// --------- Column Function --------------------
// ----------------------------------------------
const columns = ( state, action ) => {
    var startCol  = Number( action.settings.innerColIndex ),
        endCol    = startCol + 1;

    switch(action.type) {

        case 'COLUMN_INNER_SETTING':
            var clonedColumn = Object.assign({}, state.columns[ startCol ]);
            clonedColumn.settings = action.settings.formData;
            return Object.assign({},state,{
                columns: [
                    ...state.columns.slice( 0, startCol ),
                    clonedColumn,
                    ...state.columns.slice( endCol )
                ]
            });

        case 'COLUMN_INNER_CHANGE':
            var cloneCols = jQuery.extend(true, {}, state.columns);
            var innerColObj = changeColumnLayout(cloneCols, action);

            return Object.assign({},state,{
                layout: innerColObj.layout,
                columns: innerColObj.columns
            });

        
        case 'COLUMN_INNER_CLONE':
            let number = Number( action.settings.innerColIndex );
            return changeLayoutColumn(
                Object.assign( {}, state,
                    { columns: 
                        [
                        ...state.columns.slice( 0, number ),
                        changeObjectId( Object.assign( {}, state.columns[number] ) ),
                        ...state.columns.slice( number )
                        ]
                    }
                ) 
            )

        case 'COLUMN_INNER_DELETE':
            return changeLayoutColumn(
                Object.assign( {}, state, 
                    { columns: 
                        [ ...state.columns.slice( 0, Number( action.settings.innerColIndex ) ),
                        ...state.columns.slice( Number( action.settings.innerColIndex ) + 1 )] 
                    } 
                ) 
            )

        case 'ADDON_INNER_SETTING':
        case 'ADDON_INNER_CLONE':
        case 'ADDON_INNER_COPY':
        case 'ADDON_INNER_PASTE':
        case 'ADDON_INNER_DELETE':
        case 'ADDON_INNER_EDIT':
        case 'ADDON_INNER_DISABLE':
            if (action.type === 'ADDON_INNER_SETTING') {
                action.type = 'ADDON_SETTING';
            } else {
               action.settings.addonIndex = action.settings.addonInnerIndex;
            }
            if (action.type === 'ADDON_INNER_CLONE') {
                action.type = 'ADDON_CLONE';
            }
            if (action.type === 'ADDON_INNER_COPY') {
                action.type = 'ADDON_COPY';
                
            }
            if (action.type === 'ADDON_INNER_DELETE') {
                action.type = 'ADDON_DELETE';
            }
            if (action.type === 'ADDON_INNER_PASTE') {
                action.type = 'ADDON_PASTE';
            }
            if (action.type === 'ADDON_INNER_EDIT') {
                action.type = 'ADDON_EDIT';
            }
            if (action.type === 'ADDON_INNER_DISABLE') {
                action.type = 'ADDON_DISABLE';
            }

            if (typeof  state !== 'undefined' && typeof  state.columns !== 'undefined') {
                let clonedColumn = Object.assign({}, state.columns[startCol]);
                return Object.assign({}, state, {
                    columns: [
                        ...state.columns.slice(0, startCol),
                        addons(clonedColumn, action),
                        ...state.columns.slice(endCol)
                    ]
                });
            }else{
                return state
            }

        case 'COLUMN_INNER_TOGGLE':
            if (typeof  state !== 'undefined' && typeof  state.columns !== 'undefined') {
                var clonedInnerColumn = Object.assign({}, state.columns[startCol]);
                clonedInnerColumn.visibility = !clonedInnerColumn.visibility;

                return Object.assign({}, state, {
                    columns: [
                        ...state.columns.slice(0, startCol),
                        clonedInnerColumn,
                        ...state.columns.slice(endCol)
                    ]
                });
            }
        case 'COLUMN_INNER_EXTRA':
            let startNum = Number( action.settings.innerColIndex );
            if (typeof  state !== 'undefined' && typeof  state.columns !== 'undefined') {
                return changeLayoutColumn(
                    Object.assign({}, state,
                        {
                            columns:
                                [...state.columns.slice(0, startNum + 1),
                                    {
                                        id: nextNodeId++,
                                        class_name: '',
                                        visibility: true,
                                        settings: {width: 100},
                                        addons: []
                                    },
                                    ...state.columns.slice(startNum + 1)]
                        }
                    )
                )
            }

        case 'ADDON_DISABLE':
            /**
             * TODO: Need to check why script comes here when drop an addon in inner row if exists addon in parent row
             */
            //Weird solution, but it works
            if (action.type !== 'ADDON_DISABLE'){
                return state;
            }
            
            if (typeof state !== 'undefined'){
                const { visibility } = state;
                return Object.assign({},state,{
                    visibility: !visibility
                });
            }

        default:
            return state;
    }
}

// reducers
const addons = (state,action) => {

    var start = Number(action.settings.addonIndex),
        end   = start + 1;

    var options = action.settings;

    var innerRow = {
        id: nextNodeId++,
        type: 'inner_row',
        settings:{
            row_padding: { md: { top:'25px', bottom:'25px', left:'0px', right:'0px' } },
            row_screen: 'row-stretch'
        },
        layout: '100',
        visibility: true,
        columns: [
            {
                id: nextNodeId++,
                class_name: 100,
                visibility: true,
                settings: {
                    col_custom_width: {
                        md: 100,
                        sm: 100,
                        xs: 100
                    }
                 },
                addons: []
            }
        ]
    };

    switch(action.type) {

        case 'ADDON_SETTING':

            var newAddon = {
                id: options.addonId,
                name: options.addonName,
                visibility: true,
                settings: options.formData,
                htmlContent: options.htmlContent,
                type: options.type,
            };

            if(typeof options.indexPosition !== 'undefined'){ // When Item Drop Only
                if(options.indexPosition == 0){
                    return Object.assign({},state,{
                        addons: [
                             newAddon,
                            ...state.addons
                        ]
                    });
                } else {
                    return Object.assign({},state,{
                        addons: [
                            ...state.addons.slice( 0, options.indexPosition ),
                            newAddon,
                            ...state.addons.slice( options.indexPosition )
                        ]
                    });
                }
            } else {
                return Object.assign({},state,{
                    addons: [
                        ...state.addons.slice( 0, ( action.index > 0 ? (action.index - 1) : 0 ) ),
                        newAddon,
                        ...state.addons.slice( action.index + 1 ),
                    ]
                });
            }

        case 'COLUMN_TOGGLE':
            if (state.id !== action.settings.id) {
                return state;
            };

            return Object.assign({},state,{
                visibility: !state.visibility
            });

        case 'ROW_INNER_ADD':
            return Object.assign({},state,{
                addons: [
                    ...state.addons,
                    innerRow
                ]
            });


        case 'ROW_INNER_ADD_BOTTOM':
            return Object.assign({},state,{
                addons: [
                    ...state.addons.slice( 0, end ),
                    innerRow,
                    ...state.addons.slice( end )
                ]
            });

        case 'ADDON_CLONE':
            var clonedAddon = Object.assign({}, state.addons[ start ]);
            clonedAddon.id = nextNodeId++;
            /*
            var htmlData = _callbackAjaxContent(clonedAddon);
            clonedAddon.assets = htmlData.assets;
            clonedAddon.htmlContent = htmlData.content;
            */
            return Object.assign({},state,{
                addons: [
                    ...state.addons.slice( 0, end ),
                    clonedAddon,
                    ...state.addons.slice( end )
                ]
            });

        case 'ROW_INNER_PASTE':
            var copyRow = Object.assign({},action.settings.innerRow,{
                id: nextNodeId++
            });

            return Object.assign({},state,{
                addons: [
                    ...state.addons.slice( 0, start ),
                    copyRow,
                    ...state.addons.slice( end )
                ]
            });

        case 'ROW_INNER_CLONE':
            var clonedAddon = jQuery.extend(true, {}, state.addons[ start ]),
                newAddon = changeObjectId(clonedAddon);

            return Object.assign({},state,{
                addons: [
                    ...state.addons.slice( 0, end ),
                    newAddon,
                    ...state.addons.slice( end )
                ]
            });

        case 'ROW_INNER_TOGGLE':
            var clonedAddon = Object.assign({}, state.addons[ start ]);
            clonedAddon.visibility = !clonedAddon.visibility;

            return Object.assign({},state,{
                addons: [
                    ...state.addons.slice( 0, start ),
                    clonedAddon,
                    ...state.addons.slice( end )
                ]
            });


        case 'ADDON_EDIT':
        case 'ROW_INNER_SETTING':
            var clonedAddon = Object.assign({}, state.addons[ start ]);
            clonedAddon.settings = options.formData;

            return Object.assign({},state,{
                addons: [
                    ...state.addons.slice( 0, start ),
                    clonedAddon,
                    ...state.addons.slice( start + 1 )
                ]
            });

        case 'ADDON_DISABLE':
        case 'ADDON_INNER_EDIT':
        case 'ADDON_INNER_CLONE':
        case 'ADDON_INNER_COPY':
        case 'ADDON_INNER_PASTE':
        case 'ADDON_INNER_DELETE':
        case 'ADDON_INNER_DISABLE':
        case 'ADDON_INNER_SETTING':
        case 'COLUMN_INNER_CLONE':
        case 'COLUMN_INNER_CHANGE':
        case 'COLUMN_INNER_DELETE':
        case 'COLUMN_INNER_TOGGLE':
        case 'COLUMN_INNER_SETTING':
        case 'COLUMN_INNER_EXTRA':
            return Object.assign({},state,{
                addons: [
                    ...state.addons.slice( 0, start ),
                    columns( state.addons[ start ] ,action ),
                    ...state.addons.slice( end )
                ]
            });
        
        case 'INNER_COLUMN_PERCENT':
        case 'CHANGE_INNER_COLUMN_WIDTH':
            
            if(action.type == 'INNER_COLUMN_PERCENT'){
                action.type = 'COLUMN_PERCENT';
            } else if(action.type == 'CHANGE_INNER_COLUMN_WIDTH'){
                action.type = 'CHANGE_COLUMN_WIDTH';
            }

            return Object.assign({},state,{
                addons: [
                    ...state.addons.slice( 0, start ),
                    row( state.addons[ start ] ,action ),
                    ...state.addons.slice( end )
                ]
            });

        case 'ADDON_DELETE':
            return Object.assign({},state,{
                addons: [
                    ...state.addons.slice(0,action.settings.addonIndex),
                    ...state.addons.slice(action.settings.addonIndex+1)
                ]
            });

        case 'ADDON_PASTE':
            var copiedAddon = JSON.parse(localStorage.getItem('copiedAddon'));
            copiedAddon.id = nextNodeId++;
            copiedAddon.type = "addon";

            return Object.assign({},state,{
                addons: [
                    ...state.addons,
                    copiedAddon
                ]
            });

        case 'ADDON_COPY':
            var copiedAddon = Object.assign({}, state.addons[ start ]);
            localStorage.setItem( 'copiedAddon', JSON.stringify(copiedAddon) );

        default:
            return state;
    }
};


const changeObjectId = (obj) => {
    let copyObj = deepcopy( obj );
    copyObj.id = nextNodeId++;
    if( copyObj.columns ){
        jQuery.each(copyObj.columns, function(key, column){
            column.id = nextNodeId++;
            jQuery.each(column.addons,function(key,addon){
                addon.id = nextNodeId++;
                if ( addon.type === 'inner_row' ) {
                    jQuery.each(addon.columns, function(key, col){
                        col.id = nextNodeId++;
                        jQuery.each(col.addons,function(key,add){
                            add.id = nextNodeId++;
                        })
                    })
                }
            });
        });
    }else{
        jQuery.each(copyObj.addons,function(key,addon){
            if ( addon.type === 'inner_row' ) {
                return changeObjectId(addon);
            } else {
                addon.id = nextNodeId++;
            }
        });
    }
    return copyObj;
};


const changeLayoutColumn = (obj) => {
    let length          = obj.columns.length
    let seperateWidth   = __.round( ( 100 / ( length ) ) , 2 )
    let layout          = __.fill( Array(length) , seperateWidth )
    if( length == 6 ){ layout[length-1] = 16.65 }
    else if( length == 7 ){ layout[length-1] = 14.26 }
    obj.layout          = __.join( layout , ',' );
    let count           = 1;
    obj.columns         = __.map( obj.columns , (n)=>{
        let colWidth    = ( ( length == 6 && count == 6 ) ? 16.65 : ( length == 7 && count == 7 ) ? 14.26 : seperateWidth )
        n.class_name    = colWidth;
        n.settings.col_custom_width = { md:colWidth, sm:colWidth, xs:100 }
        count++;
        return n;
    });
    return obj;
};

const changeColumnLayoutDnD = (columns, action) => {
    return columns.map(function(column, index){

        if(typeof column.settings.col_custom_width !== 'undefined'){
            column.settings.col_custom_width.md = action.settings.layout[index]
        }

        return column;
    })
}

const changeColumnLayout = ( columns, action ) => {
    var cloneCols   = columns,
        layout      = action.layout,
        current     = action.current;

    if (layout == '100') {
        var layoutArray = [100];
    } else {
        var layoutArray     = String(layout).split(',')
    }

    if (current == '100') {
        var activeLayout = [100];
    } else {
        var activeLayout     = String(current).split(',')
    }

    var newLength       = layoutArray.length,
        currentLength   = activeLayout.length;

    var newColumns  = [];

    for ( var i = 0; i < newLength; i++ ) {
        var element = layoutArray[i],
            newClassName = element;

        if (typeof cloneCols[i] !== 'undefined') {
            cloneCols[i].class_name = newClassName;
            newColumns.push(cloneCols[i]);
        } else {
            var newCoulmn = {
                id: nextNodeId++,
                class_name: newClassName,
                visibility: true,
                settings: {width:102},
                addons: [],
            };

            newColumns.push(newCoulmn);
        }
    }

    if ( newLength < currentLength ) {
        var index = newLength - 1,
            restList = [];

        for ( var i = newLength; i < currentLength; i++ ) {
            var restAddons = cloneCols[i].addons;
            if(restAddons.length > 0){
                restList = restList.concat(restAddons);
            }
        }

        if (restList.length > 0) {
            newColumns[index].addons = newColumns[index].addons.concat(restList);
        }
    };

    return {
        layout: layout,
        columns: newColumns
    }
}

export default pageBuilder
