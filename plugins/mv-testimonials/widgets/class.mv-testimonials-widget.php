<?php

class MV_Testimonials_Widget extends WP_Widget {
    
    public function __construct() {

        $widget_options = array(
            'description' => __( 'Your most beloved testimonials', 'mv-testimonials' )
        );

        parent::__construct(
            'mv-testimonials',
            'MV Testimonials',
            $widget_options
        );

        add_action( 'widgets_init', function(){
            register_widget('MV_Testimonials_Widget');
        });
        
        if( is_active_widget( false, false, $this->id_base ) ){
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
        }
    }
    public function enqueue(){
        wp_enqueue_style(
            'mv-testimonials-style-css',
            MV_TESTIMONIALS_URL . 'assets/css/frontend.css',
            array(),
            MV_TESTIMONIALS_VERSION,
            'all'
        );
    }

    public function form( $instance ){

        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $image = isset( $instance['image'] ) ? (bool) $instance['image'] : false;
        $occupation = isset( $instance['occupation'] ) ? (bool) $instance['occupation'] : true;
        $company = isset( $instance['company'] ) ? (bool) $instance['company'] : true;
        ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title', 'mv-testimonials' ); ?>:</label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>">
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of testimonials to show', 'mv-testimonials' ); ?>:</label>
                <input type="number" class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" step="1" min="1" size="3" value="<?php echo esc_attr( $number ); ?>">
            </p>

            <p>
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" <?php checked( $image ); ?>>
                <label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php esc_html_e( 'Display user image?', 'mv-testimonials' ); ?></label>
            </p>

            <p>
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'occupation' ); ?>" name="<?php echo $this->get_field_name( 'occupation' ); ?>" <?php checked( $occupation ); ?>>
                <label for="<?php echo $this->get_field_id( 'occupation' ); ?>"><?php esc_html_e( 'Display occupation?', 'mv-testimonials' ); ?></label>
            </p>

            <p>
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'company' ); ?>" name="<?php echo $this->get_field_name( 'company' ); ?>" <?php checked( $company ); ?>>
                <label for="<?php echo $this->get_field_id( 'company' ); ?>"><?php esc_html_e( 'Display company?', 'mv-testimonials' ); ?></label>
            </p>

        <?php
    }

    public function widget( $args, $instance ) {

        $default_title = __( 'MV Testimonals' );
		$title         = ( ! empty( $instance['title'] ) ) ? $instance['title'] : $default_title;
		$number        = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        $image = isset( $instance['image'] ) ? $instance['image'] : false;
        $occupation = isset( $instance['occupation'] ) ? $instance['occupation'] : false;
        $company = isset( $instance['company'] ) ? $instance['company'] : false;
		// if ( ! $number ) {
		// 	$number = 5;
		// }

		// echo $args['before_widget']; 
        // echo $number;
		// if ( $title ) {
		// 	echo $args['before_title'] . $title . $args['after_title'];
		// }

        echo $args['before_widget'];
        echo $args['before_title'] . $title . $args['after_title'];

        require( MV_TESTIMONIALS_PATH . 'views/mv-testimonials_widget.php' );
        
        echo $args['after_widget'];

    }

    public function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['number']    = (int) $new_instance['number'];
		$instance['image'] = isset( $new_instance['image'] ) ? (bool) $new_instance['image'] : false;
		$instance['occupation'] = isset( $new_instance['occupation'] ) ? (bool) $new_instance['occupation'] : false;
		$instance['company'] = isset( $new_instance['company'] ) ? (bool) $new_instance['company'] : false;
		return $instance;
    }

}
