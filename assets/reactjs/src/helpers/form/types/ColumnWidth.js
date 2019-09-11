import React, {Component} from 'react'
import ResponsiveManager from '../../../helpers/ResponsiveManager';
import EditPanelManager from '../../../helpers/EditPanelManager';

class ColumnWidth extends Component {

    constructor(props) {
        super(props)
        
        this.state = this.getCurrentValue(props, 'init')
    }

    componentWillReceiveProps(nextprops) {
        if(this.state.receive || nextprops.mediaDevice != this.props.mediaDevice) {
            let data = this.getCurrentValue(nextprops,'receive')
            this.setState({
                value: data.value,
                max: data.max,
                currentColumn: data.currentColumn,
                nearColumn: data.nearColumn
            })
        }
    }

    getCurrentValue(props,action) {
        let data = {
            min: 10,
            max: 100,
            value: 0,
            currentColumn : EditPanelManager.colIndex,
            nearColumn: 'none',
        };

        if( EditPanelManager.type == 'inner_column' ){
            data.currentColumn = EditPanelManager.innerColIndex
        }

        let columnLayout = EditPanelManager.rowSettings.layout;

        if(typeof columnLayout == 'undefined'){
            return data;
        }

        let columnIndex  = data.currentColumn,
            layoutArray  = columnLayout.toString().split(','),
            layout       = layoutArray[columnIndex];

        if(action == 'receive'){
            data.receive = true;
        } else {
            data.receive = false;
        }

        if(props.mediaDevice == 'xs') {
            data.value = props.input.value.xs
        } else if(props.mediaDevice == 'sm') {
            data.value = props.input.value.sm
        } else {
            if(layoutArray[columnIndex+1]) {
                data.nearColumn = columnIndex + 1;
                data.max = Number(layoutArray[columnIndex]) + Number(layoutArray[columnIndex + 1]) - 10;
            } else if (layoutArray[columnIndex - 1]) {
                data.nearColumn = columnIndex - 1;
                data.max = Number(layoutArray[columnIndex]) + Number(layoutArray[columnIndex - 1]) - 10;
            }

            if(action == 'receive'){
                data.value = props.input.value.md
            }else{
                data.value = layoutArray[columnIndex]
            }
        }

        return data
    }

    onChangeValue(event) {
 
        const { input: { onChange,value }, params, mediaDevice } = this.props
        const { currentColumn, nearColumn } = this.state

        let dirObject = {}

        if( mediaDevice == 'md' ) {
            dirObject[mediaDevice] = event.target.value

            let columnLayout = EditPanelManager.rowSettings.layout,
                layoutArray  = columnLayout.toString().split(',');

            layoutArray[currentColumn]  = event.target.value
            layoutArray[nearColumn]     = Number(this.state.max) - Number(event.target.value) + 10;

            let layoutString = layoutArray.join(',');
            dirObject['layout'] = layoutString
        }
        dirObject[mediaDevice] = event.target.value

        this.setState({
            value: event.target.value,
            receive: true
        });

        let finalWidth = Object.assign( {}, value , dirObject );

        onChange(finalWidth)
    }
    
    render() {
        const { input, params, mediaDevice } = this.props

        let active = 'md'
        if( params.responsive )
        {
            if(mediaDevice == 'xs') {
                active = 'xs'
            } else if(mediaDevice == 'sm') {
                active = 'sm'
            } else {
                active = 'md'
            }
        }
        

        return(
            <div className="wppb-builder-form-group">
                { params.title &&
                    <label>{ params.title }</label>
                }
                <label className="wppb-builder-device-wrap">
                    { params.responsive &&
                        <ul className={ 'wppb-builder-device wppb-builder-device-' + active }>
                            <li><i className="fas fa-laptop md" onClick = { e => { ResponsiveManager.setDevice('md'); }}/></li>
                            <li><i className="fas fa-tablet-alt sm" onClick = { e => { ResponsiveManager.setDevice('sm'); }}/></li>
                            <li><i className="fas fa-mobile-alt xs" onClick = { e => { ResponsiveManager.setDevice('xs'); }}/></li>
                        </ul>
                    }
                </label>
                <div className='wppb-element-form-group wppb-builder-form-device'>
                    <div className="wppb-builder-range">
                        <input value = { this.state.value } max={ this.state.max } min={ this.state.min } step="1" type="range" onChange={ this.onChangeValue.bind(this) } />
                        <input value = { this.state.value } max={ this.state.max } min={ this.state.min } type="number" autoComplete="off" onChange={ this.onChangeValue.bind(this) } />
                    </div>
                </div>
            </div>
        )
    }

}

export default ColumnWidth;