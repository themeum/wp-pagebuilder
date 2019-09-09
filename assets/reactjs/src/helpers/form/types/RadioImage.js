import React, {Component} from 'react'
import ToolTips from '../../ToolTips'

class RadioImage extends Component {

    onChangeHandle(event){
        const { input: { onChange } } = this.props
        let changeData = event.target.getAttribute('data-value')
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
                            let active = ( input.value == key ? 'active': '' )
                            return(
                                <span className={active} key={key}><img onClick={this.onChangeHandle.bind(this)} data-value={key} src={value}/></span>
                            )
                        })
                    }
                </div>
            </div>
        )
    }

}

export default RadioImage;
