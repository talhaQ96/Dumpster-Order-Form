<?php
	$geo_data = get_user_geo_data();
	$browser = new Browser();
?>

<!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<style type="text/css">
			.email-content td{white-space: nowrap;}
			
			@media only screen and (max-width: 600px) {
				.email-content td { font-size: 16px !important; }
				.email-content td[nowrap] { font-size: 14px !important; }
				
				.email-head td,
				.email-content .columns td { display: block; width: 100%; padding-bottom: 30px; }
				
				.email-head td { padding-left: 0 !important; padding-right: 0 !important; text-align: center; }
				.email-head td.email-site-logo { padding-bottom: 0 !important; }
				.email-head td.email-site-logo svg { display: block; }
			 }
		</style>
	</head>

	<body style="margin: 0; padding: 0;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial, sans-serif; background: #FFF;">
			<tr>
				<td style="background: <?php echo THEME_BRAND_COLOR_MAIN_EMAIL ?>; padding-top: 40px; padding-bottom: 40px;">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="email-head">
						<tr>
							<td style="text-align:center">
								<a
									href="<?php bloginfo('url') ?>"
									target="_blank"
									style="display: inline-block;"
								>
									<?php 
										$logo_ext = pathinfo(EMAIL_CLIENT_LOGO, PATHINFO_EXTENSION);
										$email_logo = EMAIL_CLIENT_LOGO;
										
										if ($logo_ext == 'svg') {
											$email_logo = hmt_get_svg_as_colorized_png( EMAIL_CLIENT_LOGO, 'white' );
										}
									?>
									<img src="<?php echo $email_logo ?>" alt="" style="display: block; width: 200px;" />
								</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="center" style="background: <?php echo THEME_BRAND_COLOR_SECONDARY_EMAIL ?>;">
								<p style="font-size: 20px; letter-spacing: 4px; color: #FFF; text-transform: uppercase; margin-top: 30px; margin-bottom: 30px;">
			 						We Have Received Your Order
								</p>
							</td>
						</tr>
						
						<tr>
							<td align="center">
								<span style="display: block; width: 0; height: 0; border-left: 15px solid transparent; border-right: 15px solid transparent; border-top: 15px solid <?php echo THEME_BRAND_COLOR_SECONDARY_EMAIL ?>; margin-top: -1px;"></span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			
			<tr class="email-content">
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td style="padding-top: 60px; padding-bottom: 60px; padding-left: 10%; padding-right: 10%;">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 20px;">
									<tr>
										<td nowrap>
											<p style="font-size: 18px; font-weight: bold; letter-spacing: 2px; color: #093652; background: #FFF; text-transform: uppercase; padding-right: 15px; margin-top: 20px; margin-bottom: 20px;">Order information</p>
										</td>
										
										<td valign="middle" style="width: 100%;">
											<span style="display: block; background: #093652; height: 1px;"></span>
										</td>
									</tr>
								</table>

								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												First Name:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $first_name ?>
										</td>
									</tr>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												Last Name:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $last_name ?>
										</td>
									</tr>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												Email:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $email ?>
										</td>
									</tr>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												Phone Number:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $phone ?>
										</td>
									</tr>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												Company Name:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $company_name ?>
										</td>
									</tr>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												How Did You Hear About Us:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $hdyhau ?>
										</td>
									</tr>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												Type of Waste/Debris:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $waste_type ?>
										</td>
									</tr>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												Size of Dumpster:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $dumpster_size; ?>
										</td>
									</tr>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												Street Address:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $street_address ?>
										</td>
									</tr>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												City:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $city ?>
										</td>
									</tr>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												State:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $state ?>
										</td>
									</tr>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												Zip Code:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $zip_code ?>
										</td>
									</tr>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												Placement:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $placement ?>
										</td>
									</tr>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												Drop Off Date:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $drop_off_date ?>
										</td>
									</tr>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												Pick Up Date:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo $pick_up_date ?>
										</td>
									</tr>

									<?php if ( $discount_code ) : ?>
										<tr>
											<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
												<strong style="display: block; font-weight: bold; padding-right: 30px;">
													Discount Code:
												</strong>
											</td>

											<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
												<?php echo $discount_code ?>
											</td>
										</tr>
									<?php endif ?>

									<tr>
										<td valign="top" style="font-size: 20px; padding-bottom: 15px;">
											<strong style="display: block; font-weight: bold; padding-right: 30px;">
												Total:
											</strong>
										</td>

										<td valign="top" style="width: 100%; font-size: 20px; padding-bottom: 15px;">
											<?php echo '$' . $dumpster_amount ?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background: <?php echo THEME_BRAND_COLOR_SECONDARY_EMAIL ?>;">
						<tr>
							<td align="center" style="padding-top: 30px; padding-bottom: 30px;">
								<a
									href="<?php bloginfo('url') ?>"
									target="_blank"
									style="display: inline-block;"
								>
									<?php 
										$logo_ext = pathinfo(EMAIL_CLIENT_LOGO, PATHINFO_EXTENSION);
										$email_logo = EMAIL_CLIENT_LOGO;
										
										if ($logo_ext == 'svg') {
											$email_logo = hmt_get_svg_as_colorized_png( EMAIL_CLIENT_LOGO, 'white' );
										}
									?>
									<img src="<?php echo $email_logo ?>" alt="" style="display: block; width: 200px;" />
								</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>