<?php
/**
 * Polite Promo Unique
 * @since Polite 1.0.0
 *
 * @param null
 * @return void
 *
 */
global $polite_theme_options;
$promo_cat = absint($polite_theme_options['polite-promo-select-category']);
$date = absint($polite_theme_options['polite-show-hide-date']);
$category = absint($polite_theme_options['polite-show-hide-category']);
$author = absint($polite_theme_options['polite-show-hide-author']);
$read_time = absint($polite_theme_options['polite-show-hide-read-time']);


if( $promo_cat > 0 && is_home() )
    { ?>
        <section class="polite-promo-section">
            <?php if ( is_front_page() && is_home() )
            {  ?>
                <div class="container">
                    <div class="promo-section promo-three">
                        <?php
                        $args = array(
                            'cat' => $promo_cat ,
                            'posts_per_page' => 3,
                            'order'=> 'DESC'
                        );
                        
                        $query = new WP_Query($args);
                        
                        if($query->have_posts()):                        
                            while($query->have_posts()):
                                $query->the_post();
                                ?>                            
                                <div class="item">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php
                                        
                                        if(has_post_thumbnail())
                                        {
                                            
                                            $image_id  = get_post_thumbnail_id();
                                            $image_url = wp_get_attachment_image_src($image_id,'polite-promo-post',true);
                                            ?>
                                            
                                            <figure>
                                                <img src="<?php echo esc_url($image_url[0]);?>">
                                            </figure>
                                        <?php   } ?>
                                    </a>
                                    <div class="promo-content">    
                                        <div class="post-category">
                                            <?php if($category == 1 ){ ?>
                                                <div class="s-cat">
                                                    <?php polite_entry_meta(); ?>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <h3 class="post-title entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <div class="post-date">
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
                                            </div><!-- .entry-meta -->
                                        </div>
                                    </div>
                                </div>
                                
                            <?php endwhile; endif; wp_reset_postdata(); ?>
                        </div>
                    </div>
                <?php } ?>
            </section>
        <?php   }