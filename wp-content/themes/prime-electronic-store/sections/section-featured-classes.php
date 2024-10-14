<?php 
/**
 * Template part for displaying Featured Classes Section
 *
 * @package Prime Electronic Store
 */

$prime_electronic_store_args = array(
  'post_type' => 'post',
  'post_status' => 'publish',
  'category_name' =>  get_theme_mod('prime_electronic_store_student_category'),
); 
$prime_electronic_store_classes = get_theme_mod( 'prime_electronic_store_classes_setting',false );
$prime_electronic_store_hot_products_cat = get_theme_mod('prime_electronic_store_hot_products_cat');
?>
<?php if ( $prime_electronic_store_classes ){?>
<div class="our-classes">
    <div class="container">
        <?php if(class_exists('woocommerce')){ ?>
        <div class="owl-carousel">
            <?php
            $args = array(
              'post_type' => 'product',
              'posts_per_page' => 50,
              'product_cat' => get_theme_mod('prime_electronic_store_hot_products_cat'),
              'order' => 'ASC'
            );
            $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post(); global $product;
              $prime_electronic_store_regular_price = $product->get_regular_price();
              $prime_electronic_store_sale_price = $product->get_sale_price();
              ?>
                  <div class="product-image">
                    <?php
                      if (has_post_thumbnail($loop->post->ID)) {
                          echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog');
                      } else {
                          echo '<img src="' . esc_url(wc_placeholder_img_src()) . '" alt="" />';
                      }
                    ?>
                    <div class="box-content text-center">
                      <h3 class="product-text">
                        <a href="<?php echo esc_url(get_permalink( $loop->post->ID )); ?>">
                          <?php the_title(); ?>
                        </a>
                      </h3>
                      <div class="price mb-2"><?php echo $product->get_price_html(); ?></div>
                      <div class="row">
                        <div class="col-lg-6 col-md-6 col-6">
                            <div class="pro-icons">
                              <?php if( $product->is_type( 'simple' ) ){ 
                                woocommerce_template_loop_add_to_cart( $loop->post, $product ); 
                              } ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6">
                          <div class="pro-icons">
                            <?php if ( class_exists( 'YITH_WCWL' ) ) {
                                echo do_shortcode('[woosq id="{". $post->ID ."}"]');
                            } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
            <?php endwhile; 
            wp_reset_postdata(); ?>
        </div>
        <?php }?>
    </div>
</div>
<?php } ?>