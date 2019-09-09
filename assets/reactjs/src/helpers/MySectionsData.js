import { EventEmitter } from 'events';

class MySectionsData extends EventEmitter{
  constructor(){
    super();
    this.mySections = [];
  }

  setAllSections(sections){
    this.mySections = sections;
    this.emit('change');
  }

  addSection(section){
    this.mySections.push(section);
    this.emit('change');
  }

  deleteSection(index){
    this.mySections = [
      ...this.mySections.slice(0,index ),
      ...this.mySections.slice(index + 1)
    ];
    this.emit('change');
  }

  getAllSections(){
    return this.mySections;
  }
}
const mySectionsData = new MySectionsData;

export default mySectionsData;
