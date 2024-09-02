<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<h3><?php echo ( ! empty ( $content ) ) ? esc_html( $content ) : esc_html( MV_ImageText_Settings::$options['mv_imagetext_title'] ); ?></h3>
<div class="mv-imagetext fleximagetext <?php echo ( isset( MV_ImageText_Settings::$options['mv_imagetext_style'] ) ) ? esc_attr( MV_ImageText_Settings::$options['mv_imagetext_style'] ) : 'style-1'; ?>">  
    <?php 
    
    $args = array(
        'post_type' => 'mv-imagetext',
        'post_status'   => 'publish',
        'post__in'  => $id,
        'orderby' => $orderby
    );

    $my_query = new WP_Query( $args );

    if( $my_query->have_posts() ):
        $counter = 0; 
        while( $my_query->have_posts() ) : $my_query->the_post();
            $button_text = get_post_meta( get_the_ID(), 'mv_imagetext_link_text', true );
            $button_url = get_post_meta( get_the_ID(), 'mv_imagetext_link_url', true );

            // Determine order classes based on the counter
            $order_image = ($counter % 2 === 0) ? 'order-md-1' : 'order-md-2';
            $order_text = ($counter % 2 === 0) ? 'order-md-2' : 'order-md-1';
            ?>      
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 <?php echo $order_image; ?>">
                        <?php 
                        if( has_post_thumbnail() ){
                            the_post_thumbnail( 'full', array( 'class' => 'img-fluid w-100','style' => 'height: 300px; object-fit: cover;'  ) );
                        } else {
                            echo mv_imagetext_get_placeholder_image();
                        }
                        ?>  
                    </div>
                    <div class="col-md-5 ml-auto <?php echo $order_text; ?>">
                        <div class="site-section-title mb-3">
                            <h2 class="text-success"><?php the_title(); ?></h2>
                        </div>
                        <p><?php the_content(); ?></p>
                        <a class="btn btn-primary" href="<?php echo esc_attr( $button_url ); ?>"><?php echo esc_html( $button_text ); ?></a>
                    </div>
                </div>
            </div>
            <?php
            $counter++; 
        endwhile; 
        wp_reset_postdata();
    endif; 
    ?>
</div>