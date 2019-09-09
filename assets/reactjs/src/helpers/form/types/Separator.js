import React, { Component } from 'react'
import ToolTips from '../../ToolTips'

class Separator extends Component {
	render() {
		const { params } = this.props
		return (
			<div className="wppb-builder-form-group">
				<p className="wppb-builder-separator">
					{params.title &&
						<span>{params.title}</span>
					}
					{params.desc &&
						<ToolTips desc={params.desc} />
					}
				</p>
			</div>
		)
	}
}
export default Separator;
