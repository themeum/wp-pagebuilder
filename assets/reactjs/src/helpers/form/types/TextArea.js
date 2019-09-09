import React, { Component } from 'react'
import ToolTips from '../../ToolTips'

class TextArea extends Component {
	onChangeHandle(event) {
			const { input: { onChange } } = this.props
			onChange(event.target.value);
	}
	render(){
		const { input, params } = this.props
		return (
			<div className="wppb-builder-form-group wppb-builder-form-group-wrap">
			<span className="wppb-builder-form-group-title">
				{ params.title &&
					<label>{params.title}</label>
				}
				{ params.desc &&
					<ToolTips desc={params.desc} />
				}
			</span>
				<div className='wppb-element-form-group'>
					<textarea {...input} placeholder={params.placeholder} className="wppb-builder-textarea" onChange={this.onChangeHandle.bind(this)} name={name}></textarea>
				</div>
			</div>
		)
	}
}

export default TextArea;
