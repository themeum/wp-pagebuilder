import React, {Component} from 'react'
import ResponsiveManager from '../../../helpers/ResponsiveManager'
import ToolTips from '../../ToolTips'

class Dimension extends Component {
    constructor(props){
        super(props)
        this.state = { lock: ( props.params.lock ? false : true ) }; 
    }

    componentDidMount(){
        const { input: { value }, params, mediaDevice } = this.props
        if( value ){
            if( params.responsive ){
                if( typeof value[mediaDevice] != 'undefined' &&
                    value[mediaDevice].top == value[mediaDevice].right &&
                    value[mediaDevice].right == value[mediaDevice].bottom &&
                    value[mediaDevice].bottom == value[mediaDevice].left ) {
                        this.setState( { lock: true } );
                }else{
                        this.setState( { lock: false } );
                }
            }else{
                if( params.autolock && ( params.autolock == 'notlock' ) ){
                    this.setState( { lock: false } );
                }else{
                    if( value.top == value.right &&
                        value.right == value.bottom &&
                        value.bottom == value.left ){
                            this.setState( { lock: true } );
                    }else{
                        this.setState( { lock: false } );
                    }
                }
            }
        }
    }
    
    onChangeValue(event) {
        const { input: { onChange,value }, params, mediaDevice } = this.props
        let dataUnit = 'px'
        let newVal = '';

        if( event.target.value === '' ){
            newVal = '';
            dataUnit = '';
        } else {
            newVal = event.target.value
        }
        
        let copyVal;
        if( params.responsive ) {
            if( this.state.lock ){
                copyVal = { [mediaDevice]: Object.assign({}, { 'top': newVal + dataUnit, 'right': newVal + dataUnit, 'bottom': newVal + dataUnit, 'left': newVal + dataUnit })}
            } else {
                if( value[mediaDevice] ){
                    copyVal = { [mediaDevice]: Object.assign( { 'top': ( value[mediaDevice].top ? value[mediaDevice].top : '' ) , 'right':( value[mediaDevice].right ? value[mediaDevice].right : '' ) ,'bottom': ( value[mediaDevice].bottom ? value[mediaDevice].bottom : '' ) ,'left': ( value[mediaDevice].left ? value[mediaDevice].left : '' ) } ,{ [event.target.getAttribute('data-direction')]: newVal + dataUnit }) }
                }else{
                    copyVal = { [mediaDevice]: Object.assign( { 'top': '' , 'right':'' ,'bottom': '' ,'left': '' } ,{ [event.target.getAttribute('data-direction')]: newVal + dataUnit }) }
                }
            }
        } else {
            if( this.state.lock ){
                copyVal = { 'top': newVal + dataUnit, 'right': newVal + dataUnit, 'bottom': newVal + dataUnit, 'left': newVal + dataUnit } 
            } else {
                copyVal = Object.assign( { 'top': ( value.top ? value.top : '' ) , 'right':( value.right ? value.right : '' )  ,'bottom':( value.bottom ? value.bottom : '' ) ,'left': ( value.left ? value.left : '' ) } , { [event.target.getAttribute('data-direction')]: newVal + dataUnit } );
            }
        }

        onChange( Object.assign({} , value, copyVal ) )
    }

    render(){
        const { input, params, mediaDevice } = this.props

        let data = ( params.responsive ? ( input.value ? input.value[mediaDevice] : ( params.std ? params.std[mediaDevice] : '0' ) ) : ( input.value ? input.value : ( params.std ? params.std : '0' ) ) );
            
        let dataUnit = 'px',
            dirTop = '',
            dirRight = '',
            dirBottom = '',
            dirLeft = '';

        if( data ){       
            dirTop =  __.replace( data.top , dataUnit , '' );
            dirRight = __.replace( data.right , dataUnit , '' );
            dirBottom = __.replace( data.bottom , dataUnit , '' );
            dirLeft = __.replace( data.left , dataUnit , '' );
        }

        return(
            <div className="wppb-builder-form-group wppb-builder-form-group-wrap">
                <span className="wppb-builder-form-group-title">
                    { params.title &&
                        <label>{ params.title }
                            { this.state.lock ? (
                                    <i className="fa fa-lock" onClick={e => { this.setState({ lock: !this.state.lock }); }}/>
                                ):(
                                    <i className="fa fa-unlock" onClick={e => { this.setState({ lock: !this.state.lock }); }}/>
                                )
                            }
                        </label>
                    }
                    { params.desc &&
                        <ToolTips desc={params.desc}/>
                    }
                </span>  
                { ( params.responsive || params.unit ) &&
                    <div className="wppb-builder-form-device-select-wrap wppb-builder-form-device-select-reverse">  
                        { params.responsive &&
                            <div className="wppb-builder-device-wrap">
                                <ul className={ 'wppb-builder-device wppb-builder-device-' + mediaDevice }>
                                    <li><i className="fa fa-laptop md" onClick={e => { ResponsiveManager.setDevice('md'); }}></i></li>
                                    <li><i className="fa fa-tablet sm" onClick={e => { ResponsiveManager.setDevice('sm'); }}></i></li>
                                    <li><i className="fa fa-mobile xs" onClick={e => { ResponsiveManager.setDevice('xs'); }}></i></li>
                                </ul>
                            </div>
                        }
                        { <div className="wppb-builder-form-select-device">px</div> }
                    </div>
                }
                <div className='wppb-element-form-group wppb-builder-form-device'>
                    <div className="wppb-box-element-item">
                        <input type='number' data-direction='top' value= { dirTop } onChange={ this.onChangeValue.bind( this ) } />
                        { params.label ? <span>{params.label.first}</span> : <span>{page_data.i18n.top}</span> }
                    </div>
                    <div className="wppb-box-element-item">
                        <input type='number' data-direction='right' value= { dirRight } onChange={this.onChangeValue.bind( this )} />
                        { params.label ? <span>{params.label.second}</span> : <span>{page_data.i18n.right}</span> }
                    </div>
                    <div className="wppb-box-element-item">
                        <input type='number' data-direction='bottom' value= { dirBottom } onChange={this.onChangeValue.bind( this )} />
                        { params.label ? <span>{params.label.third}</span>  : <span>{page_data.i18n.bottom}</span> }
                    </div>
                    <div className="wppb-box-element-item">
                        <input type='number' data-direction='left' value= { dirLeft } onChange={this.onChangeValue.bind( this )} />
                        { params.label ? <span>{params.label.fourth}</span> : <span>{page_data.i18n.left}</span> }
                    </div>
                </div>
            </div>
        )
    }
}

export default Dimension;