<?php

class tp_pviews_Admin {

 	private $version;
  
	public function __construct( $version ) {
		$this->version = $version;
	}


 

 public	function admin_menu() 
	{
		$icon_url = plugins_url( '/images/favicon.png', __FILE__ );
		
		$page_hook = add_menu_page( __( 'Themepacific PostViews Settings', 'tp_postviews'), 'TP Postviews', 'update_core', 'tp_postviews', array(&$this, 'settings_page'), $icon_url );
		
		add_submenu_page( 'tp_postviews', __( 'Settings', 'tp_postviews' ), __( 'Themepacific PostViews Settings', 'tp_postviews' ), 'update_core', 'tp_postviews', array(&$this, 'settings_page') );
		 
		 
 	}

	public function admin_init()
	{
		register_setting( 'tp_postviews', 'tp_pviews_settings', array(&$this, 'settings_validate') );
		
		add_settings_section( 'tp_postviews', '', array(&$this, 'section_tp_intro'), 'tp_postviews' );

		add_settings_field( 'tp_show_on', __( 'Show Views on', 'tp_postviews' ), array(&$this, 'setting_tp_show_on'), 'tp_postviews', 'tp_postviews' );
 		add_settings_field( 'exclude_posts', __( 'Exclude from Post/Page ID', 'tp_postviews' ), array(&$this, 'setting_exclude_from'), 'tp_postviews', 'tp_postviews' );
		add_settings_field( 'custom_meta', __( 'Add Custom Post Meta Key', 'tp_postviews' ), array(&$this, 'setting_custom_meta'), 'tp_postviews', 'tp_postviews' );
		add_settings_field( 'add_class', __( 'Add Your Class Name', 'tp_postviews' ), array(&$this, 'setting_add_class'), 'tp_postviews', 'tp_postviews' );
		add_settings_field( 'views_text', __( 'Enter the text after View Count', 'tp_postviews' ), array(&$this, 'setting_views_text'), 'tp_postviews', 'tp_postviews' );

		
 		
 		
 		add_settings_field( 'tp_instructions', __( 'Shortcode and Template Tag', 'tp_postviews' ), array(&$this, 'setting_tp_instructions'), 'tp_postviews', 'tp_postviews' );
	}	

	public function section_tp_intro()
	{
	    ?>
		<p><?php _e('Themepacific Postviews (TP Postviews) Plugin will collect view counts using AJAX technique. In this settings you can control the TP Postviews options', 'tp_postviews'); ?></p>
		<p><?php _e('Check out our other free <a href="http://themepacific.com/wp-plugins/?ref=tp_pviews">plugins</a> and <a href="http://themepacific.com/?ref=tp_pviews">themes</a>.', 'tp_postviews'); ?></p>
		<?php
		
	}
		function setting_tp_show_on()
	{
		$options = get_option( 'tp_pviews_settings' );
		if( !isset($options['show_in_post']) ) $options['show_in_post'] = '0';
		if( !isset($options['show_in_page']) ) $options['show_in_page'] = '0';
		if( !isset($options['show_in_loops']) ) $options['show_in_loops'] = '0';
		
		echo '<input type="hidden" name="tp_pviews_settings[show_in_post]" value="0" />
		<label><input type="checkbox" name="tp_pviews_settings[show_in_post]" value="1"'. (($options['show_in_post']) ? ' checked="checked"' : '') .' />
		'. __('Posts', 'tp_postviews') .'</label><br />
		<input type="hidden" name="tp_pviews_settings[show_in_page]" value="0" />
		<label><input type="checkbox" name="tp_pviews_settings[show_in_page]" value="1"'. (($options['show_in_page']) ? ' checked="checked"' : '') .' />
		'. __('Pages', 'tp_postviews') .'</label><br />
		<input type="hidden" name="tp_pviews_settings[show_in_loops]" value="0" />
		<label><input type="checkbox" name="tp_pviews_settings[show_in_loops]" value="1"'. (($options['show_in_loops']) ? ' checked="checked"' : '') .' />
		'. __('Home, Archive, Search Pages', 'tp_postviews') .'</label><br />';
	}		
 
 	
	public	function setting_exclude_from()
	{
		$options = get_option( 'tp_pviews_settings' );
		if( !isset($options['exclude_posts']) ) $options['exclude_posts'] = '';
		
		echo '<input type="text" name="tp_pviews_settings[exclude_posts]" class="regular-text" value="'. $options['exclude_posts'] .'" />
		<p class="description">'. __('Enter the post/page ids like this id, id, id (ex: 123,121,191)', 'tp_postviews') . '</p>';
	} 	
	
	public function setting_views_text()
	{
		$options = get_option( 'tp_pviews_settings' );
		if( !isset($options['views_text']) ) $options['views_text'] = '';
		
		echo '<input type="text" name="tp_pviews_settings[views_text]" class="regular-text" value="'. $options['views_text'] .'" />
		<p class="description">'. __('Like Views or Post Views', 'tp_postviews') . '</p>';
	}	
	
	public function setting_custom_meta()
	{
		$options = get_option( 'tp_pviews_settings' );
		if( !isset($options['custom_meta']) ) $options['custom_meta'] = 'tp_postviews';
		
		echo '<input type="text" name="tp_pviews_settings[custom_meta]" class="regular-text" value="'. $options['custom_meta'] .'" />
		<p class="description">'. __('Optional: Enter Custom Post Meta Key for Post Count. Default: <code>tp_postviews</code>', 'tp_postviews') . '</p>';
	}
 
 			
	public function setting_add_class()
	{
		$options = get_option( 'tp_pviews_settings' );
		if( !isset($options['add_class']) ) $options['add_class'] = '';
		
		echo '<input type="text" name="tp_pviews_settings[add_class]" class="regular-text" value="'. $options['add_class'] .'" />
		<p class="description">'. __('Enter class Name for Style the output)', 'tp_postviews') . '</p>';
	}
 
 		
 
	
		function setting_tp_instructions()
	{
		echo '<p>'. __(' Themepacific Views stats can be easily displayed using this Shortcode.', 'tp_postviews') .'</p>
		<p><code>[tp_postviews]</code></p>
		<p>'. __('Also, Themepacific Views  Stats can be easily displayed manually in your theme using the following PHP Function:', 'tp_postviews') .'</p>
		<p><code>&lt;?php if( function_exists(\'tp_pviews_count\') ) tp_pviews_count(); ?&gt;</code></p>';
	}
		function settings_validate($input)
	{
	    $input['exclude_posts'] = str_replace(' ', '', trim(strip_tags($input['exclude_posts'])));
		
		return $input;
	}
	
public function settings_page()
	{
		?>
		<div class="wrap">
			<div id="icon-themes" class="icon32"></div>
			<h2><?php _e('Themepacific Postview Settings', 'tp_postviews'); ?></h2>
			<?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] ){ ?>
			<div id="setting-error-settings_updated" class="updated settings-error"> 
				<p><strong><?php _e( 'Settings saved.', 'tp_postviews' ); ?></strong></p>
			</div>
			<?php } ?>
			<form action="options.php" method="post">
				<?php settings_fields( 'tp_postviews' ); ?>
				<?php do_settings_sections( 'tp_postviews' ); ?>
				<p class="submit"><input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'tp_postviews' ); ?>" /></p>
			</form>
		</div>
		<?php
	}
	
	/**
	 * Enqueues the style sheet  
	 *  
	 */
	public function enqueue_styles() {
 

	}	/**
	 * Enqueues the Scripts
	 */
	public function enqueue_scripts() {
 

	}


} 