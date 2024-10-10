<?php

	/**
	 * Register Custom Post Type Orders
	 */
	function register_posttype_orders () {
		$labels = array(
			'name'               => 'Orders',
			'singular_name'      => 'Order',
			'add_new'            => 'Add New Order',
			'add_new_item'       => 'Add New Order',
			'edit_item'          => 'Edit Order',
			'new_item'           => 'New Order',
			'view_item'          => 'View Order',
			'view_items'         => 'View Orders',
			'search_items'       => 'Search Orders',
			'not_found'          => 'No orders found',
			'not_found_in_trash' => 'No orders found in Trash',
			'all_items'          => 'All Orders',
		);

		$args = array(
			'labels'                => $labels,
			'public'                => true,
			'exclude_from_search'   => true,
			'publicly_queryable'    => false,
			'show_in_menu'          => true,
			'show_in_nav_menus'     => false,
			'menu_icon'             => 'dashicons-cart',
			'rewrite'            => false,
			'query_var'          => false,
			'hierarchical'       => false,
			'supports'           => array('title'),
		);

		register_post_type ('orders', $args);
	}
	add_action('init', 'register_posttype_orders');


	/**
	 * Register Meta Box Contact Information & Delivery Information
	 */
	function register_custom_metaboxes() {
		add_meta_box(
			'order_contact_info_meta_box',
			'Contact Information',
			'custom_order_contact_information_callback',
			'orders',
			'normal',
		);

		add_meta_box(
			'order_delivery_info_meta_box',
			'Delivery Information',
			'custom_order_delivery_information_callback',
			'orders',
			'normal',
		);
	}
	add_action('add_meta_boxes', 'register_custom_metaboxes');


	/**
	 * Register Custom Fields for Metabox Contact Information
	 */
	function custom_order_contact_information_callback($post) {
?>
	<style>
		#info-fields-wrapper{
			display: grid;
			grid-template-columns: 1fr 1fr;
			column-gap: 50px;
			row-gap: 25px;
		}

		#info-fields-wrapper label{
			font-weight: bold;
			display: block;
			margin-bottom: 7px;
		}

		#info-fields-wrapper input{
			width: 100%;
			display: block;
		}

	</style>
	<div id="info-fields-wrapper">
		<div>
			<label for="first_name">First Name:</label>
			<input type="text" id="first_name" name="first_name" value="<?php echo get_post_meta($post->ID, 'first_name', true); ?>" />
		</div>

		<div>
			<label for="last_name">Last Name:</label>
			<input type="text" id="last_name" name="last_name" value="<?php echo get_post_meta($post->ID, 'last_name', true); ?>" />
		</div>
	
		<div>
			<label for="email">Email:</label>
			<input type="text" id="email" name="email" value="<?php echo get_post_meta($post->ID, 'email', true); ?>" />
		</div>

		<div>
			<label for="phone">Phone Number:</label>
			<input type="text" id="phone" name="phone" value="<?php echo get_post_meta($post->ID, 'phone', true); ?>" />
		</div>

		<div>
			<label for="company_name">Company Name:</label>
			<input type="text" id="company_name" name="company_name" value="<?php echo get_post_meta($post->ID, 'company_name', true); ?>" />
		</div>

		<div>
			<label for="hdyhau">How Did You Hear About Us:</label>
			<input type="text" id="hdyhau" name="hdyhau" value="<?php echo get_post_meta($post->ID, 'hdyhau', true); ?>" />
		</div>

		<div>
			<label for="waste_type">Type of Waste/Debris:</label>
			<input type="text" id="waste_type" name="waste_type" value="<?php echo get_post_meta($post->ID, 'waste_type', true); ?>" />
		</div>

		<div>
			<label for="dumpster_size">Size of Dumpster:</label>
			<input type="text" id="dumpster_size" name="dumpster_size" value="<?php echo get_post_meta($post->ID, 'dumpster_size', true); ?>" />
		</div>
	</div>

<?php
	}

	/**
	 * Save Data: Custom Fields for Metabox Contact Information
	 */
	function custom_save_order_contact_information($post_id) {
		if (!current_user_can('edit_post', $post_id)){
			return;
		}

		if (isset($_POST['first_name'])) {
			update_post_meta($post_id, 'first_name', sanitize_text_field($_POST['first_name']));
		}

		if (isset($_POST['last_name'])) {
			update_post_meta($post_id, 'last_name', sanitize_text_field($_POST['last_name']));
		}

		if (isset($_POST['email'])) {
			update_post_meta($post_id, 'email', sanitize_text_field($_POST['email']));
		}

		if (isset($_POST['phone'])) {
			update_post_meta($post_id, 'phone', sanitize_text_field($_POST['phone']));
		}

		if (isset($_POST['company_name'])) {
			update_post_meta($post_id, 'company_name', sanitize_text_field($_POST['company_name']));
		}

		if (isset($_POST['hdyhau'])) {
			update_post_meta($post_id, 'hdyhau', sanitize_text_field($_POST['hdyhau']));
		}

		if (isset($_POST['type_of_waste'])) {
			update_post_meta($post_id, 'type_of_waste', sanitize_text_field($_POST['type_of_waste']));
		}

		if (isset($_POST['size_of_dumpster'])) {
			update_post_meta($post_id, 'size_of_dumpster', sanitize_text_field($_POST['size_of_dumpster']));
		}
	}
	add_action('save_post', 'custom_save_order_contact_information');

	/**
	 * Register Custom Fields for Metabox Delivery Information
	 */
	function custom_order_delivery_information_callback($post) {
?>
		<style>
			#delivery-fields-wrapper{
				display: grid;
				grid-template-columns: 1fr 1fr;
				column-gap: 50px;
				row-gap: 25px;
			}
		
			#delivery-fields-wrapper label{
				font-weight: bold;
				display: block;
				margin-bottom: 7px;
			}
		
			#delivery-fields-wrapper input{
				width: 100%;
				display: block;
			}
		</style>

		<div id="delivery-fields-wrapper">
			<div>
				<label for="street_address">Street Address:</label>
				<input type="text" id="street_address" name="street_address" value="<?php echo get_post_meta($post->ID, 'street_address', true); ?>" />
			</div>

			<div>
				<label for="city">City:</label>
				<input type="text" id="city" name="city" value="<?php echo get_post_meta($post->ID, 'city', true); ?>" />
			</div>

			<div>
				<label for="state">State:</label>
				<input type="text" id="state" name="state" value="<?php echo get_post_meta($post->ID, 'state', true); ?>" />
			</div>

			<div>
				<label for="zipcode">Zip Code:</label>
				<input type="text" id="zipcode" name="zipcode" value="<?php echo get_post_meta($post->ID, 'zipcode', true); ?>" />
			</div>

			<div>
				<label for="placement">Placement:</label>
				<input type="text" id="placement" name="placement" value="<?php echo get_post_meta($post->ID, 'placement', true); ?>" />
			</div>

			<div>
				<label for="drop_off_date">Drop Off Date:</label>
				<input type="text" id="drop_off_date" name="drop_off_date" value="<?php echo get_post_meta($post->ID, 'drop_off_date', true); ?>" />
			</div>

			<div>
				<label for="pick_up_date">Pick Up Date:</label>
				<input type="text" id="pick_up_date" name="pick_up_date" value="<?php echo get_post_meta($post->ID, 'pick_up_date', true); ?>" />
			</div>

			<div>
				<label for="discount_code">Discount Code:</label>
				<input type="text" id="discount_code" name="discount_code" value="<?php echo get_post_meta($post->ID, 'discount_code', true); ?>" />
			</div>

			<div>
				<label for="dumpster_amount">Total:</label>
				<input type="text" id="dumpster_amount" name="dumpster_amount" value="<?php echo get_post_meta($post->ID, 'dumpster_amount', true); ?>" />
			</div>
		</div>
<?php
	}

	/**
	 * Save Data: Custom Fields for Metabox Contact Delivery
	 */
	function custom_save_order_delivery_information($post_id) {
		if (!current_user_can('edit_post', $post_id)){
			return;
		}
		
		if (isset($_POST['street_address'])) {
			update_post_meta($post_id, 'street_address', sanitize_text_field($_POST['street_address']));
		}
		
		if (isset($_POST['city'])) {
			update_post_meta($post_id, 'city', sanitize_text_field($_POST['city']));
		}
		
		if (isset($_POST['state'])) {
			update_post_meta($post_id, 'state', sanitize_text_field($_POST['state']));
		}
		
		if (isset($_POST['zipcode'])) {
			update_post_meta($post_id, 'zipcode', sanitize_text_field($_POST['zipcode']));
		}
		
		if (isset($_POST['placement'])) {
			update_post_meta($post_id, 'placement', sanitize_text_field($_POST['placement']));
		}
		
		if (isset($_POST['drop_off_date'])) {
			update_post_meta($post_id, 'drop_off_date', sanitize_text_field($_POST['drop_off_date']));
		}
		
		if (isset($_POST['pick_up_date'])) {
			update_post_meta($post_id, 'pick_up_date', sanitize_text_field($_POST['pick_up_date']));
		}
		
		if (isset($_POST['discount_code'])) {
			update_post_meta($post_id, 'discount_code', sanitize_text_field($_POST['discount_code']));
		}

		if (isset($_POST['dumpster_amount'])) {
			update_post_meta($post_id, 'dumpster_amount', sanitize_text_field($_POST['dumpster_amount']));
		}
	}
	add_action('save_post', 'custom_save_order_delivery_information');


	/**
	 * Fetch User Location Based on IP
	 */
	function get_user_geo_data($ip = '') {
		if ( !$ip ) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
	
		$ch = curl_init();
	
		curl_setopt_array($ch, array(
			CURLOPT_URL => 'http://www.geoplugin.net/json.gp?ip=' . $ip,
			CURLOPT_RETURNTRANSFER => 1
		));
	
		$geo_data = json_decode( curl_exec($ch), 1 );
	
		return $geo_data;
	}

	/**
	 *	Order Form Handler
	 */
	function order_form_handler() {

		if ($_SERVER["REQUEST_METHOD"] === "POST") {

			# Contact Information
			$first_name = sanitize_text_field($_POST['first_name']);
			$last_name = sanitize_text_field($_POST['last_name']);
			$email = sanitize_email($_POST['email']);
			$phone = sanitize_text_field($_POST['phone']);
			$company_name = sanitize_text_field($_POST['company_name']);
			$hdyhau = sanitize_text_field($_POST['hdyhau']);
			$waste_type = sanitize_text_field($_POST['waste_type']);
			$dumpster_size = $_POST['dumpster_size'];
	
			# Delivery Information
			$street_address = sanitize_text_field($_POST['street_address']);
			$city = sanitize_text_field($_POST['city']);
			$state = sanitize_text_field($_POST['state']);
			$zipcode = sanitize_text_field($_POST['zipcode']);
			$placement = sanitize_text_field($_POST['placement']);
			$drop_off_date = sanitize_text_field($_POST['drop_off_date']);
			$pick_up_date = sanitize_text_field($_POST['pick_up_date']);
			$discount_code = sanitize_text_field($_POST['discount_code']);
	
			# Other Information
			$terms_conditions = $_POST['terms_conditions'];
			$dumpster_amount = intval(get_field('dumpster_price', $dumpster_size));
			$discount_allowed = get_field('dumpster_allow_discount', $dumpster_size);
	
			# Return erros in JSON format
			if (empty ($first_name)) {
				wp_die(json_encode('empty_first_name'));
			}
	
			if (empty ($last_name)) {
				wp_die(json_encode('empty_last_name'));
			}
	
			if (empty ($email)) {
				wp_die(json_encode('empty_email'));
			}
	
			if (empty ($phone)) {
				wp_die(json_encode('empty_phone'));
			}
	
			if (empty ($company_name)) {
				wp_die(json_encode('empty_company_name'));
			}
	
			if (empty ($hdyhau)) {
				wp_die(json_encode('empty_hdyhau'));
			}
	
			if (empty ($waste_type)) {
				wp_die(json_encode('empty_waste_type'));
			}
	
			if (empty ($dumpster_size)) {
				wp_die(json_encode('empty_dumpster_size'));
			}
	
			if (empty ($street_address)) {
				wp_die(json_encode('empty_street_address'));
			}
	
			if (empty ($city)) {
				wp_die(json_encode('empty_city'));
			}
		
			if (empty ($state)) {
				wp_die(json_encode('empty_state'));
			}
	
			if (empty ($zipcode)) {
				wp_die(json_encode('empty_zipcode'));
			}
	
			if (empty ($placement)) {
				wp_die(json_encode('empty_placement'));
			}
	
			if (empty ($drop_off_date)) {
				wp_die(json_encode('empty_drop_off_date'));
			}
	
			if (empty ($pick_up_date)) {
				wp_die(json_encode('empty_pick_up_date'));
			}
	
			if ($terms_conditions === 'false') {
				wp_die(json_encode('terms_unchecked'));
			}

			# Apply discount if valid coupon
			if (!empty($discount_code)){
	
				$discounts = get_field('order_discount_codes', 'option')['discount_codes'];
	
				foreach ($discounts as $discount) {
					if ( strtoupper($discount['discount_code']) === strtoupper($discount_code) ){
						$discount_price = intval($discount['discount_price']);
						break;
					}
				}
	
				if(!empty($discount_price)){
					$discount_allowed ? $dumpster_amount -= $discount_price : wp_die(json_encode('discount_not_allowed'));
				}
	
				else{
					wp_die(json_encode('invalid_discount_code'));
				}
			}

			# Prevent submissions if the order was placed on a past date or on weekends.
			$user_selected_date = date("Y-m-d", strtotime($drop_off_date)); 
			$today = date("Y-m-d");
			$week_day = date('N', strtotime($user_selected_date));
			$order_weekend_preference = get_field('order_weekend_preference', 'option');
	
			if($user_selected_date < $today){
				wp_die(json_encode('past_date'));
			}

			if($order_weekend_preference === 'disallow'){

			}
	
			if($week_day == 6 || $week_day == 7){
				if($order_weekend_preference === 'disallow'){
					wp_die(json_encode('weekend'));
				}
			}
	
			# Prevent submissions after the order placement cutoff time for the current day (Central Time).
			date_default_timezone_set('America/Chicago');
			$CT_hour = intval(date('H'));
			$order_cutoff_time = intval(get_field('order_cutoff_time', 'option'));
	
			if ($CT_hour >= $order_cutoff_time) {
	
				$today = date('m/d/Y');
	
				if ($drop_off_date === $today) {
					wp_die(json_encode('past_cutoff_time'));
				}
			}

			# Initiate Fluidpay payment, proceed with order creation in the admin panel, and send an email if the payment is successful.
			$fluidpay_response = fluidpay_payment($fluidpay_token, $dumpster_amount);
			$payment = json_decode($fluidpay_response, true);
			$payment_status = $payment['status'];

			if($payment_status === 'success') {
				$order_id = wp_insert_post(array(
					'post_type'   => 'orders',
					'post_status' => 'publish'
				));

				$order_title = 'Order #' . $order_id;

				wp_update_post(array(
				    'ID'         => $order_id,
				    'post_title' => $order_title
				));

				if (!is_wp_error($order_id)) {
		
					# Update Contact Information
					if (!empty($first_name)) {
						update_post_meta($order_id, 'first_name', $first_name);
					}
		
					if (!empty($last_name)) {
						update_post_meta($order_id, 'last_name', $last_name);
					}
		
					if (!empty($email)) {
						update_post_meta($order_id, 'email', $email);
					}
		
					if (!empty($phone)) {
						update_post_meta($order_id, 'phone', $phone);
					}
		
					if (!empty($company_name)) {
						update_post_meta($order_id, 'company_name', $company_name);
					}
		
					if (!empty($hdyhau)) {
						update_post_meta($order_id, 'hdyhau', $hdyhau);
					}
		
					if (!empty($waste_type)) {
						update_post_meta($order_id, 'waste_type', $waste_type);
					}
		
					if (!empty($dumpster_size)) {
		
						$dumpster_id = $dumpster_size;
						$dumpster_name  = get_the_title($dumpster_size);
						$dumpster_price = get_field('dumpster_price', $dumpster_id);
						$dumpster_weight = get_field('dumpster_weight', $dumpster_id);
		
						$dumpster_size = $dumpster_name. ' - $' .$dumpster_price. ', '.$dumpster_weight;
		
						update_post_meta($order_id, 'dumpster_size', $dumpster_size);
					}
		
					# Delivery Information
					if (!empty($street_address)) {
						update_post_meta($order_id, 'street_address', $street_address);
					}
		
					if (!empty($city)) {
						update_post_meta($order_id, 'city', $city);
					}
		
					if (!empty($state)) {
						update_post_meta($order_id, 'state', $state);
					}
		
					if (!empty($zipcode)) {
						update_post_meta($order_id, 'zipcode', $zipcode);
					}
		
					if (!empty($placement)) {
						update_post_meta($order_id, 'placement', $placement);
					}
		
					if (!empty($drop_off_date)) {
						update_post_meta($order_id, 'drop_off_date', $drop_off_date);
					}
		
					if (!empty($pick_up_date)) {
						update_post_meta($order_id, 'pick_up_date', $pick_up_date);
					}
		
					if (!empty($discount_code)) {
						update_post_meta($order_id, 'discount_code', $discount_code);
					}

					if (!empty($dumpster_amount)) {
						update_post_meta($order_id, 'dumpster_amount', $dumpster_amount);
					}
					
					send_new_order_emails($order_id);
					die(json_encode('Success'));
				}
			}

			else {
				wp_die(json_encode('payment_error'));
			}

		}
	}
	add_action('wp_ajax_order_form_handler', 'order_form_handler');
	add_action('wp_ajax_nopriv_order_form_handler', 'order_form_handler'); // for non-logged in users

	/**
	 * Function Intitiating a FluidPay Payment
	 */
	function fluidpay_payment($fluidpay_token, $dumpster_amount){
		
		$api_key = "###";
		$api = "###";
		
		$transaction_data = array(
			"type" => "sale",
			"amount" => $dumpster_amount * 100, //convert cents to dollars
			"payment_method" => array(
				"token" => $fluidpay_token
			)
		);
		
		$headers = array(
			"Authorization: $api_key",
			"Content-Type: application/json"
		);
		
		$curl = curl_init($api);
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($transaction_data));
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_VERBOSE, true);
		
		$response = curl_exec($curl);
		
		if (curl_error($curl)) {
			return 'Curl error: ' . curl_error($curl);
		}
		
		curl_close($curl);
		
		return $response;		
	}


	/**
	 * Function Sending Email to Admin and User
	 */
	function send_new_order_emails($order_id) {

		$first_name = get_post_meta($order_id, 'first_name', true);
		$last_name = get_post_meta($order_id, 'last_name', true);
		$email = get_post_meta($order_id, 'email', true);
		$phone = get_post_meta($order_id, 'phone', true);
		$company_name = get_post_meta($order_id, 'company_name', true);
		$hdyhau = get_post_meta($order_id, 'hdyhau', true);
		$waste_type = get_post_meta( $order_id, 'waste_type', true );
		$dumpster_size = get_post_meta( $order_id, 'dumpster_size', true );
		$street_address = get_post_meta( $order_id, 'street_address', true);
		$city = get_post_meta( $order_id, 'city', true);
		$state = get_post_meta( $order_id, 'state', true);
		$zip_code = get_post_meta( $order_id, 'zipcode', true);
		$placement = get_post_meta( $order_id, 'placement', true );
		$drop_off_date = get_post_meta( $order_id, 'drop_off_date', true);
		$pick_up_date = get_post_meta( $order_id, 'pick_up_date', true);
		$discount_code = get_post_meta( $order_id, 'discount_code', true);
		$dumpster_amount = get_post_meta( $order_id, 'dumpster_amount', true);

		$admin_email = get_field('order_admin_email', 'option');
		$admin_email_subject = get_field('order_admin_email_subject', 'option');
		$client_email_subject = get_field('order_client_email_subject', 'option');

		ob_start();
		include(locate_template('lib/admin-email-template.php'));
		$admin_message = str_replace( '{{TEMPLATE_PATH}}', get_bloginfo('stylesheet_directory') . '/lib/online-order', ob_get_clean() );

		ob_start();
		include(locate_template('lib/client-email-template.php'));
		$client_message = str_replace( '{{TEMPLATE_PATH}}', get_bloginfo('stylesheet_directory') . '/lib/online-order', ob_get_clean() );
		
		wp_mail (
			$admin_email,
			$admin_email_subject,
			$admin_message,
			array(
				'Content-Type: text/html; charset=UTF-8',
				'From: Cubicwaste Solutions <noreply@cubicwaste.com>'
			)
		);

		wp_mail (
			$email,
			$client_email_subject,
			$client_message,
			array(
				'Content-Type: text/html; charset=UTF-8',
				'From: Cubicwaste Solutions <noreply@cubicwaste.com>'
			)
		);
	}


	/**
	 *	Function Calculates and Return Order Amount
	 */
	function calculate_order_amount() {

		$response = array();

		$dumpster_id = $_POST['order_id'];
		$discount_code = sanitize_text_field($_POST['discount_code']);
		$dumpster_amount =intval(get_field('dumpster_price', $dumpster_id ));
		$discount_allowed = get_field('dumpster_allow_discount', $dumpster_id);
	
		# Apply discount if valid coupon
		if (!empty($discount_code)){
	
			$discounts = get_field('order_discount_codes', 'option')['discount_codes'];
	
			foreach ($discounts as $discount) {
				if ( strtoupper($discount['discount_code']) === strtoupper($discount_code) ){
					$discount_price = intval($discount['discount_price']);
					break;
				}
			}
	
			if(!empty($discount_price)){
				$discount_allowed ? $dumpster_amount -= $discount_price : $response['error'] = 'discount_not_allowed';
			}
		}
	
		$response['dumpster_amount'] = $dumpster_amount;
		wp_die(json_encode($response));
	}
	add_action('wp_ajax_calculate_order_amount', 'calculate_order_amount');
	add_action('wp_ajax_nopriv_calculate_order_amount', 'calculate_order_amount'); // for non-logged in users