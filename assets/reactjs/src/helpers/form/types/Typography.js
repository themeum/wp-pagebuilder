import React, {Component} from 'react'
import Fontfamily from './helpers/Fontfamily'
import ReactSelect from 'react-select'
import Slider from './Slider'
import Switch from './Switch'
import ResponsiveManager from '../../../helpers/ResponsiveManager'
import ToolTips from '../../ToolTips'

const defaultFontStyle = [
    { value: 'normal', label: 'Normal' },
    { value: 'italic', label: 'Italic' },
    { value: 'oblique', label: 'Oblique' }
];
const defaultFontWeight = [
    { value: 100, label: '100' },
    { value: 200, label: '200' },
    { value: 300, label: '300' },
    { value: 400, label: '400' },
    { value: 500, label: '500' },
    { value: 600, label: '600' },
    { value: 700, label: '700' },
    { value: 800, label: '800' },
    { value: 900, label: '900' }
];
const defaultTextTransform = [
    { value: 'none', label: 'None' },
    { value: 'inherit', label: 'Inherit' },
    { value: 'capitalize', label: 'Capitalize' },
    { value: 'lowercase', label: 'Lowercase' },
    { value: 'uppercase', label: 'Uppercase' }
];
const defaultTextDecoration = [
  { value: 'none', label: 'None' },
  { value: 'inherit', label: 'Inherit' },
  { value: 'underline', label: 'Underline' },
  { value: 'overline', label: 'Overline' },
  { value: 'line-through', label: 'Line Through' } 
];

class Typography extends Component {
    
    _getWeight(){
        const { input:{value} } =  this.props
        return defaultFontWeight;
    }

    onClickHandle( val,type ){
        const { input: { onChange, value } } = this.props
        let changeValue = {}
        switch (type) {
            case 'fontFamily':
                changeValue.fontFamily = ( val ? val.value : '' )
                changeValue.fontType = ( val ? __.filter( Fontfamily, function(o) { return o.n == val.value; })[0].f : '' );
            break;
            case 'fontStyle':
                changeValue.fontStyle = ( val ? val.value : '' )
            break;
            case 'fontWeight':
                changeValue.fontWeight = ( val ? val.value : '' )
            break;
            case 'textTransform':
                changeValue.textTransform = ( val ? val.value : '' )
            break;
            case 'textDecoration':
                changeValue.textDecoration = ( val ? val.value : '' )
            break;
            case 'fontSize':
                changeValue.fontSize = val
            break;
            case 'lineHeight':
                changeValue.lineHeight = val
            break;
            case 'letterSpacing':
                changeValue.letterSpacing = val 
            break;
            case 'itemOpenFontStyle2':
                changeValue.itemOpenFontStyle2 = val
            break;
            default:
            break;
        }
        if( value ){
            onChange( Object.assign( {}, value, changeValue ) )
        } else {
            onChange( Object.assign( {}, { itemOpenFontStyle2:0 }, changeValue ) )
        }
    }


    render(){
        const { input, params } = this.props;
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
                <div className="wppb-element-form-group wppb-element-form-fontstyle2">
                        <Switch
                            params={{title: ''}}
                            input={{
                                value: (input.value.itemOpenFontStyle2==1?1:0),
                                onChange: ((val) => { this.onClickHandle( val,'itemOpenFontStyle2' )})}}/>
                    
                    { input.value.itemOpenFontStyle2 == 1 &&
                    <div>
                        <div className="wppb-builder-fontstyle2-spacing">
                            <label>{page_data.i18n.font_family}</label>
                            <ReactSelect
                                name={ input.name }
                                value={ input.value.fontFamily }
                                options={ __.map( Fontfamily , (e) => { return { value:e.n,label:e.n }; } ) }
                                onChange={ ((val) => { this.onClickHandle( val,'fontFamily' ) })}/>
                        </div>
                        <div className="wppb-builder-fontstyle2-spacing">
                            <Slider 
                                params={{ title: page_data.i18n.font_size , range:{ max: 400,  min: 0 },  responsive: true, unit: ['px','em','%'] }}
                                mediaDevice={ ResponsiveManager.device }
                                input={{
                                    value: input.value.fontSize,
                                    onChange: ((val) => { this.onClickHandle( val,'fontSize' ) })}}/>
                        </div>
                        <div className="wppb-builder-fontstyle2-spacing">
                            <Slider
                                params={{title: page_data.i18n.line_height , range:{ max: 400, min: 0 }, responsive: true, unit: ['px','em','%'] }} 
                                mediaDevice={ ResponsiveManager.device }
                                input={{
                                    value: input.value.lineHeight,
                                    onChange: ((val) => { this.onClickHandle( val,'lineHeight')})}}/>
                        </div>
                        <div className="wppb-builder-fontstyle2-spacing">
                            <Slider 
                                params={{ title: page_data.i18n.letter_spacing , range:{ max: 20,  min: -15 },  responsive: true, unit: ['px','em','%'] }}
                                mediaDevice={ ResponsiveManager.device }
                                input={{
                                    value: input.value.letterSpacing,
                                    onChange: ((val) => { this.onClickHandle( val,'letterSpacing' )})}} />
                        </div>
                        <div className="wppb-builder-fontstyle2-style">
                            <label>{page_data.i18n.font_style}</label>
                            <ReactSelect
                                name={ input.name }
                                value={ input.value.fontStyle }
                                options={ defaultFontStyle }
                                clearable = { true }
                                onChange={ ((val) => { this.onClickHandle( val,'fontStyle' )})}/>
                        </div>

                        <div className="wppb-builder-fontstyle2-weight">
                            <label>{page_data.i18n.font_weight}</label>
                            <ReactSelect
                                name={ input.name }
                                value={ input.value.fontWeight }
                                options={ this._getWeight() }
                                clearable = { true }
                                onChange={ ((val) => { this.onClickHandle( val,'fontWeight' )})}/>
                        </div>

                        <div className="wppb-builder-fontstyle2-transform">
                            <label>{page_data.i18n.text_transform}</label>
                            <ReactSelect
                                name={ input.name }
                                value={ input.value.textTransform }
                                options={ defaultTextTransform }
                                clearable = { true }
                                onChange={ ((val) => { this.onClickHandle( val,'textTransform' )})}/>
                        </div>
                        <div className="wppb-builder-fontstyle2-transform">
                            <label>{page_data.i18n.text_decoration}</label>
                            <ReactSelect
                                name={ input.name }
                                value={ input.value.textDecoration }
                                options={ defaultTextDecoration }
                                clearable = { true }
                                onChange={ ((val) => { this.onClickHandle( val,'textDecoration' )})}/>
                        </div>
                    </div>
                    }
                </div>
            </div>
        )
    }
}

export default Typography;
