import React, {Component} from 'react'
import ToolTips from '../../ToolTips'

class Checkbox extends Component {

    componentWillMount(){
        const { input: { onChange,value }, params } = this.props
        if( params.multiple ){
            if( value ){
                if( !__.isObject( value ) ){
                    onChange( [value] )
                }
            }
        }
    }

    handChangeClick(e){
        const { input: { onChange,value }, params } = this.props
        let selects = ( value ? __.clone(value) : [] )
        if( params.multiple ){
            if( !__.includes( value, e.target.value ) ){
                selects.push(e.target.value)
            }else{
                selects.splice(__.indexOf( selects, e.target.value ), 1);
            }
            onChange( selects )
        }else{
            onChange( e.target.value )
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
                <div className="wppb-element-form-group wppb-element-form-checkbox">
                    { this.props.params.values &&
                        __.map( this.props.params.values, (value, index)=>{
                            return ( <span key={index}> <input id={index} type="checkbox" checked={(__.includes( input.value , index ) ? true : false)} value={index} onChange={this.handChangeClick.bind(this)} /> <label htmlFor={index}>{value}</label></span> )
                        } )
                    }
                </div>
            </div>
        )
    }
}

export default Checkbox;
