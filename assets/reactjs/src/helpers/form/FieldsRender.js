import React, { Component } from 'react'
import { connect } from 'react-redux'
import { Field, FieldArray } from 'redux-form'

import Text from './types/Text'
import Color from './types/Color'
import Color2 from './types/Color2'
import Textarea from './types/TextArea'
import Number from './types/Number'
import Switch from './types/Switch'
import Icon from './types/Icon'
import Select from './types/Select'
import Editor from './types/Editor'
import Media from './types/Media'
import Separator from './types/Separator'
import Dimension from './types/Dimension'
import RepeatField from './RepeatField'
import BoxShadow from './types/BoxShadow'
import Slider from './types/Slider'
import Background from './types/Background'
import Gradient from './types/Gradient'
import Alignment from './types/Alignment'
import RadioImage from './types/RadioImage'
import Radio from './types/Radio'
import Checkbox from './types/Checkbox'
import Link from './types/Link'
import Animation from './types/Animation'
import Typography from './types/Typography'
import Typography2 from './types/Typography2'
import IconSocial from './types/IconSocial'
import Border from './types/Border'
import Shape from './types/Shape'
import Filter from './types/Filter'
import DateTime from './types/DateTime'
import ColumnWidth from './types/ColumnWidth'
import ResponsiveManager from '../../helpers/ResponsiveManager'

class FieldsRender extends Component {

  constructor(props){
      super(props);

      this.updateResponsiveData = this.updateResponsiveData.bind(this);
      this.state = {
          'general':true,
          currentSection: 'general',
          currentTab: {},
          mediaDevice: ResponsiveManager.device
        };
  }

  componentDidMount(){
    ResponsiveManager.on('change', this.updateResponsiveData);
  }

  componentWillUnmount(){
    ResponsiveManager.removeListener('change', this.updateResponsiveData);
  }


  updateResponsiveData(){
    this.setState({
        mediaDevice: ResponsiveManager.device
    });
  }

  _renderFiled( flOps, key ){

    switch ( flOps.type ) {
        case 'select':
            return <Field params={flOps} mediaDevice={ this.state.mediaDevice } component={Select} name={key} />
        case 'text':
            return <Field params={flOps} component={Text} name={key} />
        case 'dimension':
            return <Field params={flOps} mediaDevice={this.state.mediaDevice} component={Dimension} name={key} />
        case 'color':
            return <Field params={flOps} component={Color} name={key} />
        case 'color2':
            return <Field params={flOps} component={Color2} name={key} />
        case 'textarea':
            return <Field params={flOps} component={Textarea} name={key} />
        case 'switch':
            return <Field params={flOps} component={Switch} name={key} />
        case 'icon':
            return <Field params={flOps} component={Icon} name={key} />
        case 'editor':
            return <Field params={flOps} component={Editor} name={key} />
        case 'media':
            return <Field params={flOps} component={Media} name={key} />
        case 'boxshadow':
            return <Field params={flOps} component={BoxShadow} name={key} />
        case 'slider':
            return <Field params={flOps} mediaDevice={ this.state.mediaDevice } component={Slider} name={key} />
        case 'columnWidth':
            return <Field params={flOps} mediaDevice={ this.state.mediaDevice } component={ColumnWidth} name={key} />
        case 'typography':
            return <Field params={flOps} mediaDevice={this.state.mediaDevice} component={Typography} name={key} />
        case 'typography2':
            return <Field params={flOps} component={Typography2} name={key} />
        case 'alignment':
            return <Field params={flOps} mediaDevice={ this.state.mediaDevice } component={Alignment} name={key} />
        case 'background':
            return <Field params={flOps} component={Background} name={key} />
        case 'gradient':
            return <Field params={flOps} mediaDevice={this.state.mediaDevice} component={Gradient} name={key} />
        case 'radio':
            return <Field params={flOps} component={Radio} name={key} />
        case 'radioimage':
            return <Field params={flOps} component={RadioImage} name={key} />
        case 'checkbox':
            return <Field params={flOps} component={Checkbox} name={key} />
        case 'animation':
            return <Field params={flOps} mediaDevice={this.state.mediaDevice} component={Animation} name={key} />
        case 'number':
            return <Field params={flOps} mediaDevice={this.state.mediaDevice} component={Number} name={key} />
        case 'border':
            return <Field params={flOps} component={Border} name={key} />
        case 'link':
            return <Field params={flOps} component={Link} name={key} />
        case 'separator':
            return <Field params={flOps} component={Separator} name={key} />
        case 'iconsocial':
            return <Field params={flOps} component={IconSocial} name={key} />
        case 'filter':
            return <Field params={flOps} component={Filter} name={key} />
        case 'datetime':
            return <Field params={flOps} component={DateTime} name={key} />
        case 'shape':
            return <Field params={flOps} mediaDevice={this.state.mediaDevice} component={Shape} name={key} />
        default:
            return;
    }
  }



    _dependencyCheck( flOptions, key, values ){
        if (typeof this.props.parentKey != 'undefined') {
            key = `${this.props.element}.${key}`;
        }
        if ( flOptions.depends ) {
            let _depends = true;
            for (let i = 0; i < flOptions.depends.length; i++) {
                let [ dependKey, operator, dependVal ] = flOptions.depends[i]
                if (typeof this.props.parentKey != 'undefined') {
                    let splitArray =  this.props.element.split('[');
                    values = this.props.state.form.wppbForm.values[splitArray[0]][parseInt(splitArray[1])]
                    if( splitArray.length > 2 ){
                        values = values[splitArray[1].split('.')[1]][parseInt(splitArray[2])]
                    }
                }
                if( operator == '=' ){
                    if( Array.isArray(dependVal) ){
                        if( Array.isArray(values[dependKey]) ){
                            if( __.isEmpty( __.intersection(dependVal,values[dependKey]) ) ){ _depends = false; }
                        }else{
                            if( dependVal.indexOf(values[dependKey]) == -1 ){ _depends = false; }
                        }
                    } else {
                        if (typeof values !== 'undefined' && dependVal != values[dependKey] ) { _depends = false; }
                    }
                } else if ( operator == '!=' ){
                    if( Array.isArray(dependVal) ){
                        if( Array.isArray(values[dependKey]) ){
                            if( !__.isEmpty( __.intersection(dependVal,values[dependKey]) ) ){ _depends = false; }
                        }else{
                            if( dependVal.indexOf(values[dependKey]) != -1 ){ _depends = false; }
                        }
                    } else {
                        if ( dependVal == values[dependKey] ) { _depends = false; }
                    }
                }
            }
            if ( !_depends ){
                return { type: 'notSelector', key };
            } else {
                return { type: 'Selector', key };
            }
        }
        return { key };
    }

    _renderSingleField( fieldsAttr, values ){
        let notSelector = [],
            Selector = [],
            tabItems = {},
            renderTab = [];

        let renderField = __.map( fieldsAttr,( flOptions, key ) => {
            let keyCheck = this._dependencyCheck( flOptions, key, values )
            if( __.isObject( keyCheck ) ){
                if( keyCheck.type == 'notSelector' ){
                    notSelector.push( keyCheck.key );
                    return;
                }
                if( keyCheck.type == 'Selector' ){
                    Selector.push( keyCheck.key );
                }
            }

            if( flOptions.inner_tab ){
                if( typeof flOptions.inner_tab === 'object' ){
                    let innerData = Object.keys(flOptions.inner_tab)

                    let innerId = __.kebabCase( flOptions.inner_tab[innerData[0]] )

                    if( innerData[0] in tabItems ){
                        if( innerId in tabItems[innerData[0]] ){
                            tabItems[innerData[0]][innerId].push( Object.assign( {},flOptions, {tabItemKey:keyCheck.key} ) );
                        }else{
                            tabItems[innerData[0]][innerId] = [ Object.assign( {},flOptions, {tabItemKey:keyCheck.key} ) ];
                        }
                    }else{
                        tabItems[innerData[0]] = { [innerId]: [ Object.assign( {},flOptions, {tabItemKey:keyCheck.key} ) ] }
                    }
                }
            } else {
                return(
                    <div key={ keyCheck.key } className="form-fields">
                        { flOptions.type == 'repeatable' ?
                            <FieldArray flOptions = { flOptions } name = { keyCheck.key } parentKey = { keyCheck.key } component = { RepeatField }/>
                            :
                            this._renderFiled( flOptions, keyCheck.key )
                        }
                    </div>
                )
            }
        });


        if( !__.isEmpty(tabItems) ){
            renderTab = __.map( tabItems,( tabdata, keys ) => {
                let counter = 0;
                return(
                    <div key={ keys } className="wppb-field-tab">
                        {
                            __.map( tabdata,( tabfields, key ) => {
                                counter++;
                                let activeClass = ( (!this.state.currentTab[keys] && counter == 1) ? 'active' : ( (this.state.currentTab[keys] && this.state.currentTab[keys] == key) ? 'active' : '' ) )
                                return(
                                    <div key={key} className={'wppb-field-tab-container ' + activeClass}>
                                        <div className={ 'wppb-field-tab-title ' } onClick={() => { this.setState( { currentTab: Object.assign( {},this.state.currentTab ,  { [keys]:key }   ) })}} >{ __.startCase(key) }</div>
                                        <div className={ 'wppb-field-tab-content ' }>
                                            {
                                                __.map( tabfields,( tabfield, k ) => {
                                                    if (typeof this.props.parentKey != 'undefined') {
                                                        k = `${this.props.element}.${k}`;
                                                    }
                                                    return(
                                                        <div key={ k } className="form-fields">
                                                            { tabfield.type == 'repeatable' ?
                                                                <FieldArray flOptions = { tabfield } name = { tabfield.tabItemKey } parentKey = { tabfield.tabItemKey } component = { RepeatField }/>
                                                                :
                                                                this._renderFiled( tabfield, tabfield.tabItemKey )
                                                            }
                                                        </div>
                                                    )
                                                })
                                            }
                                        </div>
                                    </div>
                                )
                            })
                        }
                    </div>
                )
            })
        }
        return [ renderField.concat(renderTab) , notSelector, Selector ]
    }

    // Field Section Generator
    _classEvents( key ){
        if( this.state.currentSection == key ){
            this.setState({ currentSection: 'none' })
        } else {
            this.setState({ currentSection: key })
        }
    }
    _fieldSectionGenerator( fieldsAttr ){
        let val = {};
        let sectionSeperator = {};
        __.forEach( fieldsAttr, function( value, key ){
            if( fieldsAttr[key].hasOwnProperty( 'section' ) ){
                let keyData = __.replace(fieldsAttr[key].section, ' ', '_')
                if( keyData in sectionSeperator ){
                    let previous = sectionSeperator[keyData];
                    previous[key] = value;
                    sectionSeperator[keyData] = previous;
                } else {
                    let now = {};
                    now[key] = value;
                    sectionSeperator[keyData] = now;
                }
            } else {
                val[key] = value;
                if( key != 'initialize' ){
                    sectionSeperator['general'] = val;
                }
            }
        });

        if( Object.keys(sectionSeperator).indexOf('general') != -1 ){
            let finalShort = { 'general': sectionSeperator['general'] }
            __.forEach( sectionSeperator, ( val,key ) => { ( ( key!='general' ) ? ( finalShort = Object.assign( finalShort, {[key]:val} ) ) : '' ) } )
            return finalShort;
        } else {
            return sectionSeperator;
        }
    }

    _removeSelector( selector, type ){
        let selectorID = '';
        if( type == 'addon' ){
            selectorID = 'wppb-tmpl-addon-style-' + this.props.state.wppbForm.mainForm.addonName;
        }else if( type == 'row' ){
            selectorID = 'wppb-tmpl-row-style';
        }else if( type == 'column' ){
            selectorID = 'wppb-tmpl-col-style';
        }
        let styleTmpl = document.getElementById( selectorID );
        if (styleTmpl) {
            let styleData = styleTmpl.innerHTML
            if (styleData) {
                styleData = JSON.parse(styleData);
                __.forEach(selector, function (element) {
                    if (styleData[element]) {
                        styleData[element + '_hide'] = styleData[element]
                        delete styleData[element]
                    }
                });
                document.getElementById( selectorID ).innerHTML = JSON.stringify(styleData)
            }
        }
    }

    _addSelector( selector, type ){
        let selectorID = '';
        if( type == 'addon' ){
            selectorID = 'wppb-tmpl-addon-style-' + this.props.state.wppbForm.mainForm.addonName;
        }else if( type == 'row' ){
            selectorID = 'wppb-tmpl-row-style';
        }else if( type == 'column' ){
            selectorID = 'wppb-tmpl-col-style';
        }
        let styleTmpl = document.getElementById( selectorID );
        if (styleTmpl) {
            let styleData = styleTmpl.innerHTML
            if (styleData) {
                styleData = JSON.parse(styleData);
                __.forEach(selector, function (element) {
                    if (styleData[element + '_hide']) {
                        styleData[element] = styleData[element + '_hide']
                        delete styleData[element + '_hide']
                    }
                });
                document.getElementById( selectorID ).innerHTML = JSON.stringify(styleData)
            }
        }
    }

    render(){
        const { fieldsAttr, values } = this.props;
        let counter = 0,
            currentSection = '',
            sectionSeperator = this._fieldSectionGenerator( fieldsAttr );
        let typeAddon = this.props.state.wppbForm.mainForm.addonType;
        let selectorChange = [],
            selectorChange2 = [];

        return(
            <div className="wppb-tab-fields">
                {
                    __.map( sectionSeperator , (settings,key) => {
                        if( key == 'general' && __.size(settings) == 1 && settings.initialize_empty  ){
                            return
                        }
                        let fieldsHtml = this._renderSingleField( settings,values );

                        if( !__.isEmpty(fieldsHtml[1]) ){  selectorChange = selectorChange.concat( fieldsHtml[1] ) }
                        if( !__.isEmpty(fieldsHtml[2]) ){  selectorChange2 = selectorChange2.concat( fieldsHtml[2] ) }

                        if(__.isEmpty(__.compact(fieldsHtml[0]))){ return }
                        counter++;
                        if( counter == 1 && this.state.currentSection == 'initial' ){
                            currentSection = key
                        } else {
                            currentSection = this.state.currentSection
                        }

                        return(
                            <div key={ key } className="form-section">
                                <div className={'section-title ' + (currentSection == key ? 'active':'') } onClick = {(e) => { this._classEvents(key); }}>{__.startCase(key)}<div className="section-title-carat"><i className="fas fa-angle-down"/></div></div>
                                <div className={ 'section-content ' + (currentSection == key ? 'active':'') }>
                                    {fieldsHtml[0]}
                                </div>
                            </div>
                        )
                    })
                }
                { !__.isEmpty( selectorChange ) && ( typeAddon == 'row' || typeAddon == 'column' || typeAddon == 'addon' ) &&
                    this._removeSelector( selectorChange, typeAddon )
                }
                { !__.isEmpty( selectorChange2 ) && ( typeAddon == 'row' || typeAddon == 'column' || typeAddon == 'addon' ) &&
                    this._addSelector( selectorChange2, typeAddon )
                }
            </div>
        )
    }
}

const mapStateToProps = (state) => {
    return { state };
}

export default connect(
    mapStateToProps
)(FieldsRender);