<?php 
/**
 * Polite Slider Function
 * @since Polite 1.0.0
 *
 * @param null
 * @return void
 *
 */
global $polite_theme_options;
$slide_id = absint($polite_theme_options['polite-select-category']);
$read_more = esc_html($polite_theme_options['polite-read-more-text']);
$date = absint($polite_theme_options['polite-show-hide-date']);
$category = absint($polite_theme_options['polite-show-hide-category']);
$author = absint($polite_theme_options['polite-show-hide-author']);
$read_time = absint($polite_theme_options['polite-show-hide-read-time']);


        $slick_args = array(
            'slidesToShow'      => 1,
            'slidesToScroll'    => 1,
            'dots'              => false,
            'arrows'            => false,
        );
      $args = array(
			'posts_per_page' => 3,
			'paged' => 1,
			'cat' => $slide_id,
			'post_type' => 'post'
		);
		$slider_query = new WP_Query($args);
		if ($slider_query->have_posts()): ?>
    <div class="container">
    <div class="modern-slider" data-slick='<?php echo $slick_args_encoded; ?>'>
				<?php while ($slider_query->have_posts()) : $slider_query->the_post(); 
          if(has_post_thumbnail()){
          $image_id = get_post_thumbnail_id();
          $image_url = wp_get_attachment_image_src( $image_id,'',true );
        ?>
				<div class="slider-items">
          <div class="slide-wrap">
            <div class="col-md-7">
              <div class="slider-height img-cover" style="background-image: url(<?php echo esc_url($image_url[0]);?>)"></div>
            </div>
            <div class="col-md-5">
            	<div class="caption">
                    
                    <?php if($category == 1 ){ ?>
                        <div class="s-cat">
                            <?php polite_entry_meta(); ?>
                        </div>
                    <?php } ?>
            		    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="entry-meta">
                    <?php if($date == 1 ){
                        polite_posted_on();
                    } 
                    if($author == 1 ){
                        polite_posted_by();
                    }
                    if($read_time == 1 ){
                        polite_new_read_time();
                    }
                    ?>
                    </div>
                    <div class="post-excerpt entry-content">
                      <?php the_excerpt(); ?>
                        <?php if(!empty($read_more)){ ?>
                        <a class="more-btn" href="<?php the_permalink(); ?>"><?php echo esc_html($read_more); ?></a>
                        <?php } ?>
                    </div>
            	</div>
            </div>
            
          </div>
        </div>
        <?php } endwhile;
        wp_reset_postdata(); ?>
    </div>
  </div>
<?php endif; ?>