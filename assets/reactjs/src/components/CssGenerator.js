const replaceData = ( selector, key, value ) => {
    if( value.toString().trim() ){
        return selector.replace( new RegExp( key, "g" ) , value )
    }
}

const splitAdd = ( selector, key, value ) => {
    if( value.top || value.bottom || value.right || value.left ){
        let top = value.top === ''?'0px':value.top;
        let bottom = value.bottom === ''?'0px':value.bottom;
        let right = value.right === ''?'0px':value.right;
        let left = value.left === ''?'0px':value.left;

        return replaceData( selector, '{{data.'+key+'}}', top+ ' '+right+' '+bottom+' '+left+';' );
    } else {
        return replaceData( selector ,'{{data.'+key+'}}' , ( __.isObject( value ) ? __.join( __.values(value),' ') : value ) );
    }
}

const shapeCssGenerator = ( selector, key, value ) => {
    let md = [],
        sm = [],
        xs = [];
    let position = ( key == 'row_shape' ? '.wppb-top-shape' : '.wppb-bottom-shape' )
    let shapeCss =  '.wppb-shape-container{ overflow: hidden; position: absolute; left: 0; width: 100%; line-height: 0; }'+
                    '.wppb-shape-container > svg{ display: block; width: 100%; position: relative; left: 50%; -webkit-transform: translateX(-50%) scale(1.01); -ms-transform: translateX(-50%) scale(1.01); transform: translateX(-50%) scale(1.01); }'+
                    '.wppb-shape-container.wppb-bottom-shape{ bottom: -1px; }.wppb-shape-container.wppb-bottom-shape svg{ transform: rotateX(180deg) translateX(-50%); }.wppb-shape-container.wppb-top-shape{ top: -1px; }';
    
    if( value.shapeColor ){
        shapeCss += selector + ' .wppb-shape-container'+position+' svg path, '+selector+' .wppb-shape-container svg polygon{ fill: '+value.shapeColor+' }';
    }
    let shapeSelector = '.wppb-builder-container '+ selector + ' .wppb-shape-container'+position+' > svg';
    if( value.shapeWidth ){
        if( value.shapeWidth.md ){ md.push( shapeSelector+'{ width: '+value.shapeWidth.md+'%; max-width: '+value.shapeWidth.md+'%; }' )}
        if( value.shapeWidth.sm ){ sm.push( shapeSelector+'{ width: '+value.shapeWidth.sm+'%; max-width: '+value.shapeWidth.sm+'%; }' )}
        if( value.shapeWidth.xs ){ xs.push( shapeSelector+'{ width: '+value.shapeWidth.xs+'%; max-width: '+value.shapeWidth.xs+'%; }' )}
    }
    if( value.shapeHeight ){
        if( value.shapeHeight.md ){ md.push( shapeSelector+'{ height: '+value.shapeHeight.md+'px; }' ) }
        if( value.shapeHeight.sm ){ sm.push( shapeSelector+'{ height: '+value.shapeHeight.sm+'px; }' ) }
        if( value.shapeHeight.xs ){ xs.push( shapeSelector+'{ height: '+value.shapeHeight.xs+'px; }' ) }
    }
    if ( value.shapeFlip == 1 ){
        if( key == 'row_shape' ){
            shapeCss += selector + ' .wppb-shape-container'+position+' > svg{ transform: rotateY(180deg) translateX(50%); }';
        }else{
            shapeCss += selector + ' .wppb-shape-container'+position+' > svg{ transform: rotateX(180deg) rotateY(180deg) translateX(50%); }';
        }
    }
    if( value.shapeFront == 1 ){ shapeCss += selector + ' .wppb-shape-container { z-index: 99; }'; }
    
    return [ shapeCss, md, sm, xs ];
}

const cssOutput = ( value, key , selector ) => {
    let notResponsiveCss = [],
    md = [],
    sm = [],
    xs = [];

    if ( __.isObject(value) ){

        // For Device Check
        if( value.md ){ md.push( splitAdd( selector, key, value.md ) ); }
        if( value.sm ){ sm.push( splitAdd( selector, key, value.sm ) ); }
        if( value.xs ){ xs.push( splitAdd( selector, key, value.xs ) ); }

        
        if( value.itemOpenBorder ){
            // Border
            let margeProps = '';
            __.forEach( ['borderWidth','borderStyle','borderColor'], ( property ) => {
                if( value[property] ){ margeProps += __.kebabCase(property)+':' + ( property == 'borderWidth' ? __.join( __.values(value[property]),' ') : value[property] ) + ';' }
            });
            if( margeProps ){ notResponsiveCss.push( replaceData( selector, '{{data.'+key+'}}', '{' + margeProps + '}' ) ); }
        } else if ( value.itemOpenShadow ){ 
            // Shadow
            if( value.shadowValue && value.shadowColor ){
                notResponsiveCss.push( replaceData( selector, '{{data.'+key+'}}', '{ box-shadow:' + __.join( __.values(value.shadowValue),' ') +' '+ value.shadowColor + '}' ))
            }
        }else if( value.itemOpenFontStyle ){
            // Typography2
            let margeProps = '';
            __.forEach( ['fontStyle','fontWeight','textTransform','textDecoration'], ( property ) => {
                if( value[property] ){ margeProps += __.kebabCase(property)+':' + value[property] + ';' }
            });
            if( margeProps ){ notResponsiveCss.push( replaceData( selector, '{{data.'+key+'}}', '{' + margeProps + '}' ) ); }
        }else if( value.itemOpenFontStyle2 ){
            // Typography
            let margeProps = '', smd = [], ssm = [], sxs = [];
            if( value.fontFamily ){
                if( !__.includes( ['Arial','Tahoma','Verdana','Helvetica','Times New Roman','Trebuchet MS','Georgia'], value.fontFamily ) ){
                    notResponsiveCss.push( "@import url('https://fonts.googleapis.com/css?family="+value.fontFamily.replace(' ', '+')+ "');" )
                }
                notResponsiveCss.push( replaceData( selector, '{{data.'+key+'}}' , '{ font-family: \''+value.fontFamily+'\','+( value.fontType ? value.fontType : 'sans-serif' )+'; }' ) );
            }
            __.forEach( ['fontStyle' ,'fontWeight' ,'textTransform' ,'fontSize' ,'textDecoration' ,'lineHeight' ,'letterSpacing'], property => {
                if( __.isObject( value[property] ) ){
                    if( value[property].md ){ smd.push( __.kebabCase(property) + ':' + value[property].md ) }
                    if( value[property].sm ){ ssm.push( __.kebabCase(property) + ':' + value[property].sm ) }
                    if( value[property].xs ){ sxs.push( __.kebabCase(property) + ':' + value[property].xs ) }
                } else {
                    if( value[property] ){ margeProps += __.kebabCase(property)+':' + value[property] + ';' }
                }
            })
            if( !__.isEmpty( smd ) ){ md.push( replaceData( selector, '{{data.'+key+'}}', '{' + smd.join(';') + '}' ) ) }
            if( !__.isEmpty( ssm ) ){ sm.push( replaceData( selector, '{{data.'+key+'}}', '{' + ssm.join(';') + '}' ) ) }
            if( !__.isEmpty( sxs ) ){ xs.push( replaceData( selector, '{{data.'+key+'}}', '{' + sxs.join(';') + '}' ) ) }
            if( margeProps ){ notResponsiveCss.push( replaceData( selector, '{{data.'+key+'}}', '{' + margeProps + '}' ) ); }
        }else if( value.bgFirst || value.bgSecond ){
            // Gradient
            let clipValue = ( value.clip ? '-webkit-background-clip: text; -webkit-text-fill-color: transparent;':'' );
            if( value.type == 'linear' ){
                if( value.direction && value.bgFirst && value.startPosition && value.bgSecond && value.endPosition ){
                    notResponsiveCss.push( replaceData( selector, '{{data.'+key+'}}' , '{ background : linear-gradient(' + value.direction + 'deg, ' + value.bgFirst + ' ' + value.startPosition + '%,'+ value.bgSecond + ' ' + value.endPosition + '%); ' + clipValue + ' }' ) )
                }
            } else {
                if( value.radialValue && value.bgFirst && value.startPosition && value.bgSecond && value.endPosition ){
                    notResponsiveCss.push( replaceData( selector, '{{data.'+key+'}}' , '{ background : radial-gradient( circle at ' + value.radialValue + ' , ' + value.bgFirst + ' ' + value.startPosition + '%,' + value.bgSecond + ' ' + value.endPosition + '%); ' + clipValue + ' }' ) )
                }
            }
        }else if( value.bgType ){
            // Background
            let background = '{';
            if( value.bgType == 'color' ){
                background += value.bgColor ? 'background-color: ' + value.bgColor + ';' : ''
            }
            else if( value.bgType == 'image' ){
                background +=   ( !__.isEmpty( value.bgImage ) ? 'background-image:url(' + value.bgImage.url + ');' : '' ) + 
                                ( value.bgimgPosition ? 'background-position:' + value.bgimgPosition + ';' : '' ) + 
                                ( value.bgimgAttachment ? 'background-attachment:' + value.bgimgAttachment + ';' : '' ) + 
                                ( value.bgimgRepeat ? 'background-repeat:' + value.bgimgRepeat + ';' : '' ) + 
                                ( value.bgimgSize ? 'background-size:' + value.bgimgSize + ';' : '' ) +
                                ( value.bgDefaultColor ? 'background-color:' + value.bgDefaultColor + ';' : '' )
            }
            else if( value.bgType == 'gradient' ){
                if( value.bgGradient.type == 'linear' ){
                    if( value.bgGradient.direction && value.bgGradient.bgFirst && value.bgGradient.startPosition && value.bgGradient.bgSecond && value.bgGradient.endPosition ){
                            background += 'background : linear-gradient(' + value.bgGradient.direction + 'deg, ' + value.bgGradient.bgFirst + ' ' + value.bgGradient.startPosition + '%,'+ value.bgGradient.bgSecond + ' ' + value.bgGradient.endPosition + '%);'
                    }
                } else {
                    if( value.bgGradient.radialValue && value.bgGradient.bgFirst && value.bgGradient.startPosition && value.bgGradient.bgSecond && value.bgGradient.endPosition ){
                            background += 'background : radial-gradient( circle at ' + value.bgGradient.radialValue + ' , ' + value.bgGradient.bgFirst + ' ' + value.bgGradient.startPosition + '%,' + value.bgGradient.bgSecond + ' ' + value.bgGradient.endPosition + '%);'
                    }
                }
            } else if ( value.bgType == 'video' ){
                if( value.bgVideoFallback ){
                    if( value.bgVideoFallback.url ){
                        background += 'background: #ffffff url('+value.bgVideoFallback.url+'); background-position: center; background-repeat: no-repeat; background-size: cover;'
                    }
                }
            }
            background += '}'
            if( background != '{}' ){ notResponsiveCss.push( selector + background ) }

            let backgroundHover = ':hover{';
            if( value.bgHoverType == 'color' ){
                backgroundHover += ( value.bgHoverColor ? 'background: ' + value.bgHoverColor + ';' : '' )
            }
            else if( value.bgHoverType == 'image' ){
                backgroundHover +=  ( !__.isEmpty(value.bgHoverImage) ? 'background-image:url(' + value.bgHoverImage.url + ');' : '' ) + 
                                    ( value.bgHoverimgPosition ? 'background-position:' + value.bgHoverimgPosition + ';' : '' ) +
                                    ( value.bgHoverimgAttachment ? 'background-attachment:' + value.bgHoverimgAttachment + ';' : '' ) +
                                    ( value.bgimgHoverRepeat ? 'background-repeat:' + value.bgimgHoverRepeat + ';' : '' ) +
                                    ( value.bgimgHoverSize ? 'background-size:' + value.bgimgHoverSize + ';' : '' ) +
                                    ( value.bgHoverDefaultColor ? 'background-color:' + value.bgHoverDefaultColor + ';' : '' )
            }
            else if( value.bgHoverType == 'gradient' ){
                if( value.bgHoverGradient.type == 'linear' ){
                    if( value.bgHoverGradient.direction && value.bgHoverGradient.bgFirst && value.bgHoverGradient.startPosition && value.bgHoverGradient.bgSecond && value.bgHoverGradient.endPosition ){
                        backgroundHover += 'background : linear-gradient(' + value.bgHoverGradient.direction + 'deg, ' + value.bgHoverGradient.bgFirst + ' ' + value.bgHoverGradient.startPosition + '%,'+ value.bgHoverGradient.bgSecond + ' ' + value.bgHoverGradient.endPosition + '%);'
                    }
                } else {
                    if( value.bgHoverGradient.radialValue && value.bgHoverGradient.bgFirst && value.bgHoverGradient.startPosition && value.bgHoverGradient.bgSecond && value.bgHoverGradient.endPosition ){
                        backgroundHover += 'background : radial-gradient( circle at ' + value.bgHoverGradient.radialValue + ' , ' + value.bgHoverGradient.bgFirst + ' ' + value.bgHoverGradient.startPosition + '%,' + value.bgHoverGradient.bgSecond + ' ' + value.bgHoverGradient.endPosition + '%);'
                    }
                }
            }
            backgroundHover += '}'
            if( backgroundHover != ':hover{}' ){ notResponsiveCss.push( selector + backgroundHover ) }
        }else if( value.colorType ){
            // Color2
            if( value.colorType == 'color' && value.colorColor ){
                notResponsiveCss.push( replaceData( selector, '{{data.'+key+'}}',  '{ '+( value.clip ? 'color' : 'background' )+':' + value.colorColor +'}' ) );
            }
            if( value.colorType == 'gradient' ){
                let clipValue = ( value.clip ? '-webkit-background-clip: text; -webkit-text-fill-color: transparent;':'' );
                if( value.colorGradient.type == 'linear' ){
                    if( value.colorGradient.direction && value.colorGradient.bgFirst && value.colorGradient.startPosition && value.colorGradient.bgSecond && value.colorGradient.endPosition ){
                        notResponsiveCss.push( replaceData( selector, '{{data.'+key+'}}' , '{ background: linear-gradient(' + value.colorGradient.direction + 'deg, ' + value.colorGradient.bgFirst + ' ' + value.colorGradient.startPosition + '%,'+ value.colorGradient.bgSecond + ' ' + value.colorGradient.endPosition + '%);' + clipValue + '}' ) )
                    }
                }else{
                    if( value.colorGradient.radialValue && value.colorGradient.bgFirst && value.colorGradient.startPosition && value.colorGradient.bgSecond && value.colorGradient.endPosition ){
                        notResponsiveCss.push( replaceData( selector, '{{data.'+key+'}}' , '{ background: radial-gradient( circle at ' + value.colorGradient.radialValue + ' , ' + value.colorGradient.bgFirst + ' ' + value.colorGradient.startPosition + '%,' + value.colorGradient.bgSecond + ' ' + value.colorGradient.endPosition + '%); ' + clipValue + '}'  ) )
                    }
                }
            }
        }else if( value.itemOpenShape ){
            // Shape
            let data = shapeCssGenerator( selector, key, value )
            if( data[1] ){ md = [ ...md, ...data[1]] }
            if( data[2] ){ sm = [ ...sm, ...data[2]] }
            if( data[3] ){ xs = [ ...xs, ...data[3]] }
            notResponsiveCss.push( data[0] )
        }else if( value.itemOpenFilter ){
            // Filter
            let filter = ( value.brightness ? 'brightness('+value.brightness+') ' : '' ) + 
                ( value.contrast ? 'contrast('+value.contrast+') ' : '' ) + 
                ( value.saturate ? 'saturate('+value.saturate+') ' : '' ) + 
                ( value.sepia ? 'sepia('+value.sepia+') ' : '' ) + 
                ( value.invert ? 'invert('+value.invert+') ' : '' ) + 
                ( value.grayscale ? 'grayscale('+value.grayscale+') ' : '' ) + 
                ( value.huerotate ? 'hue-rotate('+value.huerotate+') ' : '' ) 
            if( filter ){
                notResponsiveCss.push( replaceData( selector, '{{data.'+key+'}}', '{filter:'+ filter +'}') )
            }
        }else if( value.top || value.right || value.bottom || value.left ){
            // Dimension Not Responsive
            let topSpace = '0px', rightSpace = '0px', bottomSpace = '0px', leftSpace = '0px';
            if( value.top ){ topSpace = value.top }
            if( value.right ){ rightSpace = value.right }
            if( value.bottom ){ bottomSpace = value.bottom }
            if( value.left ){ leftSpace = value.left }
            notResponsiveCss.push( replaceData( selector, '{{data.'+key+'}}', topSpace+' '+rightSpace+' '+bottomSpace+' '+leftSpace+';' ) );
        }else if( value.url ){
            notResponsiveCss.push( replaceData( selector, '{{data.'+key+'}}', value.url ) )
        }
    } else {
        if( value && key != 'id' ){
            notResponsiveCss.push( replaceData( selector, '{{data.'+key+'}}', value ) )
        }
    }

    return { notResponsiveCss: notResponsiveCss, md: md, sm: sm, xs: xs }
}

export const CssGenerator = ( addon, type, action ) => {
    let rawData = '',
        styleData = '';
    let addonMain = __.clone(addon);
    if( type == 'addon' ){
        let wppbStyleTmpl = document.getElementById('wppb-tmpl-addon-style-'+addon.name);
        if (wppbStyleTmpl){
            styleData   = wppbStyleTmpl.innerHTML
        }
    }else if( type == 'row' ){
        styleData   = document.getElementById('wppb-tmpl-row-style').innerHTML
    }else if( type == 'col' ){
        styleData   = document.getElementById('wppb-tmpl-col-style').innerHTML
    }else if( type == 'widget' ){
        styleData   = document.getElementById('wppb-tmpl-addon-widget').innerHTML
    }
    if( styleData ){ rawData = JSON.parse( styleData ); }

    // Responsive - notResponsive Find Out
    let notResponsiveCss = [],
        md = [],
        sm = [],
        xs = [];
    
    if( !__.isEmpty(addonMain.settings) ){
        __.forEach( addonMain.settings , function( value, key ){
            if( rawData[key] ){
                let selector = '';
                if( type == 'addon' || type == 'widget' ){
                    selector = replaceData( rawData[key], '{{SELECTOR}}' , '.wppb-addon-'+addonMain.id )
                }else if( type == 'row' ){
                    selector = replaceData( rawData[key],'{{SELECTOR}}' , '.wppb-row-'+addonMain.id )
                }else if( type == 'col' ){
                    selector = replaceData( rawData[key], '{{SELECTOR}}' , '.wppb-col-'+addonMain.id )
                }
                let output = cssOutput( value, key, selector );

                if( !__.isEmpty(output.notResponsiveCss) ){
                    notResponsiveCss = notResponsiveCss.concat(output.notResponsiveCss)
                }

                if( !__.isEmpty(output.md) ){ md = md.concat( output.md ) }
                if( !__.isEmpty(output.sm) ){ sm = sm.concat( output.sm ) }
                if( !__.isEmpty(output.xs) ){ xs = xs.concat( output.xs ) }

            } else {
                if ( __.isArray(value) ){
                    __.forEach( value, (val , ke) => {
                        __.forEach( val, (v,k) => {
                            if( rawData[key+'.'+k] && type == 'addon' && v ){
                                let selector = replaceData( rawData[key+'.'+k], '{{SELECTOR}}' , '.wppb-addon-'+addonMain.id+' .repeater-'+ke+' ' );
                                let output = cssOutput( v, k, selector );
                                if( !__.isEmpty(output.notResponsiveCss) ){ notResponsiveCss = notResponsiveCss.concat(output.notResponsiveCss) }
                                if( !__.isEmpty(output.md) ){ md = md.concat( output.md ) }
                                if( !__.isEmpty(output.sm) ){ sm = sm.concat( output.sm ) }
                                if( !__.isEmpty(output.xs) ){ xs = xs.concat( output.xs ) }
                            }else{
                                if( __.isArray(v) ){ // repetable inside repetable
                                    __.forEach( v, (v_i , k_i) => {
                                        __.forEach( v_i, (v_ii,k_ii) => {
                                            if( rawData[key+'.'+k_ii] && type == 'addon' && v_ii ){
                                                let selector = replaceData( rawData[key+'.'+k_ii], '{{SELECTOR}}' , '.wppb-addon-'+addonMain.id+' .repeater-'+ke+' .repeater-'+k_i );
                                                let output = cssOutput( v_ii, k_ii, selector );
                                                if( !__.isEmpty(output.notResponsiveCss) ){ notResponsiveCss = notResponsiveCss.concat(output.notResponsiveCss) }
                                                if( !__.isEmpty(output.md) ){ md = md.concat( output.md ) }
                                                if( !__.isEmpty(output.sm) ){ sm = sm.concat( output.sm ) }
                                                if( !__.isEmpty(output.xs) ){ xs = xs.concat( output.xs ) }
                                            }
                                        })
                                    })
                                }
                            }
                        })
                    })
                }
            }
        });
    }

    let styleCss = '';
    if( md.length){
        styleCss = md.join('');
    }
    if( sm.length ){
        styleCss += '@media (min-width: 768px) and (max-width: 991px) {' + sm.join('') + '}';
    }
    if( xs.length ){
        styleCss += '@media (max-width: 767px) {' + xs.join('') + '}';
    }

    //Responsive Settings
    if( __.isObject(addon.settings) ){
        let typeVal = type;
        if( type == 'widget' ){ typeVal = 'addon' }
        if( addon.settings[typeVal+'_custom_css'] ){
            styleCss += replaceData( addon.settings[typeVal+'_custom_css'], '{{SELECTOR}}' , '.wppb-'+typeVal+'-'+addonMain.id )
        } // Custom CSS Add

        
        if( action == 'return' ){
            if( addon.settings[typeVal+'_hidden_lg'] ){ styleCss += '@media (min-width: 1200px) { .wppb-'+typeVal+'-'+addon.id+'{ display:none !important; }}' }                        // Hide on Mobile LG Column
            if( addon.settings[typeVal+'_hidden_md'] ){ styleCss += '@media (min-width: 992px) and (max-width: 1199px) { .wppb-'+typeVal+'-'+addon.id+'{ display:none !important; }}' } // Hide on Mobile MD Column
            if( addon.settings[typeVal+'_hidden_sm'] ){ styleCss += '@media (min-width: 768px) and (max-width: 991px) { .wppb-'+typeVal+'-'+addon.id+'{ display:none !important; }}' }  // Hide on Mobile SM Column
            if( addon.settings[typeVal+'_hidden_xs'] ){ styleCss += '@media (max-width: 767px) { .wppb-'+typeVal+'-'+addon.id+'{ display:none !important; }}' }                         // Hide on Mobile XS Column   
        }
    }

    // Remove Not Used Template
    let fonts = [];
    if( !__.isEmpty(notResponsiveCss) ){
        __.forEach( notResponsiveCss , (value, key ) => {
            if(value){
                ( value.indexOf('{{data.') != -1 ? delete notResponsiveCss[key] : null );
                if (__.includes(value, 'https://fonts.googleapis.com/css') ){
                    delete notResponsiveCss[key];
                    fonts.push(value);
                }
            }
        });
        styleCss += __.map( notResponsiveCss ).join('');
    }

    if( !__.isEmpty(fonts) ){
        styleCss = __.map( fonts ).join('') + styleCss;
    }

    if( action == 'setinline' ){
        if( type == 'addon' || type == 'widget' ){
            setInternalStyle( styleCss , 'addon-'+addon.id );
        }else if( type == 'row' ){
            setInternalStyle( styleCss , 'row-'+addon.id );
        }else if( type == 'col' ){
            setInternalStyle( styleCss , 'col-'+addon.id );
        }
    }else if( action == 'return' ){
        return styleCss;
    }
}

export const setInternalStyle = ( styleCss, typeID ) => {
    let styleSelector = window.frames['wppb-builder-view'].window.document;
    if( styleSelector.getElementById( 'wppb-'+typeID ) === null ){
        let cssInline = document.createElement('style');
        cssInline.type = 'text/css';
        cssInline.id = 'wppb-'+typeID;
        if (cssInline.styleSheet) {
            cssInline.styleSheet.cssText = styleCss;
        } else {
            cssInline.innerHTML = styleCss;
        }
        styleSelector.getElementsByTagName("head")[0].appendChild( cssInline );
    } else {
        styleSelector.getElementById( 'wppb-'+typeID ).innerHTML = styleCss;
    }
}