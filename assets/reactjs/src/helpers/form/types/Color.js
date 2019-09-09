import React, {Component} from 'react'
import ChromePicker from 'react-color'
import ToolTips from '../../ToolTips'

class Color extends Component {
    constructor(props) {
        super(props);
        this.state = { displayColorPicker: false };
    }

    handleChange(color){
        const { input: { onChange } } = this.props;
        let mainColor = `rgba(${ color.rgb.r }, ${ color.rgb.g }, ${ color.rgb.b }, ${ color.rgb.a })`;
        if(color.rgb.a == 1){
            mainColor = color.hex;
        }
        onChange(mainColor);
    }

    handleChangeInput(e){
        const { input: { onChange } } = this.props;
        onChange(e.target.value);
    }

    componentWillReceiveProps(nextProps){
		const { input: { value, onChange } } = nextProps

		if(!__.isEqual(value, this.props.input.value)){
			onChange(value)
		}
	}

    render() {
        const { input: { value }, params } = this.props;
        return (
            <div className="wppb-builder-form-group wppb-builder-form-group-wrap">
                <span className="wppb-builder-form-group-title">
                    { params.title &&
                        <label>{ params.title }</label>
                    }
                    { params.desc &&
                        <ToolTips desc={params.desc}/>
                    }
                </span>
                <div className='wppb-builder-form-color'>
                    { this.state.displayColorPicker &&
                        <div className="wppb-builder-color-fixed" onClick={ () => { this.setState({ displayColorPicker: false }) } }/>
                    }    
                    <div className="wppb-builder-color-design" onClick={ () => { this.setState({ displayColorPicker: !this.state.displayColorPicker }) } } >
                        <div className="color-picker-show-box" style={{ position: 'relative', display: 'inline-block', cursor: 'pointer', width:'30px', height:'30px', backgroundColor:value }}
                        ></div>
                        <input type="text" placeholder={( params.placeholder ? params.placeholder :'#000000' )} value={( value ? value : '' )} onChange={ this.handleChangeInput.bind(this) } />
                    </div>
                    { this.state.displayColorPicker &&
                        <ChromePicker color={ value } onChange={ this.handleChange.bind(this) } />
                    }
                </div>
                
            </div>
        )
    }
}

export default Color;
