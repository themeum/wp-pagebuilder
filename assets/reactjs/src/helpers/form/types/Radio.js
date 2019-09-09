import React, {Component} from 'react'
import ToolTips from '../../ToolTips'

class Radio extends Component {

    onChangeHandle(event){
        const { input: { onChange } } = this.props
        let changeData = event.target.value;

        if( changeData ){
            onChange( changeData );
        }
    }

    render(){
        const { input,params } = this.props
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
                <div className='wppb-element-form-group wppb-element-form-radio-image'>
                    { params.values &&
                        __.map( params.values, (value,key)=>{
                            let checked = ( input.value == key ? true: false )
                            return(
                                <div key={key}>
                                    <label> <input type={'radio'} name={input.name} value={key} defaultChecked={checked} onClick={this.onChangeHandle.bind(this)} /> {value} </label>
                                </div>
                            )
                        })
                    }
                </div>
            </div>
        )
    }

}

export default Radio;
