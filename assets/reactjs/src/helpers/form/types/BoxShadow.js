import React, {Component} from 'react'
import Dimension from './Dimension'
import Switch from './Switch'
import Color from './Color'
import ToolTips from '../../ToolTips'

class BoxShadow extends Component {

    onChangeEvent(val,type){
        const { input: { onChange,value } } = this.props
        let changeValue = {};
        switch (type) {
            case 'shadowValue':
                changeValue.shadowValue = val
            break;
            case 'shadowColor':
                changeValue.shadowColor =  val
            break;
            case 'itemOpenShadow':
                changeValue.itemOpenShadow = val
            break;
        }
        if( value ){
            onChange( Object.assign( {}, value, changeValue ) )
        } else {
            onChange( Object.assign( {}, { itemOpenShadow:1, shadowValue:{top:'0px',right:'0px',bottom:'5px',left:'0px'}, shadowColor:'#000000' }, changeValue ) )
        }
    }

    render() {
        const { input: { value }, params } = this.props

        return (
            <div className="wppb-builder-form-group wppb-builder-form-group-wrap wppb-builder-form-multi-group">
                <span className="wppb-builder-form-group-title">
                    { params.title &&
                        <label>{ params.title }</label>
                    }
                    { params.desc &&
                        <ToolTips desc={params.desc}/>
                    }
                </span>    
                <div className="wppb-element-form-group wppb-element-form-boxshadow">
                    <Switch
                        params={{title: ''}}
                        input={{
                            value: (value.itemOpenShadow==1?1:0),
                            onChange: ((val) => { this.onChangeEvent( val,'itemOpenShadow' )})}}/>
                        
                    { value.itemOpenShadow == 1 &&
                        <div>
                            <Dimension 
                                params={{ responsive:false, autolock: 'notlock' , label:{first: page_data.i18n.horizontal ,second: page_data.i18n.vertical ,third:page_data.i18n.blur ,fourth:page_data.i18n.spread } }}
                                input={{
                                    value: value.shadowValue ,
                                    onChange: ((val) => { this.onChangeEvent( val,'shadowValue' )})}} />
                            <Color
                                params={{title: page_data.i18n.color }}
                                input={{
                                    value:  value.shadowColor ,
                                    onChange: ( (val) => this.onChangeEvent( val,'shadowColor' ))}}/>
                        </div>
                    }
                </div>
            </div>
        )
    }
}

export default BoxShadow;