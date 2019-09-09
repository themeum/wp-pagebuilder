import React, {Component} from 'react'
import Gradient from './Gradient'
import Color from './Color'
import ToolTips from '../../ToolTips'

let defaultData = {
	colorType: 'color',
	colorColor: '',
	colorGradient: {},
	clip: false
}

class Color2 extends Component {

	componentWillMount(){
		const { input: { onChange, value } } = this.props
		if( this.props.params.clip ){
			onChange( Object.assign( {}, defaultData, { clip: true }, ( value ? value : {} ) ) );
		}else{
			onChange( Object.assign( {}, defaultData, ( value ? value : {} ) ) );
		}
	}

	onChangeType(type, val){
		const { input: { onChange, value } } = this.props;
		onChange( Object.assign( {}, value, { [type]: val } ) );
	}

	render(){
		const { input: { value }, params } = this.props;
		let activeTab = ( value.colorType == 'gradient' ? 'gradient' : 'color' )
		return(
			<div className='wppb-builder-form-group wppb-builder-form-group-wrap'>
				<span className="wppb-builder-form-group-title">
					{ params.title &&
						<label>{ params.title }</label>
					}
					{ params.desc &&
						<ToolTips desc={params.desc}/>
					}
				</span>
				<div className={'wppb-element-form-background'}>
					
					<div className="btn-toolbar">
						<span className="btn-group">
							<label className={ activeTab == 'color' ? 'active' : '' } onClick={ ()=>this.onChangeType('colorType','color') }>{page_data.i18n.color}</label>
							<label className={ activeTab == 'gradient' ? 'active' : '' } onClick={ ()=>this.onChangeType('colorType','gradient') }>{page_data.i18n.gradient}</label>
						</span>
					</div>

					{ activeTab === 'color' &&
						<div className="wppb-builder-background-color">
							<Color
								params={{title: ''}}
								input={{
									value: value.colorColor,
									onChange: ( value => this.onChangeType( 'colorColor', value ) )
								}}
							/>
						</div>
					}
					
					{ activeTab === 'gradient' &&
						<div className="wppb-builder-background-gradient">
							<Gradient
								params={{title: ''}}
								input={{
									value: value.colorGradient,
									onChange: ( value => this.onChangeType( 'colorGradient', value ) )
								}}
							/>
						</div>
					}
				</div>

			</div>
		)
	}
}

export default Color2;