import React, {Component} from 'react'
import { imagePosition, imageAttachment, imageRepeat, imageSize } from '../Common'
import ReactSelect from 'react-select'
import Gradient from './Gradient'
import Select from './Select'
import Color from './Color'
import Media from './Media'
import ToolTips from '../../ToolTips'

let defaultData = {
				bgType: 'color',
				bgColor: '',
				bgImage: {},
				bgimgPosition: '',
				bgimgAttachment: '',
				bgimgRepeat: '',
				bgimgSize: '',
				bgDefaultColor: '',
				bgGradient: {},
				videoType: 'local',
				bgVideo: {},
				bgExternalVideo: '',
				bgVideoFallback:{},

				bgHoverType: 'color',
				bgHoverColor: '',
				bgHoverImage: {},
				bgHoverimgPosition: '',
				bgHoverimgAttachment: '',
				bgimgHoverRepeat: '',
				bgimgHoverSize: '',
				bgHoverDefaultColor: '',
				bgHoverGradient: {},
				};

class Background extends Component {
	constructor(props){
		super(props);
		this.state = { openBg: true }
	}

	componentWillMount(){
		const { input: { onChange,value } } = this.props
		onChange( Object.assign( {}, defaultData, ( value ? value : {} ) ));
	}

	onChangeHandle(currentValue, type){
		const { input: { onChange,value } } = this.props;
		onChange( Object.assign( {}, defaultData, value , { [type]:currentValue } ) );
	}

	onChangeType(type,val){
		const { input: { onChange,value } } = this.props;
		onChange( Object.assign( {}, defaultData, value , { [type]: val } ) );
	}

	render(){
		const { input: { value,name }, params } = this.props;
		const openBg    = this.state.openBg
		const typeVar   = openBg ? value.bgType : value.bgHoverType
		let activeTab = ( typeVar == 'gradient' ? 'gradient' : ( typeVar == 'image' ? 'image': ( typeVar == 'video' ? 'video' : 'color' ) ) )
		
		return(
			<div className='wppb-builder-form-group wppb-builder-form-group-wrap wppb-builder-form-multi-group'>
				<span className="wppb-builder-form-group-title">
					{ params.title &&
						<label>{ params.title }</label>
					}
					{ params.desc &&
						<ToolTips desc={params.desc}/>
					}
				</span>	
				<div className={'wppb-element-form-background'+( ( openBg && params.video ) ? ' wppb-form-video' : '' )}>
					
					{ this.props.params.disableHover ?
						null
						:
						<span>
							<span className={'wppb-background-type' + ( openBg ? ' active' : '' ) } onClick={ () => { this.setState( { openBg: true } ) } }>{page_data.i18n.background}</span>
							<span className={'wppb-background-type' + ( openBg ? '' : ' active' )} onClick={ () => { this.setState( { openBg: false } ) } }>{page_data.i18n.hover}</span>
						</span>
					}

					<div className="btn-toolbar">
						<span className="btn-group">
							<label className={ activeTab == 'color' ? 'active' : '' } onClick={ ()=>this.onChangeType( ( openBg ? 'bgType' : 'bgHoverType' ) , 'color' ) }>{page_data.i18n.color}</label>
							<label className={ activeTab == 'image' ? 'active' : '' } onClick={ ()=>this.onChangeType( ( openBg ? 'bgType' : 'bgHoverType' ) , 'image' ) }>{page_data.i18n.image}</label>
                            <label className={ activeTab == 'gradient' ? 'active' : '' } onClick={ ()=>this.onChangeType( ( openBg ? 'bgType' : 'bgHoverType' ) , 'gradient' ) }>{page_data.i18n.gradient}</label>
							{ openBg && params.video &&
                            	<label className={ activeTab == 'video' ? 'active' : '' } onClick={ ()=>this.onChangeType( ( openBg ? 'bgType' : 'bgHoverType' ) , 'video' ) }>{page_data.i18n.video}</label>
							}
						</span>
					</div>


					{ activeTab == 'color' &&
					<div className="wppb-builder-background-color">
						<Color
							params={{title: ''}}
							input={{
								value: ( openBg ? value.bgColor : value.bgHoverColor ),
								onChange: ( (value) => this.onChangeHandle(value, ( openBg ? 'bgColor' : 'bgHoverColor' )) )
							}}
						/>
					</div>
					}

					{ activeTab == 'image' &&
						<div className="wppb-element-form-group wppb-builder-background-image">
							<Media
								params={{title: '',btnName: ''}}
								input={{
									value: (  openBg ? value.bgImage : value.bgHoverImage ), 
									onChange: ( (val) => this.onChangeHandle(val, ( openBg ? 'bgImage' : 'bgHoverImage' ))  )}}/>
							<Color
								params={{title: 'Image Background Color'}}
								input={{
								value: ( openBg ? value.bgDefaultColor : value.bgHoverDefaultColor ),
									onChange: ( (value) => this.onChangeHandle(value, ( openBg ? 'bgDefaultColor' : 'bgHoverDefaultColor' )) ) }} />

							<label>{page_data.i18n.position}</label>
							<ReactSelect
								name={ name }
								value={ openBg ? value.bgimgPosition : value.bgHoverimgPosition }
								options={ imagePosition }
								clearable = { false }
								onChange={ (val) => this.onChangeHandle( val.value, ( openBg ? 'bgimgPosition' : 'bgHoverimgPosition' ) ) }/>

							<label>{page_data.i18n.attachment}</label>
							<ReactSelect
								name={ name }
								value={  openBg ? value.bgimgAttachment : value.bgHoverimgAttachment }
								options={ imageAttachment }
								clearable = { false }
								onChange={ (val) => this.onChangeHandle( val.value, ( openBg ? 'bgimgAttachment' : 'bgHoverimgAttachment' ) ) }/>

							<label>{page_data.i18n.repeat}</label>
							<ReactSelect
								name={ name }
								value={ openBg ? value.bgimgRepeat : value.bgimgHoverRepeat }
								options={ imageRepeat }
								clearable = { false }
								onChange={ (val) => this.onChangeHandle( val.value, ( openBg ? 'bgimgRepeat' : 'bgimgHoverRepeat' ) ) }/>

							<label>{page_data.i18n.size}</label>
							<ReactSelect
								name={ name }
								value={ openBg ? value.bgimgSize : value.bgimgHoverSize }
								options={ imageSize }
								clearable = { false }
								onChange={ (val) => this.onChangeHandle( val.value, ( openBg ? 'bgimgSize' : 'bgimgHoverSize' ) ) }/>
						</div>
					}
					
					{ activeTab == 'gradient' &&
						<div className="wppb-builder-background-gradient">
							<Gradient
								params={{title: ''}}
								input={{
									value: ( openBg ? value.bgGradient : value.bgHoverGradient ),
									onChange: ( (val) => this.onChangeHandle(val, ( openBg ? 'bgGradient' : 'bgHoverGradient' )) )
								}}
							/>
						</div>
					}

					{ ( params.video && activeTab == 'video' && openBg ) &&
						<div className="wppb-builder-background-video">
							
							<Select
								params={{title: page_data.i18n.type , values: { local:'Local', external:'External' }, multiple: false, std: 'local' }}
								input={{
									value: value.videoType,
									onChange: ( (val) => this.onChangeHandle( val, 'videoType' ) )
									}}
								/>

							{ ( value.videoType == 'local' ) ?
								<Media
									params={{title: page_data.i18n.video ,btnName: page_data.i18n.upload_video }}
									input={{
										value: value.bgVideo, 
										onChange: ( (val) => this.onChangeHandle( val,'bgVideo' ))}}
								/>
							:
							<span>
								<label>{page_data.i18n.url}</label>
								<input type="text" autoComplete="off" value={ value.bgExternalVideo } onChange={ ( (val) => this.onChangeHandle( val.target.value, 'bgExternalVideo' ) ) } />
							</span>
							}

							<Media
								params={{title: page_data.i18n.fallback_image ,btnName: ''}}
								input={{
									value: value.bgVideoFallback,
									onChange: ( (val) => this.onChangeHandle( val,'bgVideoFallback' ))}}
							/>
						</div>
					}

				</div>

			</div>
		)
	}
}

export default Background;