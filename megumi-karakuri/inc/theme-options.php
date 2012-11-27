<?php
/**
 * Megumi Karakuri Theme Options
 *
 * @package WordPress
 * @subpackage Megumi Karakuri
 * @since Megumi Karakuri 1.0
 */
// Add Themes Logo field
add_action( 'admin_menu', 'admin_karakuri_themes_menu' );
function admin_karakuri_themes_menu() {
	add_theme_page( __( 'Custom Logo', 'karakuri' ), __( 'Custom Logo', 'karakuri' ), 'administration', 'themes-logo', 'add_themes_logo_edit_page');
}

add_action('admin_print_scripts-appearance_page_themes-logo', 'themes_logo_js_includes' );
function themes_logo_js_includes() {
	add_thickbox();
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'custom-header' );
	wp_enqueue_script('farbtastic');
	wp_enqueue_script('imgareaselect');
}

add_action('admin_print_styles-appearance_page_themes-logo', 'themes_logo_css_includes' );
function themes_logo_css_includes() {
	wp_enqueue_style('farbtastic');
	wp_enqueue_style('imgareaselect');
}

add_filter( 'attachment_fields_to_edit', 'karakuri_attachment_fields_to_edit', 10, 2 );
//add_filter( 'media_upload_tabs', 'karakuri_filter_upload_tabs' );
//add_filter( 'media_upload_mime_type_links', '__return_empty_array' );
function karakuri_attachment_fields_to_edit( $form_fields, $post ) {
if ( isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'custom-logo' ) {
	$form_fields = array();
	$href = esc_url(add_query_arg(array(
		'page' => 'custom-logo',
		//'step' => 2,
		'_wpnonce-custom-logo-upload' => wp_create_nonce('custom-logo-upload'),
		'file' => $post->ID
	), admin_url('themes.php')));

	$form_fields['buttons'] = array( 'tr' => '<tr class="submit"><td></td><td><a data-location="' . $href . '" class="wp-set-header">' . __( 'Set as header', 'karakuri' ) . '</a></td></tr>' );
	$form_fields['context'] = array( 'input' => 'hidden', 'value' => 'custom-logo' );
}
	return $form_fields;
}
function karakuri_filter_upload_tabs() {
if ( isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'custom-header' ) {
	return array( 'library' => __('Media Library', 'karakuri') );
}
}

add_action( 'custom_header_options', 'site_title_image_form', 1000 );
function add_themes_logo_edit_page() {
	global $_wp_theme_features;
	global $hook_suffix;

	echo '<pre>';
	var_dump($hook_suffix);
	echo '</pre>';
	if ( $site_title_image_src = get_theme_mod( 'site_title_image' ) ) {
		$title_preview = '<div style="width: ' . SITE_TITLE_IMAGE_WIDTH . 'px; height: ' . SITE_TITLE_IMAGE_HEIGHT . 'px; background: url( ' . $site_title_image_src . ' ) no-repeat;">&nbsp;</div>';
	} else {
		$title_preview = '<p>' . __( 'Site logo image is not set.', 'karakuri' ) . '</p>';
	}
?>
<div class="wrap">
<?php screen_icon(); ?>
<h2><?php _e('Custom Logo', 'karakuri'); ?></h2>
<?php /* if ( ! empty( $this->updated ) ) { ?>
<div id="message" class="updated">
<p><?php printf( __( 'Header updated. <a href="%s">Visit your site</a> to see how it looks.' ), home_url( '/' ) ); ?></p>
</div>
<?php } */ ?>
<h3><?php _e( 'Site Logo', 'karakuri' ); ?></h3>
<table class="form-table">
	<tbody>
		<tr valign="top">
			<th scope="row"><?php _e( 'Preview', 'karakuri' ); ?></th>
			<td><?php echo $title_preview; ?></td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Select Image', 'karakuri' ); ?></th>
			<td>
			<form enctype="multipart/form-data" id="upload-form" method="post" action="<?php echo esc_attr( add_query_arg( 'step', 2 ) ) ?>">
	<p>
		<label for="upload"><?php _e( 'Choose an image from your computer:', 'karakuri' ); ?></label><br />
		<input type="file" id="upload" name="import" />
		<input type="hidden" name="action" value="save" />
		<?php wp_nonce_field( 'custom-logo-upload', '_wpnonce-custom-logo-upload' ); ?>
		<?php submit_button( __( 'Upload', 'karakuri' ), 'button', 'submit', false ); ?>
	</p>
	<?php
		$image_library_url = get_upload_iframe_src( 'image', null, 'library' );
		$image_library_url = remove_query_arg( 'TB_iframe', $image_library_url );
		$image_library_url = add_query_arg( array( 'context' => 'custom-logo', 'TB_iframe' => 1 ), $image_library_url );
	?>
	<p>
		<label for="choose-from-library-link"><?php _e( 'Or choose an image from your media library:', 'karakuri' ); ?></label><br />
		<a id="choose-from-library-link" class="button thickbox" href="<?php echo esc_url( $image_library_url ); ?>"><?php _e( 'Choose Image', 'karakuri' ); ?></a>
	</p>
	</form>
			<input type="file" sise="50" id="site_title" name="site_title" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Reset Image', 'karakuri' ); ?></th>
			<td>
			<p><?php _e( 'This will restore the original header image. You will not be able to restore any customizations.', 'karakuri' ) ?></p>
			<?php submit_button( __( 'Restore Original Header Image', 'karakuri' ), 'button', 'resetheader', false ); ?>
			</td>
		</tr>
	</tbody>
</table>
</div>
<?php }

function site_title_image_upload_process() {
    if ( isset( $_POST['remove_site_title_image'] ) ) {
        check_admin_referer( 'custom-header-options', '_wpnonce-custom-header-options' );
        remove_theme_mod( 'site_title_image' );
        return;
    } elseif ( isset( $_FILES['site_title'] ) ) {
        check_admin_referer( 'custom-header-options', '_wpnonce-custom-header-options');
     
        if ( ! current_theme_supports( 'custom-header-uploads' ) )
            wp_die( 'Cheatin&#8217; uh?' );
     
        $overrides = array('test_form' => false);
        $file = wp_handle_upload($_FILES['site_title'], $overrides );
     
        if ( isset($file['error']) )
            wp_die( $file['error'],  __( 'Image Upload Error', 'karakuri' ) );
     
        $url = $file['url'];
        $type = $file['type'];
        $file = $file['file'];
        $filename = basename($file);
     
        // Construct the object array
        $object = array(
            'post_title' => $filename,
            'post_content' => $url,
            'post_mime_type' => $type,
            'guid' => $url
        );
         
        $id = wp_insert_attachment($object, $file);
        list( $width, $height, $type, $attr ) = getimagesize( $file );
     
        wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file ) );
     
        set_theme_mod( 'site_title_image', esc_url($url) );
    }
}
 
function add_upload_process_action() {
    global $custom_image_header;
    add_action( 'admin_head-' . $custom_image_header->page, 'site_title_image_upload_process' );
}
add_action( 'admin_menu', 'add_upload_process_action', 11 );
