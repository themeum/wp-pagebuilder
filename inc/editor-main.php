<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wp_version;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo __( 'WP PageBuilder', 'wp-pagebuilder' ) . ' | ' . get_the_title(); ?></title>
	<?php wp_head(); ?>
	<script>
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>';
    </script>
    <script type="text/javascript">
        function onLoadHandler(){
            if( typeof  document.getElementById('wppbMainIframeLoadingWrap') != 'undefined' ){
                document.getElementById('wppbMainIframeLoadingWrap').style.display='none';
            }
        }
    </script>
</head>
<body class=" wp-version-<?php echo str_replace( '.', '-', $wp_version ); ?> wppb-frontend-active">
    <div class="wppb-iframe-loading-wrap" id="wppbMainIframeLoadingWrap" >
        <img src="<?php echo WPPB_DIR_URL.'assets/img/loading-md.svg'; ?>" alt="loading"/>
    </div>
    <div id="wppb-page-builder">
        <?php $load_iframe_url = add_query_arg( array('load_for' => 'wppb_editor_iframe') , get_the_permalink(get_the_ID())); ?>
        <iframe width="100%" height="400" id="wppb-builder-view" data-page-id="<?php echo get_the_ID(); ?>" name="wppb-builder-view" src="<?php echo $load_iframe_url; ?>" onload="onLoadHandler();"></iframe>
        <div id="wppb-builder-page-tools" class="wppb-builder-page-tools"></div>
    </div>
    <?php
        wp_footer();
        do_action( 'admin_print_footer_scripts' );
    ?>
</body>
</html>
