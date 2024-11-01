<?php
 

/**
 * @since    1.0.0
 */
//class themepacific_pviews_counter {
class themepacific_pviews_counter {

 
	protected $loader;
 
 	protected $version;
 
	public function __construct() {

 		$this->version = '1.0.0';
 		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

 
	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/tp_pviews_admin.php'; 
		require_once plugin_dir_path(dirname( __FILE__ )) .'public/tp_pviews_functions.php';
		require_once plugin_dir_path(dirname( __FILE__ )) .'public/tp_pviews_output.php';
		require_once plugin_dir_path( __FILE__ ) . 'tp_pviews_loader.php';

		$this->loader = new tp_pviews_Loader();

	}

 
	private function define_admin_hooks() {

		$admin = new tp_pviews_Admin( $this->get_version() );
  		$this->loader->add_action('admin_init', $admin,'admin_init');
		$this->loader->add_action('admin_menu', $admin, 'admin_menu', 99);
	}
 
 
	private function define_public_hooks() {

 		$public = new tp_pviews_public($this->get_version());	 
		$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_styles' );
		$this->loader->add_filter('the_content', $public, 'the_content');
        $this->loader->add_filter('the_excerpt', $public, 'the_content');
		$this->loader->add_action( 'wp_ajax_nopriv_tp_postviews', $public, 'themepacific_postviews' );
		$this->loader->add_action( 'wp_ajax_tp_postviews', $public, 'themepacific_postviews' );
 	}

 
	public function run() {
		$this->loader->run();
	}
	public function get_version() {
		return $this->version;
	}
 

}