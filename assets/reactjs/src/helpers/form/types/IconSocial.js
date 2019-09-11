import React, {Component} from 'react'
import IconSocialList from './helpers/IconSocialList'
import Select from 'react-select'
import ToolTips from '../../ToolTips'

export class socialOption extends Component{
    constructor(props){
        super(props);
    }
    handleMouseDown (event) {
		this.props.onSelect(this.props.option, event);
	}
	handleMouseEnter (event) {
		this.props.onFocus(this.props.option, event);
	}
	handleMouseMove (event) {
		if (this.props.isFocused) return;
		this.props.onFocus(this.props.option, event);
	}
	render() {
		return ( <div className={this.props.className}
            onMouseDown={ () => this.handleMouseDown() }
            onMouseEnter={ () => this.handleMouseEnter() }
            onMouseMove={ () => this.handleMouseMove() }
            title={this.props.option.title}><i className={ 'fab fa-'+this.props.children }/> {this.props.children}</div> );
	}
}

export class socialValue extends Component{
    constructor(props){
        super(props);
    }
	render () {
		return (
            <div className="wppb-social-value"><i className={ 'fab fa-'+this.props.children }/> {this.props.children}</div>
		);
	}
}

class IconSocial extends Component {
    onChangeSelect( event ){
        const { input: { onChange,name } } = this.props
        if( event ){
            onChange( event.value );
        }else{
            onChange( '' );
        }
    }

    render(){
        const { params } = this.props
        let iconsList = __.map( IconSocialList, val => { return { value:'fab fa-' + val , label: val } } );
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
                <div className="wppb-element-form-group clearfix">
                    <Select
                        name = { name }
                        value = { this.props.input.value }
                        options = { iconsList }
                        optionComponent={socialOption}
                        onChange = { this.onChangeSelect.bind( this ) }
                        valueComponent = { socialValue }/>
                </div>
            </div>
        )
    }
}

export default IconSocial;