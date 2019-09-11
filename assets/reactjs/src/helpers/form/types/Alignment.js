import React, {Component} from 'react'
import ToolTips from '../../ToolTips'
import ResponsiveManager from '../../../helpers/ResponsiveManager'

class Alignment extends Component {   
    onClickHandle(type){
        const { input:{ onChange, value } , params, mediaDevice } = this.props
        if(  params.responsive ){
            let dirObject = {}
            dirObject[mediaDevice] = type
            if( typeof value === "object" ){
                onChange( Object.assign( {}, value , dirObject ) )
            }else{
                onChange( Object.assign( {} , dirObject ) )
            }
        }else{
            onChange(type);
        }
    }
    cssSelector( data ){
        const { input , params, mediaDevice } = this.props
        let currentVal = ( params.responsive ? ( input.value ? input.value[mediaDevice] : ( params.std ? params.std[mediaDevice] : '' ) ) : ( input.value ? input.value : ( params.std ? params.std : '' ) ) );
        if( params.responsive ){
            if( currentVal == data ){
                return 'wppb-alignment active' 
            }else{
                return 'wppb-alignment' 
            }
        } else {
            if( currentVal == data ){
                return 'wppb-alignment active' 
            }else{
                return 'wppb-alignment' 
            }
        }
    }
    render(){
        const { params, mediaDevice } = this.props
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
                <div className="wppb-builder-form-group-wrap">
                    { params.responsive &&
                        <div className="wppb-builder-device-wrap">
                            <ul className={ 'wppb-builder-device wppb-builder-device-' + mediaDevice }>
                                <li><i className="fas fa-laptop md" onClick={ () => ResponsiveManager.setDevice('md') }/></li>
                                <li><i className="fas fa-tablet-alt sm" onClick={ () => ResponsiveManager.setDevice('sm') }/></li>
                                <li><i className="fas fa-mobile-alt xs" onClick={ () => ResponsiveManager.setDevice('xs') }/></li>
                            </ul>
                        </div>
                    }
                    <div className="wppb-element-form-group-align">
                        <div onClick={ () => this.onClickHandle('left') } className={ this.cssSelector('left') }>
                            <span><i className={ 'fas fa-align-left' }/></span>
                        </div>
                        <div onClick={ () => this.onClickHandle('center') } className={ this.cssSelector('center') }>
                            <span><i className={ 'fas fa-align-center' }/></span>
                        </div>
                        <div onClick={ () => this.onClickHandle('right') } className={ this.cssSelector('right') }>
                            <span><i className={ 'fas fa-align-right' }/></span>
                        </div>
                        <div onClick={ () => this.onClickHandle('justify') } className={ this.cssSelector('justify') }>
                            <span><i className={ 'fas fa-align-justify' }/></span>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Alignment;
