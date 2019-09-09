import React, {Component} from 'react'
import ReactSelect from 'react-select'
import ResponsiveManager from '../../../helpers/ResponsiveManager'
import ToolTips from '../../ToolTips'

class Slider extends Component {
    onChangeValue(type, dataUnit, event){
        const { input: { onChange,value }, params } = this.props
        let dirObject = {}
        switch (type) {
            case 'slider':
                if( params.responsive ){
                    dirObject[this.props.mediaDevice] = event.target.value ? event.target.value + dataUnit : ''
                } else {
                    dirObject = event.target.value ? event.target.value + dataUnit : ''
                }
                break;
            case 'units':
                if( params.responsive ){
                    dirObject[this.props.mediaDevice] = __.replace( ( value ? value[this.props.mediaDevice] : '' ) , dataUnit , event.value )
                } else {
                    dirObject = dataUnit ? __.replace( value, dataUnit , event.value ) : ( value + event.value )
                }
                break;
            default:
                break;
        }
        if( params.responsive ){
            onChange( Object.assign( {}, value , dirObject ) )
        } else {
            onChange( dirObject )
        }
    }
    
    render(){
        const { input, params, mediaDevice } = this.props

        let data = ( params.responsive ? ( input.value ? input.value[mediaDevice] : ( params.std ? params.std[mediaDevice] : '' ) ) : ( input.value ? input.value : ( params.std ? params.std : '' ) ) );

        let dataUnit = '',
            dataVal = '';
        if( data ){
            dataUnit = __.replace( data , /[0-9-.]/g , '' );
            dataVal = __.replace( data , dataUnit , '' );
        }
        if( !dataUnit && params.unit ){ dataUnit = params.unit[0] }

        let min = 0, max = 1000, step = 1;
        if( params.range ){
            min = params.range[dataUnit] ? ( params.range[dataUnit].min ? params.range[dataUnit].min : 0 ) : ( params.range.min ? params.range.min : 0 )
            max = params.range[dataUnit] ? ( params.range[dataUnit].max ? params.range[dataUnit].max : 1000 ) : ( params.range.max ? params.range.max : 1000 )
            step = params.range[dataUnit] ? ( params.range[dataUnit].step ? params.range[dataUnit].step : 1 ) : ( params.range.step ? params.range.step : 1 )
        }
        return(
            <div className="wppb-builder-form-group wppb-builder-form-group-wrap">
                <span className="wppb-builder-form-group-title">
                    { params.title &&
                        <label>{ params.title }</label>
                    }
                    { params.desc &&
                        <ToolTips desc={params.desc} />
                    }
                </span>
                { ( params.responsive || params.unit ) &&
                    <div className="wppb-builder-form-device-select-wrap wppb-builder-form-device-select-reverse">
                        { params.responsive &&
                            <div className="wppb-builder-device-wrap">
                                <ul className={ 'wppb-builder-device wppb-builder-device-' + mediaDevice }>
                                    <li><i className="fa fa-laptop md" onClick={ () => { ResponsiveManager.setDevice('md'); }}/></li>
                                    <li><i className="fa fa-tablet sm" onClick={ () => { ResponsiveManager.setDevice('sm'); }}/></li>
                                    <li><i className="fa fa-mobile xs" onClick={ () => { ResponsiveManager.setDevice('xs'); }}/></li>
                                </ul>
                            </div>
                        }
                        { params.unit &&
                            <div className="wppb-builder-form-select-device wppb-builder-form-select-right">       
                                <ReactSelect
                                    name={ 'wppb-units-selector' }
                                    value={ dataUnit }
                                    disabled={ ( dataVal ? false : true ) }
                                    options={ __.map( params.unit , a => { return { label: a, value: a }}) }
                                    onChange={ (e) => this.onChangeValue( 'units', dataUnit, e ) }/>
                            </div>
                        }
                    </div>
                }
                <div className='wppb-element-form-group wppb-builder-form-device'>
                    <div className="wppb-builder-range">
                        <input value={ dataVal } max={max} min={min} step={step} type="range" onChange={ this.onChangeValue.bind(this,'slider',dataUnit) } />
                        { params.division && dataVal &&
                            <span className="wppb-gutter-range">{ dataVal * params.division }</span>
                        }
                        <input value={ dataVal } max={max} min={min} step={step} type="number" autoComplete="off" onChange={ this.onChangeValue.bind(this,'slider',dataUnit) } />                  
                    </div>
                </div>
            </div>
        )
    }

}

export default Slider;