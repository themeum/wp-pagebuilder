import React, {Component} from 'react'
import AnimationList from './helpers/AnimationList'
import ReactSelect from 'react-select'
import Switch from './Switch'
import Slider from './Slider'
import ResponsiveManager from '../../../helpers/ResponsiveManager'
import ToolTips from '../../ToolTips'

class Animation extends Component {
    onChangeEvent( type,event ){
        const { input: { onChange,value } } = this.props
        let changeValue = {};
        
        switch (type) {
            case 'animation':
                changeValue.name = event.value
            break;
            case 'delay':
                changeValue.delay = event
            break;
            case 'duration':
                changeValue.duration = event
            break;
            case 'itemOpen':
                changeValue.itemOpen = event
            break;
            default:
            break;
        }
        onChange( Object.assign( { itemOpen:1, name: 'fadeIn', duration: '', delay: '' } ,value,changeValue ) );
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
                <div className="wppb-element-form-group wppb-element-form-animation">
                        <Switch
                            params={{title: ''}}
                            input={{
                                value: (input.value.itemOpen==1?1:0),
                                onChange: ((val) => { this.onChangeEvent( 'itemOpen',val )})
                            }} />

                    { input.value.itemOpen == 1 &&
                        <div>
                            <label>{page_data.i18n.name}</label>
                            <ReactSelect
                                name={ input.name }
                                value={ __.replace( ( input.value.name ?input.value.name:( ( params.std && params.std.name )  ?params.std.name:'')) , 'wow animated ', '') }
                                options={ AnimationList }
                                onChange={ this.onChangeEvent.bind( this,'animation' )}/>

                            <label>{page_data.i18n.delay}</label>
                            <Slider 
                                params={{ range:{ max: 5000,  min: 0 } ,  responsive: false }}
                                mediaDevice={ ResponsiveManager.device }
                                input={{
                                    value: ( input.value.delay ? input.value.delay : ( (params.std && params.std.delay) ?params.std.delay: '' ) ),
                                    onChange: ((val) => { this.onChangeEvent( 'delay', val ) })}}/>

                            <label>{page_data.i18n.duration}</label>
                            <Slider 
                                params={{ range:{ max: 10000,  min: 0 },  responsive: false }}
                                mediaDevice={ ResponsiveManager.device }
                                input={{
                                    value: ( input.value.duration ? input.value.duration : (  (params.std && params.std.duration) ?params.std.duration: '' ) ),
                                    onChange: ((val) => { this.onChangeEvent( 'duration', val ) })}}/>
                        </div>
                    }
                </div>
            </div>
        )
    }
}

export default Animation;