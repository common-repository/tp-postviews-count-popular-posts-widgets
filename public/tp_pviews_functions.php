<?php 

class tp_pviews_public {

	private $version;

	public function __construct($version) {

		$this->version = $version;
		add_shortcode('tp_postviews',array($this, 'tp_pviews_shortcode'));
		add_action('widgets_init', create_function('', 'register_widget("tp_pviews_show_popular");'));

	}
	/**
	 * Enqueues the Scripts
	 */
	public function enqueue_scripts() {
		if ( is_singular(array( 'post','page','attachment' )) ) {
			global $post;
			wp_enqueue_script(
				'tp_pviews_js',
				plugin_dir_url( __FILE__ ) . 'js/tp_pviews.js',
				array('jquery'), $this->version, true 
				);

			wp_localize_script( 'tp_pviews_js', 'tp_postviews', array(
				'url' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'ajax-nonce' ),
				'pid'=>$post->ID
				));
		}
	}
	public function enqueue_styles() {

		wp_enqueue_style(
			'tppviews',
			plugin_dir_url( __FILE__ ) . 'css/tppviews.css'
			);

	}


	public function themepacific_postviews() {
		$nonce = $_REQUEST['nonce'];
		if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
			die ( 'ha ah!' ); 

		if ( isset( $_REQUEST['pid'])  ) {
			
			$pid = $_REQUEST['pid'];

			if(!is_numeric($pid))
				return;
			$options = get_option( 'tp_pviews_settings' );
			if( !isset($options['custom_meta']) ) $options['custom_meta'] = 'tp_postviews';

			$tp_views = get_post_meta( $pid, $options['custom_meta'], true );  
			update_post_meta( $pid, $options['custom_meta'], ++$tp_views );  
		}

		die();
	}


/**
 * 
 *   Post Views Count
*/

public function tp_show_pviews_count($pid){
	$options = get_option( 'tp_pviews_settings' );
	if( !isset($options['custom_meta']) ) $options['custom_meta'] = 'tp_postviews';

	$tp_views = get_post_meta( $pid, $options['custom_meta'], true );
	if($tp_views>0){
		$tp_views = $tp_views;
	}else{
		$tp_views=0;
	}
	$tp_views = $this->num_shares_convert($tp_views);
	$options = get_option( 'tp_pviews_settings' );
	if( !isset($options['add_class']) ) $options['add_class'] =  esc_attr('fa fa-eye');
	if( !isset($options['views_text']) ) $options['views_text'] = '';
	$class= esc_attr($options['add_class']);
	$text = $options['views_text'];
	$output = '<span class="tpacific-pviews-wrap tp_postviews '.$class.'"  > <span class="tp_fon_st">🔥'. $tp_views.' '.$text.'</span> </span> ';
	return $output;
}

public function num_shares_convert($n){
	if ($n < 1000) {
    // Anything less than a thousand
		return number_format($n); 
	}
	elseif ($n < 100000) {
    // Anything less than a thousand
		return number_format($n / 1000,1).' K'; 
	} else if ($n < 1000000000) {
    // Anything less than a billion
		return number_format($n / 1000000,1) . ' M';
	} else {
    // At least a billion
		return number_format($n / 1000000000,1) . ' B';
	}
}


/**
 * 
 *  [tp_postviews] Shortcode Likes Count
 */

public function tp_pviews_shortcode() {
	return $this->tp_show_pviews_count(get_the_ID() );
}


function the_content( $content )
{		
	    // Don't show on custom page templates
	if(is_page_template()) return $content;

	global $wp_current_filter;
	if ( in_array( 'get_the_excerpt', (array) $wp_current_filter ) ) {
		return $content;
	}

	$options = get_option( 'tp_pviews_settings' );
	if( !isset($options['show_in_post']) ) $options['show_in_post'] = '0';
	if( !isset($options['show_in_page']) ) $options['show_in_page'] = '0';
	if( !isset($options['show_in_loops']) ) $options['show_in_loops'] = '0';
	if( !isset($options['exclude_posts']) ) $options['exclude_posts'] = '';

	$ids = explode(',', $options['exclude_posts']);
	if(in_array(get_the_ID(), $ids)) return $content;

	if(is_singular('post') && $options['show_in_post']) $content .= $this->tp_show_pviews_count(get_the_ID());

	if(is_page() && !is_front_page() && $options['show_in_page']) $content .= $this->tp_show_pviews_count(get_the_ID());

	if((is_front_page() || is_home() || is_category() || is_tag() || is_author() || is_date() || is_search()) && $options['show_in_loops'] )  $content .= $this->tp_show_pviews_count(get_the_ID());


	return $content;
}


/**
 * Show the Most Popular Views 
 * 
 */
public function tp_pviews_show_popular_most($no_of_posts) {
	global $post;
	$args = array(
		'meta_key' => 'tp_postviews',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'posts_per_page' => $no_of_posts
		);
	$result = '';
	?>

	<ul id="tpacific-pviews"  class="tp_popular_sb-tabs-wrap">
		<?php
		$tp_viewed_posts = new WP_Query( $args );
 		if ( $tp_viewed_posts->have_posts() ) {
			while ( $tp_viewed_posts->have_posts() ) : $tp_viewed_posts->the_post();
			
			

 
			?>
			<li class="tp_popular_sb-tabs-wrap-li clearfix">

				<div class="tp_popular_sb-post-thumbnail">


					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php
						if(function_exists('themepacific_wpreviewCustomSmall')){
							echo themepacific_wpreviewCustomSmall('s');
						}
						
						the_post_thumbnail( 'crn_newsmagz_blk_small_thumb' );
						?>
					</a>

				</div>
 				<div class="tp_popular_sb-post-list-title">

					<h4>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h4>

					<div class="tp_popular_entry-meta">

						<span class="tp_popular_crn-post-item-date"> <?php echo get_the_date( ); ?></span>

					</div>
				</div>

			</li>
			<?php  endwhile; wp_reset_postdata(); 

		}  ?>

	</ul>
	<?php
}



}
function tp_pviews_count(){
	global $post;
	$tp_pviews = new tp_pviews_public('');
	return $tp_pviews->tp_show_pviews_count($post->ID);
}
function show_tp_pviews_count($count){
	global $post;
	$tp_pviews = new tp_pviews_public('');
	echo $tp_pviews->tp_pviews_show_popular_most($count); // $count posts to show
}