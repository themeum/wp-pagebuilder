import React, {Component} from 'react'
import Slider from './Slider'
import Switch from './Switch'
import ToolTips from '../../ToolTips'

class Filter extends Component {

    onClickHandle(val,type){
        const { input: { onChange,value } } = this.props
        let changeValue = {};
        if( type ){
            changeValue[type] = val
        }
        if( value ){
            onChange( Object.assign( {}, value, changeValue ) )
        } else {
            onChange( Object.assign( {}, { itemOpenFilter:0 } , changeValue ) )
        }
    }

    resetValue(){
        this.props.input.onChange( { itemOpenFilter:1 } )
    }

    render() {
        const { input: { value }, params } = this.props
        return (
            <div className="wppb-builder-form-group wppb-builder-form-group-wrap wppb-builder-form-multi-group ">
                <span className="wppb-builder-form-group-title">
                    { params.title &&
                        <label>{ params.title }</label>
                    }
                    { params.desc &&
                        <ToolTips desc={params.desc}/>
                    }
                </span>    
                <div className="wppb-element-form-group wppb-element-form-filter">
                    <Switch
                        params={{title: ''}}
                        input={{
                            value: (value.itemOpenFilter==1?1:0),
                            onChange: ((val) => { this.onClickHandle( val,'itemOpenFilter' )})}}/>
                        
                    { value.itemOpenFilter == 1 &&
                        <div>
                            <button className="wppb-reset-filter" onClick={ () => this.resetValue() }><i className="wppb-font-undo-arrow"></i></button>
                            <Slider 
                                params={{ title: page_data.i18n.brightness , range:{ max: 200,  min: 0 }, unit: ['%'] }}
                                input={{
                                    value : value.brightness,
                                    onChange: ((val) => { this.onClickHandle( val,'brightness' ) })}}/>

                            <Slider 
                                params={{ title: page_data.i18n.contrast , range:{ max: 200,  min: 0 }, unit: ['%'] }}
                                input={{
                                    value : value.contrast,
                                    onChange: ((val) => { this.onClickHandle( val,'contrast' ) })}}/>
                            <Slider 
                                params={{ title: page_data.i18n.grayscale , range:{ max: 100,  min: 0 }, unit: ['%'] }}
                                input={{
                                    value : value.grayscale,
                                    onChange: ((val) => { this.onClickHandle( val,'grayscale' ) })}}/>
                            <Slider 
                                params={{ title: page_data.i18n.invert , range:{ max: 100,  min: 0 }, unit: ['%'] }}
                                input={{
                                    value : value.invert,
                                    onChange: ((val) => { this.onClickHandle( val,'invert' ) })}}/>
                            <Slider 
                                params={{ title: page_data.i18n.hue_rotate , range:{ max: 360,  min: 0 }, unit: ['deg'] }}
                                input={{
                                    value : value.huerotate,
                                    onChange: ((val) => { this.onClickHandle( val,'huerotate' ) })}}/>   
                            <Slider 
                                params={{ title: page_data.i18n.saturate , range:{ max: 100,  min: 0 }, unit: ['%'] }}
                                input={{
                                    value : value.saturate,
                                    onChange: ((val) => { this.onClickHandle( val,'saturate' ) })}}/>
                            <Slider 
                                params={{ title: page_data.i18n.sepia , range:{ max: 100,  min: 0 }, unit: ['%'] }}
                                input={{
                                    value : value.sepia,
                                    onChange: ((val) => { this.onClickHandle( val,'sepia' ) })}}/>
                            
                        </div>
                    } 
                </div>
            </div>
        )
    }
}

export default Filter;