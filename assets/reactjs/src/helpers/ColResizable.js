import EditPanelManager from './EditPanelManager';

export const ColResizable = () => {
    let selector = window.frames['wppb-builder-view'].window.document;
    let colTotalWdt;
    let $resizeSL = jQuery( selector ).find( ".wppb-column-parent" );

    $resizeSL.resizable({
        handles: "e",
        start: function(event, ui) {
            EditPanelManager.resetAll();
            let target = ui.element;
            let totalWidth = jQuery( this ).closest( '.wppb-row' ).width();
            let minWidth = totalWidth/10;
            let targetWdt = ui.originalSize.width;
            let nextWdt = ui.originalElement.next().outerWidth();
            colTotalWdt = targetWdt + nextWdt;
            target.resizable('option', 'minWidth', minWidth);
            target.resizable('option', 'maxWidth', (colTotalWdt - minWidth))
        },
        stop: function(event, ui) {
            
            let layout = [];
            let totalWidth = jQuery( this ).closest( '.wppb-row' ).width();

            let parentColClass = '.wppb-column-parent';
            if (jQuery( this ).closest( ".wppb-row-parent" ).hasClass('wppb-inner-row-parent')){
                totalWidth = jQuery(this).closest('.wppb-row').width();
            }else{
                parentColClass = "> .wppb-column-parent";
            }

            //This is top row col
            jQuery( this ).closest( ".wppb-row" ).find(parentColClass).each(function(){
                layout.push( (100 * jQuery(this).width()/ totalWidth).toFixed(5) )
            });

            let colIndex = jQuery(this).attr('data-col-index');
            let rowIndex = jQuery(this).closest('.wppb-row-parent').attr('data-row-index');
            let indexOfNodes = [rowIndex, colIndex];  // Node means Row, Column, InnerRow, InnerColumn
            
            if (jQuery( this ).closest( ".wppb-row-parent" ).hasClass('wppb-inner-row-parent')){
                let topParentRowIndex = jQuery( this ).closest('.wppb-row-parent').parent().closest('.wppb-row-parent').attr('data-row-index');
                let topParentColIndex = jQuery(this).parent().closest('.wppb-column-parent').attr('data-col-index');
                indexOfNodes.unshift(topParentRowIndex, topParentColIndex);
            }
            jQuery(document).trigger('wppb_col_resized', [layout, indexOfNodes]);
            ui.originalElement.removeAttr("style")
            ui.originalElement.next().removeAttr("style")
        },
        resize: function(event, ui){
            ui.originalElement.next().width(colTotalWdt - ui.size.width);
        }
    });

}