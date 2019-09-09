import React, { Component } from 'react'
import { saveSetting } from '../actions/index';
import { connect } from 'react-redux'
import deepCopy from 'deepcopy'
import ResponsiveManager, { isMobileUserAgent } from '../helpers/ResponsiveManager';

class PaddingController extends Component {
    constructor(props) {
        super(props)
        this.state = {
            timer:null,
            isTouch: isMobileUserAgent(),
            unit:'px',
            initialPadding: {
                md: {top: '', right: '', bottom: '', left:''}, 
                sm: {top: '', right: '', bottom: '', left:''},
                xs: {top: '', right: '', bottom: '', left:''},
            },
            x: 0,
            y: 0,
            hover: false,
            active: false,
            position: null,
            verticalLock: false,
            horizontalLock: false
        }
        this.onDragOverAction = this.onDragOverAction.bind(this)
        this.onDragStopAction = this.onDragStopAction.bind(this)
    }

    componentDidMount() {

        if(typeof this.props.paddingObj !== 'undefined'){
            this._updateRowPadding(this.props.paddingObj)
        }

        const { isTouch, hover } = this.state
        if( isTouch ){
            this.setState({ hover :true})
        }
        
        window.frames['wppb-builder-view'].window.addEventListener('touchmove', this.onDragOverAction, false);
        window.frames['wppb-builder-view'].window.addEventListener('touchcancel', this.onDragStopAction, false);
        window.frames['wppb-builder-view'].window.addEventListener('mousemove', this.onDragOverAction);
        window.frames['wppb-builder-view'].window.addEventListener('mouseup', this.onDragStopAction);
    }
    
    componentWillReceiveProps(nextProps){
        if( !_.isEqual(this.props.paddingObj, nextProps.paddingObj)){
            this._updateRowPadding(nextProps.paddingObj)
        }
    }
    
    _updateRowPadding(padding) {
        if (typeof padding !== null && _.isObject(padding))
        {
            let newPadding = deepCopy(padding)

            if(typeof newPadding.md === 'undefined'){
                Object.assign( newPadding, { md:{ top: '', right: '', bottom: '', left:'' }})
            }

            if(typeof newPadding.sm === 'undefined'){
                Object.assign( newPadding, { sm:{ top: '', right: '', bottom: '', left:'' }})
            }

            if(typeof newPadding.xs === 'undefined'){
                Object.assign( newPadding, { xs:{ top: '', right: '', bottom: '', left:'' }})
            }
            
            this.setState({
                initialPadding: newPadding,
            })
        }
    }

    onContextMenuAction(event){
        event.preventDefault();
    }
    /*
    * On touch start wait .005s and fire action
    * Update X and Y value
    * @active = true 
    * @hover = true
    * Save setTimeout timer 
    */ 
    onTouchStartAction(position, event){
        event.persist()
        
        let timer = setTimeout( ()=> {
            this.setState({ 
                x : event.changedTouches[0].pageX,
                y : event.changedTouches[0].pageY,
                position : position,
                active : true,
                hover : true
            })
        }, 200 )
        this.setState({ timer: timer })
    }
    /*
    * On Touch stop action 
    * @ative = false, 
    * @hover = false
    * @updatePadding main row padding settings
    * Reset setTimeout timer
    */ 
    onTouchStopAction(event){
        event.persist()

        this.setState({
            active: false,
            hover: false
        });

        if(this.state.timer !== null ){
            clearTimeout(this.state.timer)
        }
    }

    /*
    * onMouseMove action fire on window.eventlistner  
    * It will only execute when @active enabled 
    * Update local state with padding and co-ordinate
    * 
    * Check the action position (top, left, right, bottom)
    * @AxisCalculation
    * top - (mY-cY), bottom - (cY-mY), right - (cX-mY), left - (mX-cX),
    * 
    * If enable lock (vertical or horizontal)
    * vertical (left, right)
    * horizontal (top, bottom)   
    */
    onDragOverAction(event) {
        const { initialPadding, isTouch, active, position, x, y, unit, horizontalLock, verticalLock } = this.state
        const { row, rowIndex, colIndex, addonIndex } = this.props
        if (active === true) {
            let newRow = deepCopy(row);
            let newInitPadding = deepCopy(initialPadding)
            let mdPaddings = newInitPadding[ResponsiveManager.device]
            let deviceEvent = isTouch ? event.changedTouches[0] : event

            // let deviceEvent = event
            if (position === 'top') {
                let topPadding = mdPaddings.top.replace(/[a-zA-Z]+/, '');
                if(topPadding === '') topPadding = 0;
                
                let newPadding = Math.abs( parseInt(topPadding) + (deviceEvent.pageY - y))+ unit
                mdPaddings.top = newPadding
                if (horizontalLock)
                    mdPaddings.bottom = newPadding
            }
            if (position === 'bottom') {
                let bottomPadding = mdPaddings.bottom.replace(/[a-zA-Z]+/, '');
                if(bottomPadding === '') bottomPadding = 0;

                let newPadding = Math.abs( parseInt(bottomPadding) + (deviceEvent.pageY - y ))+ unit
                mdPaddings.bottom = newPadding
                if (horizontalLock)
                    mdPaddings.top = newPadding
            }

            if (position === 'left') {
                let leftPadding = mdPaddings.left.replace(/[a-zA-Z]+/, '');
                if(leftPadding === '') leftPadding = 0;

                let newPadding = Math.abs(parseInt(leftPadding) + (deviceEvent.pageX - x))+ unit
                mdPaddings.left = newPadding
                if (verticalLock)
                    mdPaddings.right = newPadding
            }

            if (position === 'right') {
                let rightPadding = mdPaddings.right.replace(/[a-zA-Z]+/, '');
                if(rightPadding === '') rightPadding = 0;

                let newPadding = Math.abs(parseInt(rightPadding) + ( x - deviceEvent.pageX))+ unit
                mdPaddings.right = newPadding
                if ( verticalLock)
                    mdPaddings.left = newPadding
            }
            
            newInitPadding[ResponsiveManager.device] = mdPaddings   
            newRow.settings.row_padding = newInitPadding
            
            let options ={
                type: 'row',
                index: rowIndex,
                settings: {
                    formData: newRow.settings,
                    colIndex: colIndex,
                    addonIndex: addonIndex
                }
            }

            if(typeof addonIndex == 'undefined'){
                this.props.updateRowPadding(options);
            } else {
                options.type = 'inner_row';
                this.props.updateRowPadding(options);
            }

            this.setState({ 
                initialPadding: newInitPadding,
                x: deviceEvent.pageX,
                y: deviceEvent.pageY
            });
        }

    }

    /*
    * When press mouse in drag area 
    * enable @active action to perform co-ordinate operation
    * Save exact mouse position (X, Y) for next operation
    */
    onMouseDownAction(event) {
        this.setState({
            active: true,
            x: event.pageX,
            y: event.pageY
        })
    }

    /*
     * On drag stop deactive action 
     * Update row-padding settings 
     */
    onDragStopAction(e) {
        e.preventDefault()
        const {active} = this.state;
        if(active){
            this.setState({
                active: false
            })
        }
    }
    /*
     * On mouse enter into the drag area 
     * enable hover action 
     */
    onMouseEnterAction(position, event) {
        const { active } = this.state;

        if (active !== true ) {
            this.setState({
                position: position,
                hover: true
            })
        }
    }
    /*
     * On leave action from drag area deactivate hover 
     * Hover will alive if mouse not release 
     */
    onMouseLeaveAction(event) {
        event.preventDefault()
        const { active } = this.state;
        if (!active) {
            this.setState({ hover: false })
        }
    }
    /*
    * Activate lock operation 
    * @horizontalLock (top, bottom)
    * @verticalLock (left, right)
    */
    onLockAction(axis, event) {
        event.preventDefault()
        const { horizontalLock, verticalLock } = this.state;
        if (axis === 'h'){
            this.setState({ horizontalLock: !horizontalLock })
        }
        
        if (axis === 'v'){
            this.setState({ verticalLock: !verticalLock })
        }
    }

    _getPadding(){
        let { initialPadding, unit } = this.state;
        const { row } = this.props;
        let T_height, B_height, L_width, R_width;

        let devicePadding = initialPadding[ResponsiveManager.device];

        T_height = devicePadding.top === '' ? 0 : parseInt(devicePadding.top.replace(/[a-zA-Z]+/, ''))
        B_height = devicePadding.bottom === '' ? 0 : parseInt(devicePadding.bottom.replace(/[a-zA-Z]+/, ''))
        L_width = devicePadding.left === '' ? 0 : parseInt(devicePadding.left.replace(/[a-zA-Z]+/, ''))
        R_width = devicePadding.right === '' ? 0 : parseInt(devicePadding.right.replace(/[a-zA-Z]+/, ''))

        return { 
            T_height:T_height, 
            B_height:B_height, 
            L_width:L_width, 
            R_width:R_width,
            unit: 'px'
        }
    }
    
    render() {
                
        let { position, active, verticalLock, horizontalLock } = this.state
        let { T_height, B_height, L_width, R_width, unit } = this._getPadding()

        let limit = (this.state.unit === '%' || this.state.unit === 'em') ? 6 : 40
        const dragStyleHorizontal = {
            width: '100%',
            opacity: this.state.hover && (position === 'top' || position === 'bottom') ? 1 : 0,            
        }
        const dragStyleVertical = {
            height: '100%',
            opacity: this.state.hover && (position === 'left' || position === 'right') ? 1 : 0,
        }
        return (
            <div className="wppb-padding-controller" ref="pdctrl">
                <div className="wppb-padding-controller-top wppb-padding-controller"
                        onTouchStart={this.onTouchStartAction.bind(this, 'top')}
                        onTouchEnd={this.onTouchStopAction.bind(this)}
                        onContextMenu={this.onContextMenuAction.bind(this)}
                        onMouseLeave={this.onMouseLeaveAction.bind(this)} 
                        onMouseEnter={this.onMouseEnterAction.bind(this, 'top')} 
                        onMouseDown={this.onMouseDownAction.bind(this)}>
                    <span className="wppb-padding-controller-initial-offset">&nbsp;</span>
                    <span className="wppb-padding-controller-offset" style={Object.assign({}, dragStyleHorizontal, { height: T_height+unit })}>
                        {T_height > limit ?
                            <span className="wppb-padding-controller-instant-offset-height">
                                <span>{T_height}{this.state.unit}</span>
                                <span className={horizontalLock ? "fa fa-lock" : "fa fa-unlock-alt"} onClick={this.onLockAction.bind(this, 'h')}></span>
                            </span>
                            : null}
                    </span>
                </div>
                <div className="wppb-padding-controller-right wppb-padding-controller" 
                        onTouchStart={this.onTouchStartAction.bind(this, 'right')}
                        onTouchEnd={this.onTouchStopAction.bind(this)}
                        onContextMenu={this.onContextMenuAction.bind(this)}
                        onMouseLeave={this.onMouseLeaveAction.bind(this)} 
                        onMouseEnter={this.onMouseEnterAction.bind(this, 'right')} 
                        onMouseDown={this.onMouseDownAction.bind(this)}>
                    <span className="wppb-padding-controller-initial-offset">&nbsp;</span>
                    <span className="wppb-padding-controller-offset" style={Object.assign({}, dragStyleVertical, { width: R_width+unit, right: 0 })}>
                        {R_width > limit ?
                            <span className="wppb-padding-controller-instant-offset-height">
                                <span>{R_width}{this.state.unit}</span>
                                <span className={ verticalLock ? "fa fa-lock" : "fa fa-unlock-alt"} onClick={this.onLockAction.bind(this, 'v')}></span>
                            </span>
                            : null}
                    </span>
                </div>
                <div className="wppb-padding-controller-bottom wppb-padding-controller"
                        onTouchStart={this.onTouchStartAction.bind(this, 'bottom')}
                        onTouchEnd={this.onTouchStopAction.bind(this)} 
                        onContextMenu={this.onContextMenuAction.bind(this)}
                        onMouseLeave={this.onMouseLeaveAction.bind(this)} 
                        onMouseEnter={this.onMouseEnterAction.bind(this, 'bottom')} 
                        onMouseDown={this.onMouseDownAction.bind(this)}>
                    <span className="wppb-padding-controller-initial-offset">&nbsp;</span>
                    <span className="wppb-padding-controller-offset" style={Object.assign({}, dragStyleHorizontal, { height: B_height+'px', bottom: 0 })}>
                        {B_height > limit ?
                            <span className="wppb-padding-controller-instant-offset-height">
                                <span>{B_height}{this.state.unit}</span>
                                <span className={horizontalLock ? "fa fa-lock" : "fa fa-unlock-alt"} onClick={this.onLockAction.bind(this, 'h')}></span>
                            </span>
                            : null}
                    </span>
                </div>
                <div className="wppb-padding-controller-left wppb-padding-controller" 
                        onTouchStart={this.onTouchStartAction.bind(this, 'left')}
                        onTouchEnd={this.onTouchStopAction.bind(this)}
                        onContextMenu={this.onContextMenuAction.bind(this)}
                        onMouseLeave={this.onMouseLeaveAction.bind(this)} 
                        onMouseEnter={this.onMouseEnterAction.bind(this, 'left')} 
                        onMouseDown={this.onMouseDownAction.bind(this)}>
                    <span className="wppb-padding-controller-initial-offset">&nbsp;</span>
                    <span className="wppb-padding-controller-offset" style={Object.assign({}, dragStyleVertical, { width: L_width+unit })}>
                        {L_width > limit ?
                            <span className="wppb-padding-controller-instant-offset-height">
                                <span>{L_width}{this.state.unit}</span>
                                <span className={verticalLock ? "fa fa-lock" : "fa fa-unlock-alt"} onClick={this.onLockAction.bind(this, 'v')}></span>
                            </span>
                            : null}
                    </span>
                </div>
            </div>
        )
    }
}



const mapStateToProps = (state) => {
    return { state };
}

const mapDispatchToProps = (dispatch) => {
    return {
        updateRowPadding: (options) => {
            dispatch(saveSetting(options))
        }
    }
}

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(PaddingController)