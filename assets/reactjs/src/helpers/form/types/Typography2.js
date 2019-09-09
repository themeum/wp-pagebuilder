import React, {Component} from 'react'
import ReactSelect from 'react-select'
import Switch from './Switch'
import ToolTips from '../../ToolTips'

const options = [ 
                  { value: '', label: 'Default' },
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

class Typography extends Component {
    onClickHandle(val,type){
        const { input: { onChange,value } } = this.props
        let changeValue = {};

        switch (type) {
            case 'textDecoration':
                changeValue.textDecoration = ( value.textDecoration ? '' : val )
            break;
            case 'fontStyle':
                changeValue.fontStyle = ( value.fontStyle ? '' : val )
            break;
            case 'textTransform':
                changeValue.textTransform = ( value.textTransform ? '' : val )
            break;
            case 'fontWeight':
                changeValue.fontWeight = val.value
            break;
            case 'itemOpenFontStyle':
                changeValue.itemOpenFontStyle = val
            break;
        }
        if( value ){
            onChange( Object.assign( {}, value, changeValue ) )
        } else {
            onChange( Object.assign( {}, { itemOpenFontStyle:0 }, changeValue ) )
        }
    }

    render(){
        const { input:{value} , params } = this.props;
        
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
            <div className="wppb-element-form-group wppb-element-form-fontstyle">
                <Switch
                    params={{title: ''}}
                    input={{
                        value: (value.itemOpenFontStyle==1?1:0),
                        onChange: ((val) => { this.onClickHandle( val,'itemOpenFontStyle' )})
                    }} />

                { value.itemOpenFontStyle == 1 &&
                    <div>
                        <div className={ "wppb-fontstyle-weight" }>
                            <ReactSelect
                                name="form-fontstyle-weight"
                                value={ value.fontWeight }
                                options={ options }
                                clearable = { false }
                                onChange={ (val) => this.onClickHandle( val, 'fontWeight' ) } />
                        </div>
                        <div className={ (value.textDecoration ? 'active element-form-fontstyle' : 'element-form-fontstyle') }>
                            <span onClick={ () => { this.onClickHandle( 'underline','textDecoration' )} } className="wppb-fontstyle-underline">T</span>
                        </div>

                        <div className={ (value.fontStyle ? 'active element-form-fontstyle' : 'element-form-fontstyle') }>
                            <span onClick={ () => { this.onClickHandle( 'italic','fontStyle' )} } className="wppb-fontstyle-italic">I</span>
                        </div>

                        <div className={ (value.textTransform ? 'active element-form-fontstyle' : 'element-form-fontstyle') }>
                            <span onClick={ () => { this.onClickHandle( 'uppercase','textTransform' )} } className="wppb-fontstyle-uppercase">TT</span>
                        </div>
                    </div>
                }

            </div>
        </div>
        )
    }
}

export default Typography;