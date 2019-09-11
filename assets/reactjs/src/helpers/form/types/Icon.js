import React, { Component } from 'react'
import IconList from './helpers/IconList'
import ToolTips from '../../ToolTips'

class Icon extends Component {

	constructor(props) {
		super(props);
		this.state = { listOpen: false, icon: '', filterText: '', filterIcon: 'all' };
	}

	componentDidMount() {
		this.setState({ icon: this.props.input.value })
	}

	onClickHandle(event) {
		event.preventDefault();
		const { listOpen } = this.state;
		this.setState({ listOpen: !listOpen })
	}

	setIcon(icon) {
		const { input: { onChange } } = this.props
		const { listOpen } = this.state;
		onChange(icon);
		this.setState({ icon: icon, listOpen: !listOpen })
	}

	componentWillReceiveProps(nextProps) {
		this.setState({ icon: nextProps.input.value })
	}

	handleIconFilter(e) {
		this.setState({ filterText: e.target.value })
	}

	render() {
		const { params } = this.props
		let listClassName = 'wppb-builder-fontawesome-icon-chooser';
		if (this.state.listOpen) {
			listClassName = listClassName + ' open';
		}
		if (this.state.icon) {
			listClassName = listClassName + ' wppb-has-fa-icon';
		}

		return (
			<div className="wppb-builder-form-group wppb-builder-form-group-wrap">
				<span className="wppb-builder-form-group-title">
					{params.title &&
						<label>{params.title}</label>
					}
					{params.desc &&
						<ToolTips desc={params.desc} />
					}
				</span>	
				<div className={listClassName}>

					<div className="wppb-builder-fontawesome-icon-input" onClick={this.onClickHandle.bind(this)}>
						<span>
							<i className={this.state.icon} />
							{this.state.icon ?
								' ' + this.state.icon
								:
								'Select Icon..'
							}
						</span>
						<span className="wppb-builder-remove-fa-icon" onClick={(e) => { this.setIcon(''); }} > <i className="wppb-font-close" /></span>
						<i className="fas fa-angle-up" />
						<i className="fas fa-angle-down" />
					</div>

					<div className="clearfix wppb-builder-fontawesome-dropdown">
						<div className="wppb-builder-fontawesome-dropdown-in">
							<span><i className="wppb-font-magnifying-glass" /></span><input type="text" placeholder="Search" onChange={this.handleIconFilter.bind(this)} autoComplete="off" />
						</div>

						<div className="wppb-builder-font-list">
							<span className={this.state.filterIcon == 'all' ? 'active' : ''} onClick={(e) => this.setState({ filterIcon: 'all' })}>{page_data.i18n.all}</span>
							<span className={this.state.filterIcon == 'icofont' ? 'active' : ''} onClick={(e) => this.setState({ filterIcon: 'icofont' })}>{page_data.i18n.wppb_icon}</span>
							<span className={this.state.filterIcon == 'fontawesome' ? 'active' : ''} onClick={(e) => this.setState({ filterIcon: 'fontawesome' })}>{page_data.i18n.fontawesome}</span>
						</div>

						<ul className="wppb-builder-fontawesome-icons">
							{this.state.listOpen &&
								IconList.map((name, index) => {
									if (this.state.filterText != '') {
										if (name.toLowerCase().indexOf(this.state.filterText.toLowerCase()) === -1) {
											return;
										}
									}
									if (this.state.filterIcon == 'fontawesome') {
										if (name.indexOf('fa-') == -1) { return; }
									} else if (this.state.filterIcon == 'icofont') {
										if (name.indexOf('wppb-') == -1) { return; }
									}
									return (
										<li key={index} onClick={(e) => {
											if (name.indexOf('fa-') !== -1) {
												this.setIcon(name);
											} else {
												this.setIcon(name);
											}
										}} className="wppb-builder-fa-list-icon">
											<div><div><div>
												{(name.indexOf('fa-') !== -1) ?
													<i className={name} />
													:
													<i className={name} />
												}
											</div></div></div>
										</li>
									)
								})
							}
						</ul>
					</div>
				</div>
			</div>
		)
	}
}

export default Icon;
