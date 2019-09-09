import React, {Component} from 'react'
import SketchPicker from 'react-color'
import ReactSelect from 'react-select'
import Slider from './Slider'
import ResponsiveManager from '../../../helpers/ResponsiveManager'
import ToolTips from '../../ToolTips'

const defaultState = {
                bgFirst: '#16d03e', 
                bgSecond: '#1f91f3', 
                direction: '90', 
                startPosition: 5, 
                endPosition: 80 ,
                type: 'linear',
                radialValue: 'center',
                clip:false,
            };

// Static value for gradient type            
const typeOption = [
                { label:'Linear' , value:'linear' }, 
                { label:'Radial' , value:'radial' }
            ];

// Static value for radial Options for Gradient   
const radialOption = [
                { value:'center', label:'Center' },
                { value:'top left', label:'Top Left' },
                { value:'top', label:'Top' },
                { value:'top right', label:'Top Right' },
                { value:'right', label:'Right' },
                { value:'bottom right', label:'Bottom Right' },
                { value:'bottom', label:'Bottom' },
                { value:'bottom left', label:'Bottom Left' },
                { value:'left', label:'Left' },
            ];
            
class Gradient extends Component{
    constructor(props){
        super(props);
        this.state = { isOpenFirst: false, isOpenSecond: false }
    }

    componentWillMount(){
        const { input: { onChange,value }, params } = this.props
        onChange( Object.assign( {}, defaultState, ( params.clip ? { clip: params.clip } : {} ) ,value ) )
    }

    handleClose(){
        this.setState( { isOpenFirst:false, isOpenSecond:false } );
    }

    // Change Color
    handleChangeComplete( fields,color ){
        const { input: { onChange,value } } = this.props

        let mainColor = `rgba(${ color.rgb.r }, ${ color.rgb.g }, ${ color.rgb.b }, ${ color.rgb.a })`;
        if(color.rgb.a == 1){
            mainColor = color.hex;
        }
        onChange( Object.assign( {}, value , { [fields]: mainColor } ) );
    }

    // Change Slider
    sliderHandleChange(val, slider){
        const { input: { onChange,value } } = this.props
        onChange( Object.assign( {}, value, { [slider]: val } ) );
    }
    
    // Change Radial Type & Liniar/redial
    changeType(type,e){
        const { input: { onChange,value } } = this.props
        onChange( Object.assign( {}, value , { [type]: e.value } ))
    }

    render(){
        const { input: { value },params } = this.props
        let bg_f = value.bgFirst ? value.bgFirst : '#16d03e'
        let bg_s = value.bgSecond ? value.bgSecond : '#1f91f3'

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
                <div className="wppb-element-form-group wppb-element-form-gradient">
                    <div className="wppb-form-gradient-color" onClick={()=>{ this.setState( { isOpenFirst: !this.state.isOpenFirst, isOpenSecond: false } ) }} style={{ backgroundColor:this.state.bgFirst }} >
                        <span style={{height:'30px',width:'40px', backgroundColor: bg_f }}></span>
                        <span className="form-gradient-color-field">{bg_f}</span>
                    </div>
                    <div className="wppb-form-gradient-color" onClick={()=>{ this.setState( { isOpenSecond: !this.state.isOpenSecond, isOpenFirst: false } ) }} style={{ backgroundColor:this.state.bgSecond }}>
                        <span style={{height:'30px',width:'40px', backgroundColor: bg_s }}></span>
                        <span className="form-gradient-color-field">{bg_s}</span>
                    </div>
                    <div className="wppb-element-form-group">
                        { this.state.isOpenFirst &&
                            <div className="clearfix">
                                <div className={ 'gradient-cover' } onClick={ this.handleClose.bind(this) }></div>
                                <SketchPicker
                                    color={ bg_f }
                                    onChangeComplete={ this.handleChangeComplete.bind(this,'bgFirst') }
                                />
                            </div>
                        }
                        { this.state.isOpenSecond &&
                            <div className="clearfix">
                                <div className={ 'gradient-cover' } onClick={ this.handleClose.bind(this) }></div>
                                <SketchPicker
                                    color={ bg_s }
                                    onChangeComplete={ this.handleChangeComplete.bind(this,'bgSecond') }
                                />
                            </div>
                        }
                    </div>

                    <div className="form-gradient-type-field">
                        <label>{page_data.i18n.gradient_type}</label>
                        <ReactSelect
                            value={value.type}
                            clearable={false}
                            options={typeOption}
                            onChange={this.changeType.bind(this,'type')}
                            />
                    </div> 


                    { value.type == 'radial' ?
                        <ReactSelect
                            value={value.radialValue}
                            clearable={false}
                            options={radialOption}
                            onChange={this.changeType.bind(this,'radialValue')}/>
                        :
                        <span>
                            <label>{page_data.i18n.gradient_direction}:</label>
                            <Slider 
                                params={{ range: { max: 360, min: 0 } }}
                                mediaDevice={ ResponsiveManager.device }
                                input={{
                                    value: value.direction, 
                                    onChange: ((val) => { this.sliderHandleChange(val, 'direction')})
                                    }} />
                        </span>
                    }

                    <label>{page_data.i18n.start_position}:</label>
                    <Slider 
                        params={{ range: { max: 100, min: 0 } }}
                        mediaDevice={ ResponsiveManager.device }
                        input={{
                            value: value.startPosition,
                            onChange: ((val) => { this.sliderHandleChange(val, 'startPosition')})
                            }} />
    
                    <label>{page_data.i18n.end_position}:</label>
                    <Slider 
                        params={{ range: {max: 100, min: 0} }}
                        mediaDevice={ ResponsiveManager.device }
                        input={{
                            value: value.endPosition,
                            onChange: ((val) => { this.sliderHandleChange(val, 'endPosition')})
                            }} />
                </div>
            </div>
        );
    }
}

export default Gradient;