import React, { Component } from 'react'
import { setRepeatFields } from './actions/index'
import RepeatItem from './RepeatItem'
import { connect } from 'react-redux'

class RepeatField extends Component {

	constructor(props) {
		super(props);
		this.state = { openRow: 'none' }
	}

	handleClickSwap( indexA, indexB ){
		const { fields } = this.props;
		fields.swap( indexA, indexB )
	}

	handleRowClick( value ){
		this.setState({ openRow: value })
	}

	addItemRow(e){
		const { fields, parentKey, state, flOptions } = this.props
		let nextRowIndex = fields.length;
		this.setState({ openRow: nextRowIndex });
		if ( state.wppbForm.form == 'mainForm' ) {
			this.props.setRepeatFields( parentKey, nextRowIndex )
		}
		fields.push( __.mapValues( flOptions.attr, ( val,key ) => { return val.std }) )
	}

	removeItemRowClick(itemIndex){
		const { fields } = this.props
		fields.remove(itemIndex)
	}

	render(){
		const { fields, flOptions } = this.props

		let thisFormName = this.props.meta.form

		return(
			<div className="wppb-builder-grouped-wrap wppb-builder-form-group-wrap wppb-clearfix">
				<span className="wppb-builder-form-group-title">
					<label>{flOptions.title}</label>
				</span>
				{ fields.map( (element,index) => {
					return(
						<RepeatItem
							key       = { index }
							flOptions = { flOptions }
							fields    = { fields }
							element   = { element }
							parentKey = { this.props.parentKey }
							index     = { index }
							openRow   = { this.state.openRow }
							thisFormName  = { thisFormName }
							onHandleRowClick            = { this.handleRowClick.bind(this) }
							onHandleRemoveItemRowClick  = { this.removeItemRowClick.bind(this) } />
					)
				})}
				<div className="repeatable-add-btn-wrap">
					<button className="repeatable-add-item" type="button" onClick={ this.addItemRow.bind(this) }><i className="wppb-font-add-alt"/> {page_data.i18n.add_item}</button>
				</div>
			</div>
		)
	}
}

const mapStateToProps = (state) => {
	return {
		state
	};
}

const mapDispatchToProps = ( dispatch ) => {
  return {
    setRepeatFields: ( fieldName, rfieldIndex ) => {
      	dispatch( setRepeatFields( fieldName, rfieldIndex ) )
    }
  }
}

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(RepeatField);
