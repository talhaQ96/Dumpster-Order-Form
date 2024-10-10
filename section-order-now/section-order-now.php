<?php
/**
 * Section Order Now Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$id = $block['id'];
if ( !empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

$section_top_padding_type = get_field( 'section_top_padding_type' );
$section_bottom_padding_type = get_field( 'section_bottom_padding_type' );

if( $section_top_padding_type && !empty($section_top_padding_type) ) {
	$section_top_padding = 'section-top-padding--' . $section_top_padding_type;
} else {
	$section_top_padding = 'section-top-padding--default';
}
if ( $section_bottom_padding_type && !empty($section_bottom_padding_type) ) {
	$section_bottom_padding = 'section-bottom-padding--' . $section_bottom_padding_type;
} else {
	$section_bottom_padding = 'section-bottom-padding--default';
}

$class_name = 'section section-contact-us js-section-contact-us';
if ( !empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( !empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

$class_name .= ' section-contact-us--style-' . $block_style;
$class_name .= ' ' . $section_top_padding . ' ' . $section_bottom_padding;

$section_backgrounds = get_field('order_backgrounds');

$section_header_bg = $section_backgrounds['header_background'];
$section_body_bg = $section_backgrounds['body_background'];
$section_body_container_bg = $section_backgrounds['form_background'];

$section_title = get_field('order_section_title');
?>

<section key="<?= time() ?>" id="<?= esc_attr( $id ); ?>" class="section-order-now <?= esc_attr( $class_name ); ?>">
	<div class="section-order-now__header">

		<?php if ($section_header_bg): ?>
			<picture>
				<source srcset="<?= esc_url( wp_get_attachment_image_url( $section_header_bg, 'section-background-4k' ) ) ?>" media="(min-width: 1920px)">
				<source srcset="<?= esc_url( wp_get_attachment_image_url( $section_header_bg, 'section-background-desktop' ) ) ?>" media="(min-width: 1280px)">
				<source srcset="<?= esc_url( wp_get_attachment_image_url( $section_header_bg, 'section-background-tablet' ) ) ?>" media="(max-width: 1279px)">
				<source srcset="<?= esc_url( wp_get_attachment_image_url( $section_header_bg, 'section-background-mobile' ) ) ?>" media="(max-width: 767px)">
				<img src="<?= esc_url( wp_get_attachment_image_url( $section_header_bg, 'section-background-desktop' ) ) ?>" alt="<?= esc_attr( 	hmt_get_attachment_image_alt( $section_header_bg ) ) ?>">
			</picture>
		<?php endif; ?>

		<div class="container">
			<?php if($section_title): ?>
				<h2 class="section-title--style1">
					<?= esc_html($section_title);?>
				</h2>
			<?php endif; ?>

			<div class="checkbox">
				<span id="residential">Residential</span>
				<span id="commercial">Commercial</span>
			</div>

			<div class="section-description">
				<p>Because commercial dumpster needs are often specific,</p>
				<p>we encourage you to give our team a call and we will help you find a solution!</p>
			</div>
		</div>

	</div>
	<div class="section-order-now__body">

		<?php if ($section_body_bg): ?>
			<div class="background-wrapper">
				<picture>
					<source srcset="<?= esc_url( wp_get_attachment_image_url( $section_body_bg, 'section-background-4k' ) ) ?>" media="(min-width: 1920px)">
					<source srcset="<?= esc_url( wp_get_attachment_image_url( $section_body_bg, 'section-background-desktop' ) ) ?>" media="(min-width: 1280px)">
					<source srcset="<?= esc_url( wp_get_attachment_image_url( $section_body_bg, 'section-background-tablet' ) ) ?>" media="(max-width: 1279px)">
					<source srcset="<?= esc_url( wp_get_attachment_image_url( $section_body_bg, 'section-background-mobile' ) ) ?>" media="(max-width: 767px)">
					<img src="<?= esc_url( wp_get_attachment_image_url( $section_body_bg, 'section-background-desktop' ) ) ?>" alt="<?= esc_attr( hmt_get_attachment_image_alt( $section_body_bg ) ) ?>">
				</picture>
			</div>
		<?php endif; ?>

		<div class="container">
			<div class="section-body">

				<?php if ( $section_body_container_bg): ?>
					<picture>
						<source srcset="<?= esc_url( wp_get_attachment_image_url( $section_body_container_bg, 'section-background-4k' ) ) ?>" media="(min-width: 1920px)">
						<source srcset="<?= esc_url( wp_get_attachment_image_url( $section_body_container_bg, 'section-background-desktop' ) ) ?>" media="(min-width: 1280px)">
						<source srcset="<?= esc_url( wp_get_attachment_image_url( $section_body_container_bg, 'section-background-tablet' ) ) ?>" media="(max-width: 1279px)">
						<source srcset="<?= esc_url( wp_get_attachment_image_url( $section_body_container_bg, 'section-background-mobile' ) ) ?>" media="(max-width: 767px)">
						<img src="<?= esc_url( wp_get_attachment_image_url( $section_body_container_bg, 'section-background-desktop' ) ) ?>" alt="<?= esc_attr( hmt_get_attachment_image_alt( $section_body_container_bg ) ) ?>">
					</picture>
				<?php endif; ?>

				<form id="order-form" method="post">
					<fieldset>
						<h2 class="section-title--style1">Contact Information</h2>
						<div class="contact-info-fields">
							<div><input type="text"  id="order_first_name" name="first_name" placeholder="First Name*"></div>
							<div><input type="text"  id="order_last_name" name="last_name" placeholder="Last Name*"></div>
							<div><input type="email" id="order_email" name="email" placeholder="Email*"></div>
							<div><input type="tel"   id="order_phone" name="phone" placeholder="Phone Number*"></div>
							<div><input type="text"  id="order_company_name" name="company_name" placeholder="Company Name*"></div>
							<div>
								<select id="order_hdyhau" name="hdyhau">
									<option value="" disabled selected>How Did You Hear About Us*</option>
									<option value="Online Search">Online Search</option>
									<option value="Google Ad">Google Ad</option>
									<option value="Social Media">Social Media</option>
									<option value="Email">Email</option>
									<option value="Word of Mouth">Word of Mouth</option>
									<option value="Business Referral">Business Referral</option>
									<option value="Family or Friend Referral">Family or Friend Referral</option>
								</select>
							</div>
							<div>
								<select id="order_waste_type" name="waste_type">
									<option value="" disabled selected>Type of Waste/Debris*</option>
									<option value="Home Remodel Debris">Home Remodel Debris</option>
									<option value="Commercial Renovation Debris">Commercial Renovation Debris</option>
									<option value="Construction Debris">Construction Debris</option>
									<option value="Landscaping/ Yard Debris">Landscaping/ Yard Debris</option>
									<option value="Other/ Miscellaneous">Other/ Miscellaneous</option>
								</select>
							</div>

							<?php
								$query = new WP_Query(array(
									'post_type' => 'equipment_item',
									'posts_per_page' => -1
								));

								if ($query->have_posts()):
							?>
								<div>
									<select id="order_dumpster_size" name="dumpster_size">
										<option value="" disabled selected>Size of Dumpster*</option>
						  				
						  				<?php 
						  					while ($query->have_posts()): $query->the_post();
												$dumspter_id = get_the_ID();
												$dumspter_name  = get_the_title();
												$dumspter_price = get_field('dumpster_price', $dumspter_id);
												$dumspter_weight = get_field('dumpster_weight', $dumspter_id);
										?>
											<option value = "<?php echo $dumspter_id;?>">
												<?php echo $dumspter_name. ' - $' .$dumspter_price. ', '.$dumspter_weight ?>
											</option>
										<?php endwhile; ?>
									</select>
								</div>
							<?php endif; ?>
							
						</div>
					</fieldset>
				
					<fieldset>
						<div class="delivery-information-header">
							<h2 class="section-title--style1">Delivery Information</h2>
							<p>You can select the next day up until 2pm of the day you are ordering.<br/>All orders are priced for 14 days of service.</p>
						</div>
						<div class="delivery-info-fields">
							<div><input type="text" id="order_street_address" name="street_address" placeholder="Street Address*"></div>
							<div><input type="text" id="order_city" name="city" placeholder="City*"></div>
							<div><input type="text" id="order_state" name="state" placeholder="State*"></div>
							<div><input type="text" id="order_zipcode" name="zipcode" placeholder="Zip Code*" /></div>
							<div><input type="text" id="order_placement" name="placement" placeholder="Placement*"></div>
							<div><input type="text" id="order_drop_off_date" name="drop_off_date" placeholder="Drop Off Date*"></div>
							<div><input type="text" id="order_pick_up_date" name="pick_up_date" placeholder="Pick Up Date*"></div>
							<div><input type="text" id="order_discount_code" name="discount_code" placeholder="Discount Code"></div>

							<?php
								$terms_link = get_field('order_terms_conditions_page');

								if($terms_link):
    								$url = $terms_link['url'];
    								$title = $terms_link['title'];
    								$target = $terms_link['target'] ? $terms_link['target'] : '_self';
							?>
								<div class="delivery-policy">
									<div>
										<label>
											<input type="checkbox" id="order_delivery_policy" name="terms_conditions">
											<span for="terms_conditions">
												I HAVE READ AND AGREE
												<a href="<?= esc_html($url); ?>" target="<?= esc_html($target); ?>">
													<?= esc_html($title); ?>
												</a>
											</span>	
										</label>	
									</div>
								</div>
							<?php endif; ?>
						</div>
						<div class="total-amount section-title--style3"></div>
					</fieldset>

					<fieldset id="button-container">
						<button type="submit" class="button">Place Order</button>
					</fieldset>
				</form>
			</div>
		</div>	
	</div>
</section>

<?php
	include( get_stylesheet_directory() . '/lib/popup-success.php' );
?>