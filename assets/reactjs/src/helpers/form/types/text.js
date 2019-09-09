import React, {Component} from 'react'
import ToolTips from '../../ToolTips'

class Text extends Component {
	onChangeHandle(event){
		const { input: { onChange } } = this.props
		onChange(event.target.value);
	}
	
	render(){
		const { input, params } = this.props
		return(
			<div className="wppb-builder-form-group wppb-builder-form-group-wrap">
				<span className="wppb-builder-form-group-title">
					{ params.title &&
						<label>{ params.title } </label>
					}
					{ params.desc &&
						<ToolTips desc={params.desc} />
					}
				</span>
				<div className='wppb-element-form-group'>
					<input {...input} type="text" placeholder={params.placeholder} className="wppb-builder-text" autoComplete="off" onChange={ this.onChangeHandle.bind(this) } />
				</div>
			</div>
		)
	}
}

export default Text;