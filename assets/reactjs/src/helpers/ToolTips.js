import React, {Component} from 'react'
class ToolTips extends Component {
    constructor(props){
        super(props);
        this.state = { open: false };
    }
    openAction(){
        this.setState({ open: !this.state.open })
    }
    render(){
        return(
            <span className="wppb-tool-tips">
                <i onClick={ () => this.openAction() } className="fas fa-question-circle"></i>
                { ( this.state.open && this.props.desc ) &&
                    <span dangerouslySetInnerHTML={{ __html: this.props.desc }} ></span>
                }
            </span>
        )
    }
}
export default ToolTips;