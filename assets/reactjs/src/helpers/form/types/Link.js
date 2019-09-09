import React, {Component} from 'react'
import ToolTips from '../../ToolTips'

const changeValue = { link:'', window:0, nofolow:0 }

class Link extends Component {

  	componentWillMount(){
		const { input: { onChange,value } } = this.props
		let data = {}
		if( value ){
			if( __.isObject(value) ){
				data = __.clone(value)
			}else{
				data.link = value
			}
		}
      	onChange( Object.assign({},changeValue, data ) );
  	}

	onChangeHandle(type,event){
		const { input: { onChange,value } } = this.props
		let data = __.clone(value)
		if( type == 'link' ){ data.link = event.target.value }
		if( type == 'window' ){ data.window = ( event.target.value == 1 ? 0 : 1 ) }
		if( type == 'nofolow' ){ data.nofolow = ( event.target.value == 1 ? 0 : 1 ) }
		onChange( Object.assign({},changeValue, data) );
	}

	render(){
		const { input:{value}, params } = this.props
		let linkUrl = ( typeof value.link == 'function' ? value : value.link )
		let id1 = Math.round(Math.random( 1,1000 )*100)
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
			<div className="wppb-element-form-group wppb-element-link-checkbox2 wppb-element-form-checkbox">
				<input type="text" value={linkUrl} placeholder={params.placeholder} onChange={ this.onChangeHandle.bind(this,'link') } />
				{ linkUrl &&
					<span>
						<input id={id1} type="checkbox" value={( value.window ? value.window  : 0 )} checked={( value.window ? true : false )} onChange={ this.onChangeHandle.bind(this,'window') } /> <label htmlFor={id1}>{page_data.i18n.open_in_new_window}</label>
						<input id={id1+1} type="checkbox" value={( value.nofolow ? value.nofolow : 0 )} checked={( value.nofolow ? true : false )} onChange={ this.onChangeHandle.bind(this,'nofolow') } /> <label htmlFor={id1+1}>{page_data.i18n.nofollow}</label>
					</span>
				}
			</div>
		</div>
		)
	}
}

export default Link;