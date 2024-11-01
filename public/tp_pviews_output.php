<?php 
 
/**
* ThemePacific Views : tp_pviews_show_popular_today
*/

 class tp_pviews_show_popular extends WP_Widget {
 

 	function __construct() {
  		parent::__construct( //here WP_Widget
			'tp_pviews_show_popular', // Base ID
			__('tp PostViews: Popular Posts ', 'tp_postviews'), // Name
			array( 'description' => __( 'Show Most Popular Posts ', 'tp_postviews' ), ) // Args
		);
 	}
	
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$count = $instance['count'];
 		echo $before_widget;
		if ( $title )
			echo $before_title;
				echo $title ; 
	        echo $after_title;  
 		show_tp_pviews_count($count); 
		   
		echo $after_widget;
	}
 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] =  $new_instance['count'];
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' =>__( ' Most Popular Posts ' , 'tp_postviews'),'count' =>3 );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __('Title :','tp_postviews'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php echo __('No. of Posts :','tp_postviews'); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" class="widefat" type="text" />
		</p>


	<?php
	}


}