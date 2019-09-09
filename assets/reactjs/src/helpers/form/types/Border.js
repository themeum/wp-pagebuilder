import React, {Component} from 'react'
import ReactSelect from 'react-select'
import Dimension from './Dimension'
import Switch from './Switch'
import Color from './Color'
import ToolTips from '../../ToolTips'

const types = [
        { value: 'none', label: 'None' },
        { value: 'solid', label: 'Solid' },
        { value: 'dotted', label: 'Dotted' },
        { value: 'dashed', label: 'Dashed' },
        { value: 'double', label: 'Double' } ];

class Border extends Component {

    onChangeEvent( val ,type ){
        const { input: { onChange,value } } = this.props
        let changeValue = {}
        switch (type) {
            case 'borderColor':
                changeValue.borderColor = val
            break;
            case 'borderStyle':
                changeValue.borderStyle = val.value
            break;
            case 'borderWidth':
                changeValue.borderWidth = val
            break;
            case 'itemOpenBorder':
                changeValue.itemOpenBorder = val
            break;
            default:
                break;
        }
        if( value ){
            onChange( Object.assign( {}, value, changeValue ) )
        } else {
            onChange( Object.assign( {}, { borderWidth:{top:'1px',right:'1px',bottom:'1px',left:'1px'}, itemOpenBorder:1, borderStyle:'solid', borderColor:'#f5f5f5' }, changeValue ) )
        }
    }
    
    render(){
        const { input, params } = this.props
        return(
            <div className="wppb-builder-form-group wppb-builder-form-group-wrap wppb-builder-form-multi-group">
                <span className="wppb-builder-form-group-title">
                    { params.title &&
                        <label>{ params.title }</label>
                    }
                    { params.desc &&
                        <ToolTips desc={params.desc}/>
                    }
                </span>
                <div className="wppb-element-form-group wppb-element-form-border">
                    <Switch
                        params={{title: ''}}
                        input={{
                            value: (input.value.itemOpenBorder==1?1:0),
                            onChange: ((val) => { this.onChangeEvent( val, 'itemOpenBorder' )})
                        }} />

                    { input.value.itemOpenBorder == 1 &&
                        <div className="wppb-element-form-border-in">
                            <label>{page_data.i18n.style}</label>
                            <ReactSelect
                                name={ input.name }
                                value={  input.value.borderStyle }
                                options={ types }
                                onChange={ (val) => this.onChangeEvent( val, 'borderStyle' ) }/>

                            <Dimension 
                                params={{ title: 'Width', responsive:false, autolock: 'notlock', label:{first:'Top',second:'Right',third:'Bottom',fourth:'Left'} }}
                                input={{
                                    value: input.value.borderWidth ,
                                    onChange: ((val) => { this.onChangeEvent( val, 'borderWidth' )})
                                }} />
                                
                            <Color
                                params={{title: 'Color'}}
                                input={{
                                    value:  input.value.borderColor ,
                                    onChange: ( (val) => this.onChangeEvent( val, 'borderColor' ) )
                                }}/>
                        </div>
                    }
                </div>
            </div>
        )
    }
}

export default Border;