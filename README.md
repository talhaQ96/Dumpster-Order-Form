# Dumpster Order Form
Custom Dumpster Order Form with real-time order placement and payment processing, built for a client to streamline online orders directly through their website.

## Features :sparkles:
### Core Features
1. The form allows users to place orders by filling out the required fields.
2. Upon submission, an order entry is created in the backend as a custom post type.
3. Confirmation emails are sent to both the customer and the website owner.
4. The form also supports live payment processing through the Fluidpay payment gateway, integrated via API.

### Advanced Features
Additional features were incorporated into the form to meet the client’s specific business needs, including:
1. Form submissions are restricted on weekends and for past dates.
2. Submissions are not allowed after 2 PM US Central Time (this time can be adjusted from the admin panel).
3. The form includes two date fields: one for the drop-off date and another for the pick-up date. The drop-off date must occur before the pick-up date; otherwise, the form cannot be submitted.
4. The total order period for the dumpster cannot exceed 14 days. Therefore, the order period is calculated based on the drop-off and pick-up dates, preventing submission if it exceeds 14 days."
5. Users can enter a coupon code to apply a real-time discount (Coupons can be managed from the admin panel).

## Development Approach :hammer_and_wrench:
Since the website was built on WordPress using custom ACF Blocks, I created the custom HTML form as an ACF Block. To address the challenges, I processed the form with PHP and JavaScript, utilizing the Fetch API and the wp_ajax hook. This approach allowed me to implement all the required features and overcome the challenges. Additionally, I integrated real-time payment processing through the Fluidpay API using cURL.

## Technologies Used :computer:
1. **HTML/CSS:** For form structure and styling.
2. **PHP:** For backend processing of the form and handling AJAX requests.
3. **JavaScript (with jQuery):** For client-side form handling and using the Fetch API.
4. **Advanced Custom Fields (ACF):** Used to create dynamic fields for the coupon code, order cutoff time, email settings, and API keys.
5. **Fluidpay:** For real-time payment processing.
