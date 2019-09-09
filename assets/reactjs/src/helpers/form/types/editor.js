import React, {Component} from 'react'
import ReactDOM from 'react-dom'
import ToolTips from '../../ToolTips'

class Editor extends Component {
    componentDidMount(){
        this.initializeEditor( this.props );
    }

    componentWillReceiveProps( nextProps ){
        let editor = tinymce.get( 'wppb_wp_editor');
        if( !__.isEqual(editor.getContent(), nextProps.input.value) ){
            editor.setContent(nextProps.input.value);
        }
    }

    initializeEditor(props){
        const { input: { value, onChange, name }, change } = props;
        let editor_id = 'wppb_wp_editor';
        let editorContent = page_data.wppb_wp_editor.replace( '{{WP_EDITOR_CONTENT}}', value);
        ReactDOM.findDOMNode(this.refs.editor).innerHTML = editorContent;
        quicktags( {
            buttons: 'strong,em,del,link,img,close',
            id: editor_id
        } );
        switchEditors.go( editor_id, 'tmce' );
        let editorConfig = {
            id: editor_id,
            selector: '#'+editor_id,
            setup: function( editor ) {
                editor.on( 'keyup change undo redo SetContent', function(e){
                    onChange(editor.getContent());
                } );
            }
        };
        tinymce.execCommand( 'mceRemoveEditor',true, editor_id );
        tinymce.init(__.extend(__.clone(tinyMCEPreInit.mceInit.wppb_wp_editor), editorConfig));
        tinyMCE.execCommand('mceAddEditor', false, editor_id);
        jQuery(document).on('keyup change paste', '#'+editor_id, function(){
            onChange(jQuery('#'+editor_id).val());
        });
    }

    render(){
        const { input, params } = this.props
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
                <div className="wppb-builder-editor" ref="editor">
                    <textarea {...input} ref="richEditor" className="mce_editable wf-editor" id={input.name}></textarea>
                </div>
            </div>
        );
    }
}

export default Editor;
