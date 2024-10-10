/**
 * Error Messages for Order Form
 */
var errorTexts = {
	'first_name': 'This is a required field.',
	'last_name': 'This is a required field.',
	'email': 'This is a required field.',
	'phone': 'This is a required field.',
	'company_name': 'This is a required field.',
	'hdyhau': 'This is a required field.',
	'waste_type': 'This is a required field.',
	'dumpster_size': 'This is a required field.',
	'street_address': 'This is a required field.',
	'city': 'This is a required field.',
	'state': 'This is a required field.',
	'zipcode': 'This is a required field.',
	'drop_off_date': 'This is a required field.',
	'drop_off_date_past_cutoff_time': 'You can\'t select the current day after.' + convertTo12HourFormat(handler.order_cutoff_time), // eslint-disable-line
	'drop_off_date_past': 'You can\'t select a date in the past for placing an order.',
	'drop_off_date_weekend': 'Orders cannot be placed for weekends.',
	'pick_up_date': 'This is a required field.',
	'placement': 'This is a required field.',
	'terms': 'This is a required field.',
	'discount_code': 'The discount code entered is not valid.',
	'discount_not_allowed': handler.discount_error
};


/**
 * Order Now Form Submit Event Handler
 */
var orderForm = $('#order-form');
if ( orderForm ) {
	$('#order-form').on('submit', function(event) {
		event.preventDefault();

  		let submitButton = event.submitter;
  		submitButton.disabled = true;
  		submitButton.textContent = 'Processing...';

  		submitOrderForm();

		setTimeout( function() {
  			submitButton.disabled = false;
  			submitButton.textContent = 'Place Order';
		}, 2000 );
	} );

	$( document ).ready( function() {
		/**
		 * Residential & Commericial Checkboxes Toggle
		 */
		$( '#residential' ).on( 'click', function() {
			$( this ).addClass( 'active' );
			$( '#commercial' ).removeClass( 'active' );
			$( '.section-order-now__header .section-description' ).slideUp();
			$( '.section-order-now__body' ).slideDown();;
		} );

		$( '#commercial' ).on( 'click', function() {
			$( '#residential' ).removeClass( 'active' );
			$( this ).addClass( 'active' );
			$( '.section-order-now__header .section-description' ).slideDown();
			$( '.section-order-now__body' ).slideUp();
		} );

		/**
		 * Input Sanitization for American Zipcode
		 */
		$( '#order_zipcode, #hero_zipcode' ).on( 'input', function() {
			let inputValue = $( this ).val();
			let sanitizedInput = inputValue.replace( /\D/g, '' );
			sanitizedInput = sanitizedInput.slice( 0, 5 );
			$( this ).val( sanitizedInput );
		} );

		/**
		 * Fetch and Display Dumpster Price when Size of Dumspter Selected
		 */
		$( '#order_dumpster_size' ).on( 'input', function() {
			let dropOffDate = $( '#order_drop_off_date' ).datepicker( 'getDate' );
		   	let pickUpDate = $( '#order_pick_up_date' ).datepicker( 'getDate' );

		   	//Check if drop off and pickup dates are also selected
		   	if ( dropOffDate !== null && pickUpDate !== null ) {
		   		let dumpsterID = $( this ).val();
		   		getOrderTotal( dumpsterID );
		   	}
		} );

		/**
		 * Update Total Price Field when Discount Added
		 */
		$( '#order_discount_code' ).on( 'input', function() {
			let dropOffDate = $( '#order_drop_off_date' ).datepicker( 'getDate' );
		   	let pickUpDate = $( '#order_pick_up_date' ).datepicker( 'getDate' );
			let selectedDumpsterID = $( '#order_dumpster_size' ).val();

			if ( dropOffDate !== null && pickUpDate !== null && selectedDumpsterID && selectedDumpsterID.trim() !== '' ) {
				getOrderTotal( selectedDumpsterID );
			}
		} );

		/**
		 * Hide Total Amount if Dates are not Selected
		 */
		$( '#order_drop_off_date, #order_pick_up_date' ).on( 'input', function() {
			let date = $( this ).val();

			if ( $.isEmptyObject( $.trim( date ) ) ) {
				$( '.total-amount' ).empty().css( 'margin-top', '0' );
			}
		} );

		/**
		 * Hide Date Picker When Website Scrolled
		 */
		$( '.wp-site-blocks' ).scroll( function() {
			$( '#ui-datepicker-div' ).hide();
		} );

		/**
		 * Date Picker Fields
		 */
		setTimeout( function() {
			$( '.ui-datepicker' ).addClass( 'notranslate' );
		}, 100 );
		
		$( '#order_drop_off_date' ).datepicker( {
			minDate: 0,
			dateFormat: 'mm/dd/yy',
			beforeShowDay: function( date ) {
				let day = date.getDay();
				let CTHour = getCTHour();

				if ( CTHour >= handler.order_cutoff_time ) { // eslint-disable-line
					return [( day !== 0 && day !== 6 && date.getTime() !== new Date().setHours( 0,0,0,0 ) )];
				}

				return [( day !== 0 && day !== 6 )];
			},
			onSelect: function() {
				let pickUpDate = $( '#order_pick_up_date' ).datepicker( 'getDate' );
				let dropOffDate = $( this ).datepicker( 'getDate' );

				if ( dropOffDate !== null && pickUpDate !== null ) {

					let timeDiff = Math.abs( pickUpDate.getTime() - dropOffDate.getTime() );
					let diffDays = Math.ceil( timeDiff / ( 1000 * 3600 * 24 ) );

					if ( pickUpDate < dropOffDate ) {
						if ( $( '#dropoff_greater_pickup_error' ).length === 0 ) {
							$( '#order_drop_off_date' ).after( '<span id="dropoff_greater_pickup_error" class="order_field_error">The drop off date must be before the pick up date.</span>' );
						}
					}

					else {
					   $( '#dropoff_greater_pickup_error' ).remove();
					}

					if ( diffDays > 14 ) {
						if ( $( '#order_greater_14days' ).length === 0 ) {
	 						$( '#order_pick_up_date' ).after( '<span id="order_greater_14days" class="order_field_error">The maximum order period is 14 days</span>' );
						}
					}

					else {
						$( '#order_greater_14days' ).remove();
					}

					let selectedDumpsterID = $( '#order_dumpster_size' ).val();
					if ( selectedDumpsterID && selectedDumpsterID.trim() !== '' ) {
						getOrderTotal( selectedDumpsterID );
					}
				}
			}
		} );

		$( '#order_pick_up_date' ).datepicker( {
			minDate: 1,
			dateFormat: 'mm/dd/yy',
			beforeShowDay: function( date ) {
				let day = date.getDay();
				let CTHour = getCTHour();

				if ( CTHour >= handler.order_cutoff_time ) { // eslint-disable-line
					let tomorrow = getTomorrowDate();
					let string = jQuery.datepicker.formatDate( 'mm-dd-yy', date );

					return [day !== 0 && day !== 6 && tomorrow.indexOf( string ) === -1];
				}

				return [( day !== 0 && day !== 6 )];
			},
			onSelect: function() { // eslint-disable-line
				let pickUpDate = $( this ).datepicker( 'getDate' );
				let dropOffDate = $( '#order_drop_off_date' ).datepicker( 'getDate' );

				if ( dropOffDate !== null && pickUpDate !== null ) {

					let timeDiff = Math.abs( pickUpDate.getTime() - dropOffDate.getTime() );
					let diffDays = Math.ceil( timeDiff / ( 1000 * 3600 * 24 ) );

					if ( pickUpDate < dropOffDate ) {
						if ( $( '#dropoff_greater_pickup_error' ).length === 0 ) {
							$( '#order_drop_off_date' ).after( '<span id="dropoff_greater_pickup_error" class="order_field_error">The drop off date must be before the pick up date.</span>' );
						}
					}

					else {
					   $( '#dropoff_greater_pickup_error' ).remove();
					}

					if ( diffDays > 14 ) {
						if ( $( '#order_greater_14days' ).length === 0 ) {
	 						$( '#order_pick_up_date' ).after( '<span id="order_greater_14days" class="order_field_error">The maximum order period is 14 days</span>' );
						}
					}

					else {
						$( '#order_greater_14days' ).remove();
					}

					let selectedDumpsterID = $( '#order_dumpster_size' ).val();
					if ( selectedDumpsterID && selectedDumpsterID.trim() !== '' ) {
						getOrderTotal( selectedDumpsterID );
					}
				}
			}
		} );
	} );
}

function submitOrderForm() {
	// Store order from fields
	let firstName = $('#order_first_name');
	let lastName = $('#order_last_name');
	let email = $('#order_email');
	let phone = $('#order_phone');
	let company = $('#order_company_name');
	let hdyhau = $('#order_hdyhau');
	let wasteType = $('#order_waste_type');
	let dumpsterSize = $('#order_dumpster_size');
	let streetAddress = $('#order_street_address');
	let city = $('#order_city');
	let state = $('#order_state');
	let zipCode = $('#order_zipcode');
	let placement = $('#order_placement');
	let dropOffDate = $('#order_drop_off_date');
	let pickUpDate = $('#order_pick_up_date');
	let discountCode = $('#order_discount_code');
	let terms = $('#order_delivery_policy');

	// Creates a FormData object to hold form data for server submission.
	let formData = new FormData();

	formData.append( 'action', 'order_form_handler' );

	formData.append( 'first_name', firstName.value );
	formData.append( 'last_name', lastName.value );
	formData.append( 'email', email.value );
	formData.append( 'phone', phone.value );
	formData.append( 'company_name', company.value );
	formData.append( 'hdyhau', hdyhau.value );
	formData.append( 'waste_type', wasteType.value );
	formData.append( 'dumpster_size', dumpsterSize.value );
	formData.append( 'street_address', streetAddress.value );
	formData.append( 'city', city.value );
	formData.append( 'state', state.value );
	formData.append( 'zipcode', zipCode.value );
	formData.append( 'placement', placement.value );
	formData.append( 'drop_off_date', dropOffDate.value );
	formData.append( 'pick_up_date', pickUpDate.value );
	formData.append( 'discount_code', discountCode.value );
	formData.append( 'terms_conditions', terms.checked );

	// Send the form data to the PHP script using the fetch API
	fetch ( handler.order_form_handler, {
		method: 'POST',
		body: formData,
	} )

	.then( response => response.json() )

	.then( data => {

		//Display Contact Information Errors
		if ( data === 'empty_first_name' ) {
			firstName.nextElementSibling === null ? firstName.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['first_name'] + '</span>' ) : null;
			scrollToError();
		} else {
			firstName.nextElementSibling?.remove();
		}

		if ( data === 'empty_last_name' ) {
			lastName.nextElementSibling === null ? lastName.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['last_name'] + '</span>' ) : null;
			scrollToError();
		} else {
			lastName.nextElementSibling?.remove();
		}

		if ( data === 'empty_email' ) {
			email.nextElementSibling === null ? email.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['email'] + '</span>' ) : null;
			scrollToError();
		} else {
			email.nextElementSibling?.remove();
		}

		if ( data === 'empty_phone' ) {
			phone.nextElementSibling === null ? phone.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['phone'] + '</span>' ) : null;
			scrollToError();
		} else {
			phone.nextElementSibling?.remove();
		}

		if ( data === 'empty_company_name' ) {
			company.nextElementSibling === null ? company.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['company_name'] + '</span>' ) : null;
			scrollToError();
		} else {
			company.nextElementSibling?.remove();
		}

		if ( data === 'empty_hdyhau' ) {
			hdyhau.nextElementSibling === null ? hdyhau.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['hdyhau'] + '</span>' ) : null;
			scrollToError();
		} else {
			hdyhau.nextElementSibling?.remove();
		}

		if ( data === 'empty_waste_type' ) {
			wasteType.nextElementSibling === null ? wasteType.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['waste_type'] + '</span>' ) : null;
			scrollToError();
		} else {
			wasteType.nextElementSibling?.remove();
		}

		if ( data === 'empty_dumpster_size' ) {
			dumpsterSize.nextElementSibling === null ? dumpsterSize.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['dumpster_size'] + '</span>' ) : null;
			scrollToError();
		} else {
			dumpsterSize.nextElementSibling?.remove();
		}

		// Display Delivery Information Errors
		if ( data === 'empty_street_address' ) {
			streetAddress.nextElementSibling === null ? streetAddress.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['street_address'] + '</span>' ) : null;
			scrollToError();
		} else {
			streetAddress.nextElementSibling?.remove();
		}

		if ( data === 'empty_city' ) {
			city.nextElementSibling === null ? city.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['city'] + '</span>' ) : null;
			scrollToError();
		} else {
			city.nextElementSibling?.remove();
		}

		if ( data === 'empty_state' ) {
			state.nextElementSibling === null ? state.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['state'] + '</span>' ) : null;
			scrollToError();
		} else {
			state.nextElementSibling?.remove();
		}

		if ( data === 'empty_zipcode' ) {
			zipCode.nextElementSibling === null ? zipCode.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['zipcode'] + '</span>' ) : null;
			scrollToError();
		} else {
			zipCode.nextElementSibling?.remove();
		}

		if ( data === 'empty_placement' ) {
			placement.nextElementSibling === null ? placement.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['placement'] + '</span>' ) : null;
			scrollToError();
		} else {
			placement.nextElementSibling?.remove();
		}

		if ( data === 'empty_pick_up_date' ) {
			pickUpDate.nextElementSibling === null ? pickUpDate.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['pick_up_date'] + '</span>' ) : null;
			scrollToError();
		} else {
			pickUpDate.nextElementSibling?.remove();
		}

		if ( data === 'terms_unchecked' ) {
			let parentNode = terms.parentNode.parentNode;
			let errorExist = parentNode.querySelector( '.order_field_error' ) !== null ? true : false;

			!errorExist ? parentNode.innerHTML += '<span class="order_field_error">' + errorTexts['terms'] + '</span>' : null;
		
			scrollToError();
		}

		else {
			let parentNode = terms.parentNode.parentNode;
			let errorNode = parentNode.querySelector( '.order_field_error' );

			errorNode !== null ? parentNode.removeChild( errorNode ) : null;
		}

		// Discount Code Errors
		if ( data === 'discount_not_allowed' ) {
			discountCode.nextElementSibling === null ? discountCode.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['discount_not_allowed'] + '</span>' ) : null;
			scrollToError();
		}

		else if ( data === 'invalid_discount_code' ) {
			discountCode.nextElementSibling === null ? discountCode.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['discount_code'] + '</span>' ) : null;
			scrollToError();
		}
	
		else {
			discountCode.nextElementSibling?.remove();
		}

		// Dropoff Date Errors
		if ( data === 'empty_drop_off_date' ) {
			dropOffDate.nextElementSibling?.remove();
			dropOffDate.nextElementSibling === null ? dropOffDate.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['drop_off_date'] + '</span>' ) : null;
			scrollToError();
		}
	
		else if ( data === 'past_cutoff_time' ) {
			dropOffDate.nextElementSibling?.remove();
			dropOffDate.nextElementSibling === null ? dropOffDate.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['drop_off_date_past_cutoff_time'] + '</span>' ) : null;
			scrollToError();
		}
	
		else if ( data === 'past_date' ) {
			dropOffDate.nextElementSibling?.remove();
			dropOffDate.nextElementSibling === null ? dropOffDate.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['drop_off_date_past'] + '</span>' ) : null;
			scrollToError();
		}
	
		else if ( data === 'weekend' ) {
			dropOffDate.nextElementSibling?.remove();
			dropOffDate.nextElementSibling === null ? dropOffDate.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['drop_off_date_weekend'] + '</span>' ) : null;
			scrollToError();
		}
	
		else {
			dropOffDate.nextElementSibling?.remove();
		}

		// CleanTalk Errors
		let buttonContainer = document.getElementById( 'button-container' );
		let errorElement = buttonContainer.querySelector( '.order_field_error' );
	
		if ( data.apbct !== undefined && data.apbct.blocked === true ) {
			errorElement === null ? buttonContainer.insertAdjacentHTML( 'afterbegin', '<span class="order_field_error" style="display: block; margin-bottom: 10px; text-align: left;">' + data.apbct.comment + '</span>' ) : null;
		} else {
			errorElement?.remove();
		}

		// Success Message
		if ( data === 'Success' ) {
			let successPopup = $( '#modal-success-popup' );
			let otherPopups = $( '.modal.show:not(#modal-success-popup)' );
			if ( successPopup.length ) {
				if ( otherPopups.length ) {
					otherPopups.modal( 'hide' );
					setTimeout( function() { successPopup.modal( 'show' ); }, 150 );
				} else {
					successPopup.modal( 'show' );
				}
			}

			$( '#order-form' )[0].reset();
			$( '.total-amount' ).empty().css( 'margin-top', '0' );
		}
	} )

	.catch( error => {
		console.error( 'Error:', error );
	} );
}

/**
 * Calculate and Display Total Order Amount
 */
function getOrderTotal( orderID ) {

	let orderData = new FormData();

	let discountCode = document.getElementById( 'order_discount_code' );

	orderData.append( 'action', 'calculate_order_amount' );
	orderData.append( 'order_id', orderID );
	orderData.append( 'discount_code', discountCode.value );

	// Send the form data to the PHP script using the fetch API
	fetch ( handler.order_amount, { // eslint-disable-line
		method: 'POST',
		body: orderData,
	} )

	.then( response => response.json() )

	.then( data => {
		if ( typeof data['error'] !== 'undefined' ) {
			discountCode.nextElementSibling === null ? discountCode.insertAdjacentHTML( 'afterend', '<span class="order_field_error">' + errorTexts['discount_not_allowed'] + '</span>' ) : null;
		}

		else {
			discountCode.nextElementSibling?.remove();
		}

		$( '.total-amount' ).css( 'margin-top', '3.5rem' ).html( 'Total: <span id="amount">$' + data['dumpster_amount'] + '</span>' );
	} )

	.catch( error => {
		console.error( 'Error:', error );
	} );
}

/**
 * Calculate and Return USA Central Time Zone Hour
 */
function getCTHour() {
	let userDate = new Date();
	let timestamp = userDate.getTime();
	let UTCOffset = userDate.getTimezoneOffset() * 60000;
	let UTCTime = timestamp + UTCOffset;
	let isDST = ( new Date( userDate.getFullYear(), 0 ).getTimezoneOffset() > userDate.getTimezoneOffset() );
	let CTOffset = isDST ? -5.0 * 3600000 : -6.0 * 3600000;
	let CTDate = new Date( UTCTime + CTOffset );
	let CTHour = CTDate.getHours();

	return CTHour;
}


/**
 * Calculate and Return Tomorrow's Date
 */
function getTomorrowDate() {
 	let today = new Date();
	let tomorrow = new Date( today );
	tomorrow.setDate( today.getDate() + 1 );
			
	let mm = String( tomorrow.getMonth() + 1 ).padStart( 2, '0' );
	let dd = String( tomorrow.getDate() ).padStart( 2, '0' );
	let yy = String( tomorrow.getFullYear() );

 	let tomorrowDate = mm + '-' + dd + '-' + yy;

 	return tomorrowDate;
}

/**
 * Convert Cutoff Time in 12 Hour Format.
 */
function convertTo12HourFormat( cutoffHour ) {
	let period = cutoffHour >= 12 ? 'PM' : 'AM';
	let convertedHour = cutoffHour % 12;
	convertedHour = convertedHour ? convertedHour : 12;
	return `${convertedHour} ${period}`;
}

/**
 * Scroll Form to the Error Position
 */
function scrollToError() {
	let container = $( '.wp-site-blocks' );
	let target = $( '.order_field_error' ).parent();
	let headerHeight = $( '.page-header' ).outerHeight();

	let targetPosition = target.offset().top - container.offset().top + container.scrollTop() - headerHeight;

	container.animate( {
		scrollTop: targetPosition
	}, 'smooth' );
}