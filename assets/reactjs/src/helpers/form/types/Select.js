import React, { Component } from 'react'
import ReactSelect from 'react-select'
import ToolTips from '../../ToolTips'
import ResponsiveManager from '../../../helpers/ResponsiveManager'

class Select extends Component {
	constructor(props) {
		super(props);
	}

	valueChange(val) {
		const { input: { onChange, value }, params, mediaDevice } = this.props
		if(  params.responsive ){
			let dirObject = {}
			if( params.multiple ){
				dirObject[mediaDevice] =  __.map( val , n => { return n.value } )
			}else{
				dirObject[mediaDevice] = val.value
			}
            onChange( Object.assign( {}, value,  dirObject ) )
		}else{
			if (val == null) {
				onChange('')
			} else if (typeof val.length != 'undefined') {
				let arrayVal = [];
				for (var i = 0; i < val.length; i++) {
					arrayVal[i] = val[i].value;
				}
				onChange(arrayVal);
			} else {
				onChange(val.value);
			}
		}
	}

	render() {
		const { input, params, mediaDevice } = this.props

		let currentVal = ''
		if( input.value ){
			if( params.multiple ){
				if( params.responsive ){
					currentVal = __.split( input.value[mediaDevice], ',' )
				}else{
					currentVal = __.split( input.value, ',' )
				}
			}else{
				if( params.responsive ){
					currentVal = input.value[mediaDevice]
				}else{
					currentVal = input.value
				}
			}
		}else{
			if( params.std ){
				if( params.multiple ){
					if( params.responsive ){
						currentVal = __.split( params.std[mediaDevice] , ',' )
					}else{
						currentVal = __.split( params.std, ',' )
					}
				}else{
					if( params.responsive ){
						currentVal = params.std[mediaDevice]
					}else{
						currentVal = params.std
					}
				}
			}else{
				currentVal = ''
			}
		}

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
					{ params.responsive &&
						<div className="wppb-builder-device-wrap">
							<ul className={ 'wppb-builder-device wppb-builder-device-' + mediaDevice }>
								<li><i className="fas fa-laptop md" onClick={ () => ResponsiveManager.setDevice('md') }/></li>
								<li><i className="fas fa-tablet-alt sm" onClick={ () => ResponsiveManager.setDevice('sm') }/></li>
								<li><i className="fas fa-mobile-alt xs" onClick={ () => ResponsiveManager.setDevice('xs') }/></li>
							</ul>
						</div>
					}
					<ReactSelect
						name = {input.name}
						value = {currentVal}
						placeholder = {params.placeholder}
						multi = {params.multiple}
						options = {__.map(params.values, (label, val) => { return { value: val, label: label }; })}
						onChange = {this.valueChange.bind(this)} />
				</div>
			</div>
		)
	}
}

export default Select;
