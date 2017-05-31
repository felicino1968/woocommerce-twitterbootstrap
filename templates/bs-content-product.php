<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product, $woocommerce_loop;
?>
<?php if (!function_exists('output_post_normally')): 
	function output_post_normally($classes) {  ?>
<div class="<?php echo $classes?>">

	
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<div class="product"><a href="<?php the_permalink(); ?>">

		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			 
			do_action( 'bs_before_shop_loop_item_title' ); 
		?>

		<h3><?php the_title(); ?></h3>

		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>

	</a>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</div>
</div>
<?php }
endif;
?>

<?php // INDIVIDUAL VARIABLE POST OUTPUT FUNCTION ---------------------------------------------------------------------------------------------
//Second : I have created this new individual variation output function so I can call it multiple times for our individual variable products below
if (!function_exists('output_individual_variable_post')): 
    
	function output_individual_variable_post( $variation_Object,$classes ) {
		$variable_product= new WC_Product_Variation( $variation_Object['variation_id'] ); 
		$variationURL = add_query_arg( array_filter( $variable_product->variation_data ), get_permalink( $variable_product->id ) );		
		 ?>
		<div class="<?php echo $classes?>">
			<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
                    <div class="product"><a href="<?php echo $variationURL; ?>">
                     
                            
				<?php
					/**
					 * woocommerce_before_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woocommerce_template_loop_product_thumbnail - 10
					 */
					do_action( 'bs_before_shop_loop_item_title' );
					?>
                            <?php
                                             
                            if(get_post_meta( $variation_Object['variation_id'], '_text_field', true ) && get_post_meta( $variation_Object['variation_id'], '_text_field', true )!==''){
                            $variation_title=get_post_meta( $variation_Object['variation_id'], '_text_field', true );
                            ?>
                            <h3><?php echo $variation_title?></h3><!--- USING SKU AS TITLES --->
                            <?php
                            }else{?>
                                <h3><?php the_title(); ?></h3>
                          <?php  } 
                            ?>  
                                  
                
              <?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
                        </a>

                              
                      
                                
                                
                            <?php
                            /*
                            //STOCK
                            
                            //$stock = $product->get_total_stock();
                            $stock = $variable_product->get_stock_quantity( );
			 	if ( ! $variable_product->is_in_stock() ) {
			 		echo '<p class="stock out-of-stock voa"><small>' . __( 'Out of stock', 'woocommerce' ) . '</small></p>';
			 	} elseif ( $stock >= 1 ) {
                                    if($stock>1){
			 		echo '<p class="stock in-stock voa"><small>'.sprintf( __( '%s in stock', 'woocommerce' ), $stock ).'</small></p>';
                                    }else{
                                        
                                       echo '<p class="stock in-stock voa"><small>'.$stock.' '. __( 'In stock', 'woocommerce' ) .'</small></p>'; 
                                    }
			 	}
                            */
                            ?>
                            
                            
                
				
				<?php
					/**
					 * woocommerce_after_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_template_loop_rating - 5
					 * @hooked woocommerce_template_loop_price - 10
					 */
                                //remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10);
                                //add_action('woocommerce_after_shop_loop_item_title','variable_loop_price', 10);
					//do_action( 'woocommerce_after_shop_loop_item_title' );
                                        /*  if ( $price_html = $variable_product->get_price_html() ) : ?>
                                                <span class="price"><?php echo $price_html; ?></span>
                                    <?php endif;
					//add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10);
					//OUTPUT the variation price
                                
					//echo $variation_Object['display_price'];
					*/
				?>
			</a>
			<?php do_action( 'woocommerce_after_shop_loop_item' );/*
           <!-- <a class="button add_to_cart_button product_type_variable" data-product_sku="<?php echo $variation_Object['sku']; ?>" data-product_id="<?php echo $variation_Object['variation_id']; ?>" rel="nofollow" href="<?php echo $variationURL; ?>">Select option</a>
 !-->           */ ?>
                </div>
                </div>
<?php } 
endif; ?>




<?php 
//Third : so now we do our check for variable products and call the function above multiple times for each variation
if( $product->is_type( 'variable' ) ):
	
	$product_ID = get_the_ID();
	if ( get_post_status ( $product_ID ) == 'publish' ) :

		$available_variations = $product->get_available_variations();
		if( ! empty( $available_variations ) ) :
			
			$individual_variation_display = false;
			foreach ($available_variations as $item) :	
				$display_on_shop = get_post_meta( $item['variation_id'], '_text_field', true);
				if($display_on_shop != "") :	
					$individual_variation_display = true;	
				endif;
			endforeach;
			
			if($individual_variation_display == true) :	
					
					foreach ($available_variations as $item) :	 
						$display_on_shop = get_post_meta( $item['variation_id'], '_text_field', true);
						if($display_on_shop != "") :		
							if( $item['variation_is_visible'] && $item['is_purchasable'] ) :
								output_individual_variable_post( $item,$classes );
							endif;	
						endif;
					endforeach;
			
			else :
					output_post_normally($classes);
			endif;
			
		endif;
	endif;
else :
	output_post_normally($classes);
endif;



