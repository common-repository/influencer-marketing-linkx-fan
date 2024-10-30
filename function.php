<?php
/*
 * Influencer Marketing - LinkX.fan 
 *
 * @package sahu_influencer_track
 * @copyright Copyright (c) 2020, SAHU MEDIA®
*/


// Füge Script in den Kopf ein.

function sahu_influencer_enqueue_script() {
    wp_enqueue_script( 'linkx-fan', 'https://linkx.fan/influ/settrack.js', false );
}

add_action( 'wp_enqueue_scripts', 'sahu_influencer_enqueue_script' );


// Track WooCommerce Danke-Seite leite Kaufevent ein.

add_action( 'woocommerce_thankyou', 'sahu_influencer_track_purchase' );
function sahu_influencer_track_purchase( $order_id ) {
	
	$order = new WC_Order( $order_id );
    $order_total = $order->get_total();
	$order_discount = $order->get_discount_total();
    $items = $order->get_items();
    $currency = get_woocommerce_currency();
	$coupons = $order->get_coupon_codes();
	
	 ?>
	 
	<script type="text/javascript">

	/* client variables - do not change this */
	var emid = window.localStorage['appinfl'];

	/* order variables */
	var ordertoken = <?php print $order_id; ?>;
	var trigger_id = '1';
	var currency = 'EUR';

	<?php
	if($order_discount>0){
		foreach($coupons as $order_used_coupon){					
			?> var vouchercode =  <?php print "'$order_used_coupon'"; ?> <?php
		}
	}else{
			?> var vouchercode =  ''; <?php
	}
	?>
	
	var ordertotal = <?php print $order_total; ?>;

	var basket = [];

	/* basket item object */
	/* foreach item in basket */
<?php
	foreach ( $items as $item ) {
		
		$product_name = $item->get_name();
		$product_id = $item->get_product_id();
		$product_variation_id = $item->get_variation_id();
		$quantity = $item->get_quantity();
		$total = $item->get_total();
?>		
		basket.push({
			'emid': emid,
			'trigger_id': trigger_id,
			'token': ordertoken,
			'article_number': <?php print $product_id; ?>,
			'productname': <?php print "'$product_name'"; ?>,
			'category': 'PRODUCT_CATEGORY',
			'amount': <?php print $quantity; ?>,
			'price': <?php print $total; ?>
		});
<?php
	}
		$app_id = get_option( 'sahu_influencer_appid' );
?>
	/* end foreach */

	var trackingUrl = 'https://linkx.fan/trk/?json='+encodeURIComponent(JSON.stringify(basket))+'&currency='+currency+'&vc='+vouchercode+'&acid=<?php print esc_attr($app_id) ?>&total='+ordertotal;
	var req = new XMLHttpRequest(); req.withCredentials = true; req.open("GET", trackingUrl); req.send();
	</script>
		 
<?php
}

?>