import React, {Component} from 'react'
const _month = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec']
const _days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']

class DateTime extends Component {

    constructor(props) {
        super(props)
        this.state = { type: 'date', isOpen:false }
    }

	_daysInMonth( year, month ){
		return new Date( year, month , 0 ).getDate()
	}

	_daysName( dateString ){
		return new Date( dateString ).getDay() - 1 
	}

	_clickPevious(month,year){
        if( this.state.type != 'month' ){
            if( this.state.type == 'date' ){
                if( month == 1 ){
                    if( year != 1970 ){
                        this._changeDate( 'ymo', [year-1,12] )
                    }
                }else{
                    this._changeDate( 'mo', month-1 )
                }
            }
            if( this.state.type == 'year' ){
                year = year - 42;
                this._changeDate( 'y', (year<=1970?1970:year) )
            }
        }
	}

	_clickNext(month,year){
        if( this.state.type != 'month' ){
            if( this.state.type == 'date' ){
                if( month == 12 ){
                    this._changeDate( 'ymo', [year+1,1] )
                }else{
                    this._changeDate( 'mo', month+1 )
                }
            }
            if( this.state.type == 'year' ){
                this._changeDate( 'y', year+42 )
            }
        }
    }

	_getYearView( year ){
		let data = []
		for( var i = 0; i <= 41; i++ ){
			data.push( year +i )
	   	}
	   return data
	}

	_getDaysView( timestamp ){
        let month = timestamp.getMonth() + 1,
            year = timestamp.getFullYear(),
            days = this._daysInMonth( year, month ),
			start = this._daysName( year+'-'+month+'-1' ) + 1,
			toLoop = days + start,
			data = [],
			inc = 1
		for( let i = 0; i <= 41 ; i++ ){
			if( i >= start && i < toLoop ){
                if( timestamp.getDate() == inc && year == inc ){
                    data.push( <span className="active">{inc}</span> )
                }else{
                    data.push( <span>{inc}</span> )
                }
				inc++
			}else{
				data.push( <span></span> )
			}
		}
		return data
    }


    _changeDate( type, setValue ){
        if( typeof setValue != 'undefined' && setValue ){
            let timestamp = new Date( this.props.input.value || Date.now() )
            let y = timestamp.getFullYear(),
                mo = timestamp.getMonth()+1,
                d = timestamp.getDate(),
                h = timestamp.getHours(),
                m = timestamp.getMinutes(),
                s = timestamp.getSeconds();
            switch(type){
                case 'y':
                    y = setValue
                break;    
                case 'mo':
                    mo = setValue
                break;
                case 'd':
                    d = setValue
                break
                case 'h':
                    h = setValue
                break;
                case 'm':
                    m = setValue
                break;    
                case 's':
                    s = setValue
                break;
                case 'ymo':
                    y = setValue[0]
                    mo = setValue[1]
                break;
            }
            let dateTimestramp = new Date( y+'-'+mo+'-'+d+' '+h+':'+m+':'+s ).getTime()
            this.props.input.onChange( dateTimestramp )
        }
    }

    render(){
        const { params } = this.props,
            timestamp = new Date( this.props.input.value || Date.now() ),
            month = timestamp.getMonth(),
            year = timestamp.getFullYear()
		return (
			<div className="wppb-builder-form-group wppb-builder-form-group-wrap wppb-builder-form-datetime">
                <span className="wppb-builder-form-group-title">
                    { params.title &&
                        <label>{ params.title }</label>
                    }
                    { params.desc &&
                        <ToolTips desc={params.desc}/>
                    }
                </span>

                <div className="wppb-element-form-calendar">
                    <input readOnly value={ year+'-'+(month+1)+'-'+timestamp.getDate()+' '+timestamp.getHours()+':'+timestamp.getMinutes()+':'+timestamp.getSeconds() } />
                    <span onClick={ ()=> this.setState({isOpen:!this.state.isOpen}) }><i className="wppb-font-calender-alt"/></span>

                    { this.state.isOpen &&
                        <div className="wppb-element-popup-calendar">
                            <div className="wppb-calender-title">
                                <span className={ this.state.type == 'month' ? 'disable' : '' } onClick={ ()=> this._clickPevious( month+1, year ) }><i className={ this.state.type != 'month' ? "disable wppb-font-angle-left" : "wppb-font-angle-left" }/></span>
                                <span onClick={ ()=> this.setState({type:'year'}) }>{year}</span>
                                <span onClick={ ()=> this.setState({type:'month'}) }>{_month[month]}</span>
                                <span className={ this.state.type == 'month' ? 'disable' : '' }  onClick={ ()=> this._clickNext( month+1, year ) }><i className="wppb-font-angle-right"/></span>
                            </div>
                            <div>
                                { this.state.type == 'year' &&
                                    <div className="wppb-calendar-year">
                                        { this._getYearView(year).map((y,i) => {
                                            return <span onClick={ () => { this._changeDate( 'y', y ); this.setState({ type:'date' }); } } key={i}>{y}</span>
                                        })}
                                    </div>
                                }
                                { this.state.type == 'month' &&
                                    <div className="wppb-calendar-month">
                                        { _month.map((m,i) => {
                                            return <span onClick={ ()=> { this._changeDate( 'mo', i+1 ); this.setState({ type:'date' }); } } key={i}>{m}</span>
                                        })}
                                    </div>
                                }
                                { this.state.type == 'date' &&
                                    <div>
                                        <div className="wppb-days-name">
                                            { _days.map((day,i) => {
                                                    return <span key={i}>{day}</span>
                                            })}
                                        </div>
                                        <div className="wppb-days-date">
                                            { this._getDaysView(timestamp).map((d, i) =>{
                                                return <span key={i} onClick={ ()=> { this._changeDate('d', d.props.children) } }>{d}</span>
                                            })}
                                        </div>
                                    </div>
                                }
                                <div className="wppb-calendar-hour">
                                    <input type="number" onChange={(e)=> this._changeDate( 'h', e.target.value )} min="0" max="23" value={timestamp.getHours()}></input>
                                </div>
                                <div className="wppb-calendar-minute">
                                    <input type="number" onChange={(e)=> this._changeDate( 'm', e.target.value )} min="0" max="59" value={timestamp.getMinutes()}></input>
                                </div>
                                <div className="wppb-calendar-second">
                                    <input type="number" onChange={(e)=> this._changeDate( 's', e.target.value )} min="0" max="59" value={timestamp.getSeconds()}></input>
                                </div>
                            </div>
                        </div>
                    }
                </div>

			</div>
		);
    }
  }
  
  export default DateTime;