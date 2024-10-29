<?php
/*
* Plugin Name: Add Metadata
* Description: This is a free plugin for adding meta tag to your website, which includes title, description, image, author and URL and site name of your published post of your website. If you have no image in your post, it will also ask for a default image for metadata.
* Author: Syed Ebraiz Ali Chishti
* Version: 1.1.0
*/

function wpmetadata_head(){
	if(is_single()){ ?>
		<meta property="og:title" content="<?php the_title() ?>" />
		<meta property="og:url" content="<?php the_permalink() ?>" />
		<meta property="og:description" content="<?php the_excerpt() ?>" />
		<meta property="og:site_name" content="<?php bloginfo('name') ?>" />
<?php
	if(has_post_thumbnail()){
		$image = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');
		?>
		<meta property="og:image" content="<?php echo $image[0] ?>" /><!--Featured Image will be displayed-->
		<?php }else{ ?>
		<meta property="og:image" content="<?php echo esc_attr(get_option('default-image-url')) ?>" /><!--Default Image will be displayed-->
		<?php } } }
		add_action('wp_head','wpmetadata_head');

//Plugin Setting Page
	function wpmetadata_settings(){
		add_menu_page('Metadata Plugin',
				'Add Meta Tags',
				'administrator',
				'metadatatags',
				'wpmetadata_page',
				'dashicons-nametag',
				'90');
			}
	add_action('admin_menu','wpmetadata_settings');	
	
	function wpmetadata_options(){
		register_setting('meta-data-group','active-meta-data');
		register_setting('meta-data-group','default-image-url');
	}
	add_action('admin_init','wpmetadata_options');
	
	function wpmetadata_page(){ ?>
		<div class='wrap'>
		<h1>Metadata Plugin Settings</h1><br>
			<form action="options.php" method="post">
				<?php settings_fields('meta-data-group'); ?>
				<?php do_settings_sections('meta-data-group'); ?>
				<label>Default Image URL: </label>
				<input type="text" name="default-image-url" value="<?php echo esc_attr(get_option('default-image-url')) ?>" />
				<?php submit_button(); ?>
 			</form>
		</div>
	<?php } 
	//Scripts & Styles
	function wpmetadata_css(){
		wp_register_style('wpmetadata_custom_plugin_css',plugin_dir_url(_FILE_).'assets/css/main.css',false,'1.0.0');
		wp_enqueue_style('wpmetadata_custom_plugin_css');
	}
	add_action('admin_enqueue_scripts','wpmetadata_css');
	add_action('wp_enqueue_scripts','wpmetadata_css');//this add_action funciton will help for adding custom css file but for front page and not for admin page.

	function wpmetadata_js(){ //function for adding custom js file
		wp_enqueue_script('wpmetadata_custom_plugin_js',plugin_dir_url(_FILE_).'assets/js/custom_js.js','','',true);
	}
	add_action('wp_enqueue_scripts','wpmetadata_js');
	?>