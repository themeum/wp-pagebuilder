import React, {Component} from 'react'
import ReactSelect from 'react-select'
import ToolTips from '../../ToolTips'

class Media extends Component {

    handleUploadClick(){
        const { input: { onChange }, params } = this.props
        if (this.upload_modal){
            this.upload_modal.open();
            return;
        }
        this.upload_modal = wp.media({
            title: 'Select Image',
            button: { text: 'Insert' },
            multiple: true
        });
        this.upload_modal.on('select', () => {
            let imageData = [];
            let attachment = this.upload_modal.state().get('selection').toJSON();
            if( params.multiple ){
                imageData = [];
                if( __.isObject(attachment) ){
                    __.forEach( attachment, e => { imageData.push( { id: e.id, url: e.url } ) })
                }
                onChange( __.concat( ( this.props.input.value ? this.props.input.value : [] ) , imageData ) );
            }else{
                __.forEach( attachment, e => { imageData = { id: e.id, url: e.url } } )
                if( ['jpeg','jpg','png'].indexOf( imageData.url.split('.').pop().toLowerCase() ) >= 0 ){
                    imageData.size = 'full'
                }
                onChange( imageData );
            }
        });
        this.upload_modal.open();
    }

    deleteMedia( key ){
        const { input: { onChange, value },params } = this.props
        if( params.multiple ){
            onChange( [ ...value.slice( 0,key ), ...value.slice( key + 1) ] );
        } else {
            onChange('')
        }
    }

    getAllImageSize(){
        let allSize = [ { value:'full', label:'Full' } ]
        if( page_data.wppbimagesize ){
            __.map( page_data.wppbimagesize, (size,key) => {
                allSize.push( { value:key, label:size } )
            })
        }
		return allSize;
    }

    onChangeHandle( val ){
        const { input: { onChange, value } } = this.props
        jQuery.ajax({
            type: 'POST',
            url: page_data.ajaxurl,
            dataType: 'json',
            data: { action: 'wppb_image_size_url', security: page_data.ajax_nonce, id: value.id, size: val },
            cache: false,
            async: false,
            success: function(response) {
                if ( response.success && response.data ){
                    onChange( Object.assign( {}, value, { size: val, url: response.data } ) )
                }
            }.bind(this)
        });
    }

    render(){
        const { input: { value, name }, params } = this.props;
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
                <div className='wppb-element-form-group wppb-element-form-media'>
                    { params.multiple ?
                        value &&
                        __.map( value, ( val , key ) => {
                            return (
                                <div className="wppb-form-media-remove wppb-form-multi-remove" style={{backgroundImage: 'url(' + val.url + ')'}} key={key}>
                                    <div className={'wppb-media-delete'} onClick={ e => { this.deleteMedia(key) } }><i className="fas fa-trash-alt"/> <span>{page_data.i18n.delete}</span></div>
                                </div>
                            )
                        })
                        :
                        ( value && value.url ) &&
                        <div className="wppb-form-media-remove" style={{backgroundImage: 'url(' + value.url + ')'}}>
                            <div className={'wppb-media-delete'} onClick={ e => { this.deleteMedia('single') } }><i className="fas fa-trash-alt"/> <span>{page_data.i18n.delete}</span></div>
                        </div>
                    }
                    { ( value && value.size ) &&
                        <ReactSelect
                            name={ name }
                            value={ ( value && value.size ? value.size : 'full' ) }
                            options={ this.getAllImageSize() }
                            clearable={ false }
                            onChange={ (val) => this.onChangeHandle(val.value) }/>
                    }
                    { params.multiple ?
                        <div className="wppb-media-add wppb-form-multi-add" onClick={ ()=>{ this.handleUploadClick();}}><div><span>{ params.btnName ? params.btnName : 'Add' }</span><i className="wppb-font-image-upload"/><span>{ params.btnName ? params.btnName : 'Items' }</span></div></div>
                        :
                        ( value && value.url ) ?
                            null
                            :
                            <div className="wppb-media-add" onClick={ ()=>{ this.handleUploadClick();}}><div><span>{ params.btnName ? params.btnName : 'Add' }</span><i className="wppb-font-image-upload"/><span>{ params.btnName ? params.btnName : 'Item' }</span></div></div>
                    }
                </div>
            </div>
        )
    }
}

export default Media;
