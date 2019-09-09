import React,{ Component } from 'react';
import ReactDOM from 'react-dom';

// so that our CSS is statically analyzable
const CLASS_NAMES = {
    overlay: {
        base: 'wppb-builder-modal-overlay',
        afterOpen: 'wppb-builder-modal-overlay-after-open',
        beforeClose: 'wppb-builder-modal-overlay-before-close'
    },
    content: {
        base: 'wppb-builder-modal-content',
        afterOpen: 'wppb-builder-modal-content-after-open',
        beforeClose: 'wppb-builder-modal-content-before-close'
    }
};


const defaultStyles = {
    overlay: {
        position        : 'fixed',
        top             : 0,
        left            : 0,
        right           : 0,
        bottom          : 0,
        backgroundColor : 'rgba(255, 255, 255, 0.75)'
    },
    content: {
        position                : 'fixed',
        top                     : '0',
        left                    : '0',
        right                   : '0',
        bottom                  : '0',
        overflow                : 'auto'
    }
};

var onClose;

class Modal extends Component{
    constructor(props){
        super(props);

        this.state = {
            afterOpen : false,
            beforeClose : false,
        }
    }
    close() {
        if(!this.props.onRequestClose || this.props.onRequestClose()){
            Manager.close();
        }
    }
    handleKeyDown(event){
        if (event.keyCode == 27 /*esc*/) this.close();
    }
    componentDidMount(){
        const {openTimeoutMS,closeTimeoutMS} = this.props;
        setTimeout(() => this.setState({afterOpen : true}),openTimeoutMS ? openTimeoutMS : 150);
        onClose = (callback) => {
            this.setState({beforeClose: true}, () => {
                this.closeTimer = setTimeout(callback, closeTimeoutMS ? closeTimeoutMS : 150);
        });
        };
    }
    componentWillUnmount(){
        onClose = null;
        clearTimeout(this.closeTimer);
    }

    buildClassName(which, additional) {
        var className = CLASS_NAMES[which].base;
        if (this.state.afterOpen)
            className += ' '+CLASS_NAMES[which].afterOpen;
        if (this.state.beforeClose)
            className += ' '+CLASS_NAMES[which].beforeClose;
        return additional ? className + ' ' + additional : className;
    }

    render(){
        const {style} = this.props;

        return (
            <div ref="overlay" className={this.buildClassName('overlay',this.props.overlayClassName)} style={Object.assign({},defaultStyles.overlay,style ? (style.overlay ? style.overlay : {}) : {})}>
                <div ref="content" className={this.buildClassName('content',this.props.className)} style={Object.assign({},defaultStyles.content,style ? (style.content ? style.content : {}) : {})}>
                    <div className={this.props.customClass?this.props.customClass:''} onClick={e => e.stopPropagation()} onKeyDown={this.handleKeyDown.bind(this)}>
                        { this.props.title != 'undefined'
                            ? <h2 className="wppb-builder-modal-title">{this.props.title}</h2>
                            : ''
                        }
                        { this.props.children }
                    </div>
                </div>
            </div>
        );
    }
}

var node;
const Manager = {
    open(component){
        if(onClose){
            throw "There is already one modal.It must be closed before one new modal will be opened";
        }
        if(!node){
            node = document.createElement('div');
            node.className = "wppb-builder-modal";
            document.body.appendChild(node);
        }
        ReactDOM.render(component,node);
        document.body.classList.add('wppb-builder-modal-open')
    },
    close(){
        onClose && onClose(() => {
            ReactDOM.unmountComponentAtNode(node);
        document.body.classList.remove('wppb-builder-modal-open')
    });
    },
}

module.exports = {
    Modal : Modal,
    ModalManager : Manager,
};
