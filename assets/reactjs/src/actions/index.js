
// export const dropAddonsDirect = ( options ) => {
// 	return {
// 		type: 'DROP_ADDON_DIRECT',
// 		addonData: options.data
// 	}
// }

export const importTemplate = (data) => {
	return {
		type: 'TEMPLATE_IMPORT',
		templateData: data
	}
};

export const changeColumnWidth = (options) => {
	let actionType = '';
	if(options.type == 'column'){
		actionType = 'CHANGE_COLUMN_WIDTH';
	} else if(options.type == 'inner_column'){
		actionType = 'CHANGE_INNER_COLUMN_WIDTH';
	}

	return {
		type: actionType,
		newColLayout: options.newColLayout,
		index: options.index,
		settings: options.settings
	}
};

export const shiftUpRow = (index) => {
	return {
		type: 'ROW_SHIFT_UP',
		rowIndex: index
	}
};

export const shiftDownRow = (index) => {
	return {
		type: 'ROW_SHIFT_DOWN',
		rowIndex: index
	}
};

export const addRow = (layout = '100') => {
	return {
		type: 'ROW_ADD',
		layout: layout
	}
};

export const addRowBottom = (index,layout) => {
	return {
		type: 'ROW_ADD_BOTTOM',
		index: index,
		layout: layout
	}
};

export const addInnerRow = ( index, colIndex ) => {
	return {
		type: 'ROW_INNER_ADD',
		index: index,
		settings: {
			colIndex: colIndex
		}
	}
};

export const addExtraColumn = ( index, colIndex ) => {
	return {
		type: 'COLUMN_ADD_EXTRA',
		index: index,
		settings: {
			colIndex: colIndex,
		}
	}
};

export const innerExtraColumn = ( rowIndex, colIndex, innerRowIndex, innerColIndex ) => {
	return {
		type: 'COLUMN_INNER_EXTRA',
		index: rowIndex,
		settings: {
			colIndex: colIndex,
			addonIndex: innerRowIndex,
			innerColIndex: innerColIndex
		}
	}
};

export const cloneColumn = ( index, colIndex ) => {
	return {
		type: 'COLUMN_CLONE',
		index: index,
		settings: {
			colIndex: colIndex,
		}
	}
};

export const cloneInnerColumn = ( options ) => {
	return {
		type: 'COLUMN_INNER_CLONE',
		index: options.index,
		settings: options.settings
	}
};

export const toggleRow = (id) => {
	return {
		type: 'ROW_TOGGLE',
		id: id,
	}
};

export const deleteRow = (index) => {
	return {
		type: 'ROW_DELETE',
		index: index
	}
};

export const cloneRow = (index) => {
	return {
		type: 'ROW_CLONE',
		index: index
	};
};

export const pasteRow = (options) => {
	return{
		type: 'ROW_PASTE',
		index: options.index,
		row: options.data
	}
};

export const saveSetting = (options) => {

	let newType = 'ROW_SETTING';
	if (options.type === 'row' ){
		newType = 'ROW_SETTING';
	} else if(options.type === 'column') {
		newType = 'COLUMN_SETTING';
	} else if(options.type === 'addon'){
		if (options.settings.addonIndex === "") {
			newType = 'ADDON_SETTING';
		} else {
			newType = 'ADDON_EDIT';
		}
	} else if(options.type === 'inner_row') {
		newType = 'ROW_INNER_SETTING'
	} else if(options.type === 'inner_column') {
		newType = 'COLUMN_INNER_SETTING'
	} else if(options.type === 'inner_addon') {
		if (options.settings.addonInnerIndex === ""){
			newType = 'ADDON_INNER_SETTING';
		}else{
			newType = 'ADDON_INNER_EDIT';
		}
	}
	
	return {
		type: newType,
		index: options.index,
		settings: options.settings
	}
};

export const cloneAddon = (options) => {
	return {
		type: 'ADDON_CLONE',
		index: options.index,
		settings: options.settings
	}
};

export const innerPasteRow = (options) => {
	var settings = {
		colIndex: options.colIndex,
		addonIndex: options.addonIndex,
		innerRow: options.data
	};

	return {
		type: 'ROW_INNER_PASTE',
		index: options.index,
		settings: settings
	}
};

export const innerCloneRow = (options) =>{
	return {
		type: 'ROW_INNER_CLONE',
		index: options.index,
		settings: options.settings
	}
};

export const cloneAddonInner = ( options ) =>{
	return {
		type: 'ADDON_INNER_CLONE',
		index: options.index,
		settings: options.settings
	}
};

export const deleteAddon = (options) => {
	return {
		type: 'ADDON_DELETE',
		index: options.index,
		settings: options.settings
	}
};

export const deleteInnerAddon = (options) => {
	return {
		type: 'ADDON_INNER_DELETE',
		index: options.index,
		settings: options.settings
	}
};

export const innerToggleRow = (options) => {
	return {
		type: 'ROW_INNER_TOGGLE',
		index: options.index,
		settings: options.settings
	}
};

export const innerAddRowBottom = ( rowIndex, colIndex, innerRowIndex, innerColIndex ) => {
    return {
        type: 'ROW_INNER_ADD_BOTTOM',
        settings: {
            rowIndex: rowIndex,
            colIndex: colIndex,
            innerRowIndex: innerRowIndex,
            innerColIndex: innerColIndex
        }
    }
};

export const changeColumn = (layout, current, index) => {
	return {
		type: 'COLUMN_CHANGE',
		index: index,
		layout: layout,
		current: current
	}
};

export const changeInnerColumn = ( layout, current, index, colIndex, addonIndex ) => {
  return {
    type: 'COLUMN_INNER_CHANGE',
    index: index,
    layout: layout,
    current: current,
    settings: {
		colIndex: colIndex,
		addonIndex: addonIndex,
    }
  }
};

export const rowSortable = (dragIndex, hoverIndex) => {
	return {
		type : 'ROW_SORT',
		dragIndex : dragIndex,
		hoverIndex : hoverIndex
	}
};

export const importPage = (page) => {
	return {
		type: 'IMPORT_PAGE',
		page: page
	}
};

export const pageEmptyClick = (page) => {
	return {
		type: 'EMPTY_PAGE',
		page: page
	}
};

export const deleteColumn = (index, colIndex) => {
	return {
		type: 'COLUMN_DELETE',
		index: index,
		settings: {
			colIndex: colIndex
		}
	}
};

export const disableColumn = (index, colIndex, id) => {
	return {
		type: 'COLUMN_TOGGLE',
		index: index,
		settings: {
			colIndex: colIndex,
			id: id
		}
	}
};

export const deleteInnerColumn = (options) => {
	return {
		type: 'COLUMN_INNER_DELETE',
		index: options.index,
		settings: options.settings
	}
};

export const disableInnerColumn = (options) => {
	return {
		type: 'COLUMN_INNER_TOGGLE',
		index: options.index,
		settings: options.settings
	}
};

export const columnSortable = (rowIndex, dragIndex, hoverIndex) => {
	return {
		type : 'COLUMN_SORT',
		rowIndex: rowIndex,
		dragIndex : dragIndex,
		hoverIndex : hoverIndex
	}
};

export const toggleCollapse = ( id ) => {
	return {
		type : 'TOGGLE_COLLAPSE',
		id: id
	}
};

export const innerColumnSortable = (rowIndex, colIndex, addonIndex, dragIndex, hoverIndex) => {
	return {
		type        : 'INNER_COLUMN_SORT',
		rowIndex    : rowIndex,
		colIndex    : colIndex,
		addonIndex  : addonIndex,
		dragIndex   : dragIndex,
		hoverIndex  : hoverIndex
	}
};

export const disableAddon = (options) => {
	return {
		type: 'ADDON_DISABLE',
		index: options.index,
		settings: options.settings
	}
};

export const disableInnerAddon = (options) => {
	return {
		type: 'ADDON_INNER_DISABLE',
		index: options.index,
		settings: options.settings
	}
};

export const changeBoxLayout = (boxLayout) => {
	return {
		type: 'CHANGE_BOXLAYOUT',
		boxlayout: boxLayout
	}
};

export const addBlock = (index, row) => {
	return {
		type: 'BLOCK_ADD',
		index: index,
		row: row
	}
};

export const colPercent = ( indexOfNodes, layout ) => {

	let actonType = 'COLUMN_PERCENT';
	if(indexOfNodes.length > 2) {
		actonType = 'INNER_COLUMN_PERCENT';
	}

	return {
		type: actonType,
		index: indexOfNodes[0],
		settings: {
			colIndex: indexOfNodes[1],
			addonIndex: indexOfNodes[2],
			indexOfNodes : indexOfNodes,
			layout : layout
		}
	}
};

export const testActionType = () => {
	return {
        type: 'TESTING_ACTION_WPPB',
    }

}