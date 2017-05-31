<?php
// This file adds an extra checkbox option to variation products in the admin
//Allowing the admin to select which variations to include in the shop loop

//Display Fields
add_action( 'woocommerce_product_after_variable_attributes', 'variable_fields', 2, 3 );
add_action( 'woocommerce_product_after_variable_attributes_js', 'variable_fields_js' );
add_action( 'woocommerce_process_product_meta_variable', 'save_variable_fields', 10, 1 );
//add_action( 'woocommerce_process_product_meta', 'save_variable_fields');

//Create new fields for variations
function variable_fields( $loop, $variation_data,$variation ) {
    
?>
	<tr>
		<td>
			<?php
                        
                        
			// Checkbox
			woocommerce_wp_checkbox( 
			array( 
				'id'            => '_display_on_shop_checkbox['.$loop.']', 
				'label'         => __('Display on Shop', 'woocommerce' ), 
				'description'   => __( 'Display this variation on shop archive pages.', 'woocommerce' ),
				//'value'         => $variation_data['_display_on_shop_checkbox'][0], 
                            'value'=>get_post_meta( $variation->ID, '_display_on_shop_checkbox', true),
                            'cbvalue'=>'yes',
                          
                            
				)
			);
                        
                       
			?>
		</td>
	</tr>
        
        <tr><td>
                <?php
            // Text Field
			woocommerce_wp_text_input( 
				array( 
					'id'          => '_text_field['.$loop.']', 
					'label'       => __( 'Titolo Variazione', 'woocommerce' ), 
					'placeholder' => '',
					'desc_tip'    => 'true',
					'description' => __( 'Enter the custom value here.', 'woocommerce' ),
					'value'       => get_post_meta( $variation->ID, '_text_field', true )
				)
			);
                        
                        //var_dump($variation);
                        ?>
            </td></tr>
        
        
<?php
}


//Create new fields for new variations
function variable_fields_js() {
?>
	<tr>
		<td>
			<?php
			// Checkbox
			woocommerce_wp_checkbox( 
			array( 
				'id'            => '_display_on_shop_checkbox[ + loop + ]', 
				'label'         => __('Display on Shop', 'woocommerce' ), 
				'description'   => __( 'Display this variation on shop archive pages.', 'woocommerce' ),
				'value'         => $variation_data['_display_on_shop_checkbox'][0], 
				)
			);
                        
                        
                 
                        
                        
                        
                        
			?>
		</td>
	</tr>
<?php
}

//Save new fields for variations
function save_variable_fields( $post_id ) {
	if (isset( $_POST['variable_sku'] ) ) :

		$variable_sku          = $_POST['variable_sku'];
		$variable_post_id      = $_POST['variable_post_id'];
		
		// Checkbox
		$_checkbox = $_POST['_display_on_shop_checkbox'];
		for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			//if ( isset( $_checkbox[$i] ) ) {		//Cannot uncheck checkbox if this is set
				update_post_meta( $variation_id, '_display_on_shop_checkbox', stripslashes( $_checkbox[$i] ) );
			//}
		endfor;
                
	endif;
        
        
        		// Text Field
		$_text_field = $_POST['_text_field'];
		for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_text_field[$i] ) ) {
				update_post_meta( $variation_id, '_text_field', stripslashes( $_text_field[$i] ) );
			}
		endfor;
}
?>