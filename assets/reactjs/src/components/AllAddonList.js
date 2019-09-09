import React, { Component } from 'react';
import AllAddonListItem from './AllAddonListItem'
import WidgetListItem from  './WidgetListItem';

class AllAddonList extends Component {
	constructor(props){
		super(props);
		this.state = {
			addons: [],
			addonsThirdparty: {},
			wp_widgets: page_data.widgetJSON
		};
	}

	componentDidMount(){
		let addonsList = [],
			addonsThirdparty = {};

        addonsThirdparty['Other_Addons'] = [];

		for( let key in page_data.addonsJSON ){
			if( page_data.addonsJSON[key].defaultAddon ){
				addonsList.push( page_data.addonsJSON[key] );
			}else{
                if( page_data.addonsJSON[key].category == '' ){
					addonsThirdparty['Other_Addons'].push(page_data.addonsJSON[key]);
                }else{
					if( !addonsThirdparty[page_data.addonsJSON[key].category] ) {
						addonsThirdparty[page_data.addonsJSON[key].category] = []
					}
					addonsThirdparty[page_data.addonsJSON[key].category].push( page_data.addonsJSON[key] )
				}
			}
		}
		if( this.refs.searchItem.value == '' ){
			this.setState({ addonsThirdparty, addons: addonsList.map( function(addon){ addon.visibility = true; return addon; }) });
		}else{
			this.setState({ addonsThirdparty, addons: addonsList  });
		}
	}

	searchChangeHandle() {
		const { addons } = this.state;
		let search = this.refs.searchItem.value;
		let resultAddons = addons.map( function(addon){
			if ( addon.title.toLowerCase().indexOf( search.toLowerCase()) !== -1) {
				addon.visibility = true;
			} else {
				addon.visibility = false;
			}
			return addon;
		});
		this.setState({ addons:resultAddons });
	}

	render(){
		const wp_widgets_data = this.state.wp_widgets;
		return(
			<div className="wppb-builder-addons-list-sidebar">
				<div className="wppb-builder-category">
					<div className="wppb-builder-addons-search">
						<input type="text" placeholder="Search" ref="searchItem" onChange={this.searchChangeHandle.bind(this)} />
						<i className="wppb-font-search"/>
					</div>
				</div>
				
				<h5><span>{page_data.i18n.default_addons}</span></h5>
				<ul className="clearfix"> 
					{ this.state.addons.map( ( addon,index )=>
						addon.visibility != false &&
							<li key={index}>
								<AllAddonListItem addon={addon} />
							</li>
					)}
				</ul>

				{ __.map( this.state.addonsThirdparty, ( adddonData,index )=>
					<span key={index}>
						{ adddonData.length > 0 &&
							<span>
								<h5><span>{index.replace('_', ' ')}</span></h5>
								<ul className="clearfix">
									{ __.map( adddonData, ( addon,index )=>
										addon.visibility != false &&
										<li key={index}>
											<AllAddonListItem addon={addon} />
										</li>
									)}
								</ul>
							</span>
						}
					</span>
				)}
				

				<h5><span>{page_data.i18n.wordpress_widgets}</span></h5>
				<ul className="clearfix">
					{ __.map(wp_widgets_data,  ( widget,index ) =>
						<li key={index}>
							<WidgetListItem widget={widget} />
						</li>
					)}
				</ul>
			</div>
		)
  	}
}



export default AllAddonList;