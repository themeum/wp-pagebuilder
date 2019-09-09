import React, {Component} from 'react'
import ReactSelect from 'react-select'
import Switch from './Switch'
import Color from './Color'
import ToolTips from '../../ToolTips'
import ResponsiveManager from '../../../helpers/ResponsiveManager'
import Slider from './Slider'

const shapes = [
        { value: 'clouds-flat', label: 'Clouds Flat' },
        { value: 'clouds-opacity', label: 'Clouds Opacity' },
        { value: 'paper-torn', label: 'Paper Torn' },
        { value: 'pointy-wave', label: 'Pointy Wave' },
        { value: 'rocky-mountain', label: 'Rocky Mountain' },
        { value: 'single-wave', label: 'Single Wave' },
        { value: 'slope-opacity', label: 'Slope Opacity' },
        { value: 'slope', label: 'Slope' },
        { value: 'waves3-opacity', label: 'Waves3 Opacity' },
        { value: 'drip', label: 'Drip' },
        { value: 'turning-slope', label: 'Turning Slope' },
        { value: 'hill-wave', label: 'Hill Wave' },
        { value: 'hill', label: 'Hill' },
        { value: 'line-wave', label: 'Line Wave' },
        { value: 'swirl', label: 'Swirl' },
        { value: 'wavy-opacity', label: 'Wavy Opacity' },
        { value: 'zigzag-shark', label: 'Zigzag Shark' },
    ];
                    
class Shape extends Component {
    onChangeEvent( val ,type ){
        const { input: { onChange,value } } = this.props
        let changeValue = {};
        switch (type) {
            case 'itemOpenShape':
                changeValue.itemOpenShape = val
            break;
            case 'shapeStyle':
                changeValue.shapeStyle = val.value
            break;
            case 'shapeColor':
                changeValue.shapeColor = val
            break;
            case 'shapeWidth':
                changeValue.shapeWidth = val
            break;
            case 'shapeHeight':
                changeValue.shapeHeight = val
            break;
            case 'shapeFlip':
                changeValue.shapeFlip = val
            break;
            case 'shapeFront':
                changeValue.shapeFront = val
            break;
            default:
                break;
        }
        if( value ){
            onChange( Object.assign( {}, value, changeValue ) )
        } else {
            onChange( Object.assign( {}, { itemOpenShape: 0, shapeStyle: 'clouds-flat', shapeColor: '#0080FE', shapeWidth: '', shapeHeight: '', shapeFlip: 0, shapeFront: 0 }, changeValue ) )
        }
    }
    
    render(){
        const { input, params } = this.props
        return(
            <div className="wppb-builder-form-group wppb-builder-form-group-wrap">
                <span className="wppb-builder-form-group-title">
                    { params.title &&
                        <label>{ params.title }</label>
                    }
                    { params.desc &&
                        <ToolTips desc={params.desc}/>
                    }
                </span>
                <div className="wppb-element-form-group">
                    <Switch
                        params={{title: ''}}
                        input={{
                            value: (input.value.itemOpenShape==1?1:0),
                            onChange: ((val) => { this.onChangeEvent( val, 'itemOpenShape' )})
                        }} />

                    { input.value.itemOpenShape == 1 &&
                        <div className="wppb-element-form-shape-in">
                            <label>{page_data.i18n.style}</label>
                            <ReactSelect
                                name={ input.name }
                                value={  input.value.shapeStyle }
                                options={ shapes }
                                onChange={ (val) => this.onChangeEvent( val, 'shapeStyle' ) }/>

                            <Color
                                params={{title: page_data.i18n.color }}
                                input={{
                                    value:  input.value.shapeColor ,
                                    onChange: ( (val) => this.onChangeEvent( val, 'shapeColor' ) )
                                }}/>

                            <Slider
                                params={{ title: page_data.i18n.width , range:{ max: 1000,  min: 100 },  responsive: true }}
                                mediaDevice={ ResponsiveManager.device }
                                input={{
                                    value: ( input.value.shapeWidth ? input.value.shapeWidth : ( (params.std && params.std.shapeWidth) ?params.std.shapeWidth: '' ) ),
                                    onChange: ((val) => { this.onChangeEvent( val, 'shapeWidth' ) })}}/>

                            <Slider 
                                params={{ title: page_data.i18n.height , range:{ max: 1200,  min: 0 },  responsive: true }}
                                mediaDevice={ ResponsiveManager.device }
                                input={{
                                    value: ( input.value.shapeHeight ? input.value.shapeHeight : ( (params.std && params.std.shapeHeight) ?params.std.shapeHeight: '' ) ),
                                    onChange: ((val) => { this.onChangeEvent( val, 'shapeHeight' ) })}}/>

                            <Switch
                                params={{title: page_data.i18n.flip }}
                                input={{
                                    value: (input.value.shapeFlip==1?1:0),
                                    onChange: ((val) => { this.onChangeEvent( val, 'shapeFlip' )})
                                }} />

                            <Switch
                                params={{title: page_data.i18n.bring_to_front }}
                                input={{
                                    value: (input.value.shapeFront==1?1:0),
                                    onChange: ((val) => { this.onChangeEvent( val, 'shapeFront' )})
                                }} />

                        </div>
                    }
                </div>
            </div>
        )
    }
}

export default Shape;