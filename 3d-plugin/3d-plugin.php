
<?php
/*
 * Plugin Name: 3d-plugin
 */
$glbFile = '';
function portfolio_cpt() {
    $args = array(
        'label'  => '3d_Product',
        'public' => true,
    );

    register_post_type( '3d_Product', $args );
}

add_action( 'init', 'portfolio_cpt' );

@ini_set( ‘upload_max_size’ , ‘100M’ );
@ini_set( ‘post_max_size’, ‘100M’);
@ini_set( ‘max_execution_time’, ‘300’ );
@ini_set( ‘memory_limit’, ’100M’ );
define('ALLOW_UNFILTERED_UPLOADS', true);
add_filter( 'upload_mimes', 'my_custom_mime_types' );
function my_custom_mime_types( $mimes ) {

// New allowed mime types.
    $mimes['svg'] = 'image/svg+xml';
    $mimes['glb'] = 'model/gltf-binary';
    $mimes['glb2'] = 'model/gltf+json';

// Optional. Remove a mime type.
    // unset( $mimes['exe'] );

    return $mimes;
}

/**
 * Add custom attachment metabox.
 */
function special_plugin_styles() {
    wp_register_style('special', plugins_url('style.css', __FILE__));
    wp_enqueue_style('special');
}
add_action( 'wp_enqueue_scripts', 'special_plugin_styles' );
function add_custom_meta_boxes() {
    add_meta_box(
        'wp_custom_attachment',
        'glb File',
        'wp_custom_attachment',
        '3d_Product',
        'side'
    ) ;
}
add_action( 'add_meta_boxes', 'add_custom_meta_boxes' );
/**
 * Custom attachment metabox markup.
 */
function wp_custom_attachment() {
    wp_nonce_field( plugin_basename(__FILE__), 'wp_custom_attachment_nonce' );
    //   phpinfo();
    $html = '<p class="description">Upload your GLB here.</p>';
    $html .= '<input id="wp_custom_attachment" name="wp_custom_attachment" size="25" type="file" value="" />';

    $filearray = get_post_meta( get_the_ID(), 'wp_custom_attachment', true );
    $this_file = $filearray['url'];

    $GLOBALS['glbFileUrl'] = $GLOBALS['glbFile'];

   // echo $filearray['url'];
    //  var_dump($filearray);

    if ( $this_file != '' ) {
        $html .= '<div><p>Current file: ' . $this_file . '</p></div>';
    }
    echo $html;
//echo dirname( __FILE__ ) . '/single-3d_product.php';
}
/**
 * Save custom attachment metabox info.
 */
function save_custom_meta_data( $id ) {
    if ( ! empty( $_FILES['wp_custom_attachment']['name'] ) ) {
        $supported_types = array( 'model/gltf-binary' );
        $arr_file_type = wp_check_filetype( basename( $_FILES['wp_custom_attachment']['name'] ) );
        $uploaded_type = $arr_file_type['type'];

        if ( in_array( $uploaded_type, $supported_types ) ) {
            $upload = wp_upload_bits($_FILES['wp_custom_attachment']['name'], null, file_get_contents($_FILES['wp_custom_attachment']['tmp_name']));

            makeUSDZ( $upload['file']);
            if ( isset( $upload['error'] ) && $upload['error'] != 0 ) {
                wp_die( 'There was an error uploading your file. The error is: ' . $upload['error'] );
            } else {
                add_post_meta( $id, 'wp_custom_attachment', $upload );
                update_post_meta( $id, 'wp_custom_attachment', $upload );
            }
        }
        else {
         //   var_dump($arr_file_type);
            wp_die( "The file type that you've uploaded is not a GLB.".$arr_file_type);

        }
    }
}
add_action( 'save_post', 'save_custom_meta_data' );
/**
 * Add functionality for file upload.
 */
function update_edit_form() {
    echo ' enctype="multipart/form-data"';
}
add_action( 'post_edit_form_tag', 'update_edit_form' );

add_filter( 'single_template', 'wpa3396_page_template' );
function wpa3396_page_template( $single )
{
    global $post;
    if ($post->post_type == '3d_product') {
        $single = dirname( __FILE__ ) . '/single-3d_product.php';
    }
    return $single;
}
?>
<?php
function makeUSDZ($test){
    // global $glbFile;
    // var_dump($test2);
    // exit;
    $cmd = 'python /var/www/html/usdpython60/usdzconvert/usdzconvert.py '.$test;// - В переменную добавляем команду.
    $out=exec($cmd, $output, $value);

}
?>
<?php
function size($test){
    // global $glbFile;
    // var_dump($test2);
    // exit;
    $cmd = 'vi /etc/nginx/nginx.conf';
    $out=exec($cmd, $output, $value);
    $cmd2='client_max_body_size 40M;';
    $out2=exec($cmd2, $output, $value);
}
?>
<?php

?>