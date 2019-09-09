import React, {Component} from 'react'
import ToolTips from '../../ToolTips'

class Switch extends Component {

    handChangeClick(e){
        const { input: { onChange,value } } = this.props
        if( value == 1 ){
            onChange(0);
        } else {
            onChange(1);
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
                <div className="wppb-builder-switch" onClick={ this.handChangeClick.bind(this) } >
                    <input className="wppb-builder-addon-input" type="checkbox" value={ input.value } />
                    <label>
                        <span>
                            <span></span>
                            <strong className="wppb-builder-switch-1">{page_data.i18n.disable}</strong>
                            <strong className="wppb-builder-switch-2">{page_data.i18n.enable}</strong>
                        </span>
                    </label>
                </div>
            </div>
        )
    }
}

export default Switch;
