import EventEmitter from 'events';

class EditPanelManagerClass extends EventEmitter {
    constructor() {
        super();
        this.show = false;
        this.addon = {};
        this.type = 'addon';
        this.rowIndex = 0;
        this.rowSettings = {};
        this.colIndex = 0;
        this.colSettings = {};
        this.innerRowIndex = 0;		
	    this.innerColIndex = 0;
    }

    showEditPanel(){
        this.show = true;
        this.emit('change');
    }

    hideEditPanel(){
        this.show = false;
        this.emit('change');
    }

    setType(type){
        this.type = type;
        this.emit('change');
    }

    setAddon(addon){
        this.addon = addon;
        this.emit('change');
    }

    setRowIndex(index){
        this.rowIndex = index;
        this.emit('change');
    }

    setColIndex(index){
        this.colIndex = index;
        this.emit('change');
    }

    setInnerRowIndex(data){
        this.innerRowIndex = data;
        this.emit('change');
    }

    setInnerColIndex(data){
        this.innerColIndex = data;
        this.emit('change');
    }

    setRowSettings(settings){
        this.rowSettings = settings;
        this.emit('change');
    }

    setColSettings(settings){
        this.colSettings = settings;
        this.emit('change');
    }

    resetAll(){
        this.show = false;
        this.addon = {};
        this.type = 'addon';
        this.rowIndex = 0;
        this.rowSettings = {};
        this.emit('change');
    }

}
const EditPanelManager = new EditPanelManagerClass;

export default EditPanelManager;