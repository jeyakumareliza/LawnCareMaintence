<?php
/*
Plugin Name: Example Contact Form Plugin
*/
function html_form_code() {
	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
    echo '<fieldset>';
	echo '<label for="firstName">First Name </label>';
	echo '<input type="text" name="firstName" value="' . ( isset( $_POST["firstName"] ) ? esc_attr( $_POST["firstName"] ) : '' ) . '" size="30" />';
    echo '<label for="lastName">  Last Name </label>';
	echo '<input type="text" name="lastName" value="' . ( isset( $_POST["lastName"] ) ? esc_attr( $_POST["lastName"] ) : '' ) . '" size="30" />';
    echo '<br/></fieldset>';
    echo '<fieldset>';
    echo '<label for="cf-street">Street </label>';
	echo '<input type="text" name="cf-street" value="' . ( isset( $_POST["cf-street"] ) ? esc_attr( $_POST["cf-street"] ) : '' ) . '" size="80" />';
	echo '<br/></fieldset>';
    echo '<fieldset>';
	echo '<label for="cf-city">City </label>';
	echo '<input type="text" name="cf-city" value="' . ( isset( $_POST["cf-city"] ) ? esc_attr( $_POST["cf-city"] ) : '' ) . '" size="40" />';
	echo '<label for="cf-city">  Postal Code </label>';
	echo '<input type="text" name="cf-postal" value="' . ( isset( $_POST["cf-postal"] ) ? esc_attr( $_POST["cf-postal"] ) : '' ) . '" size="20" /> <br/>';
	echo '</fieldset>';
    echo '<fieldset>';
	echo '<label for="cf-number">Phone Number </label>';
	echo '<input type="text" name="cf-number" value="' . ( isset( $_POST["cf-number"] ) ? esc_attr( $_POST["cf-number"] ) : '' ) . '" size="20" />';
	echo '<br/></fieldset>';
	echo '<fieldset>';
	echo '<label for="cf-email">E-mail </label>';
	echo '<input type="e-mail" name="cf-email" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" />';
	echo '<br/></fieldset>';
	echo '<fieldset id="radio">';
	echo '<legend>Type of Property</legend>';
	echo '<input type="radio" name="cf-res" id="cf-res">' . ( isset( $_POST["cf-res"] ) ? esc_attr( $_POST["cf-res"] ) : '' );
    echo '<label for="cf-res">Residential </label>';
    echo '<input type="radio" name="cf-com" id="cf-com">' . ( isset( $_POST["cf-com"] ) ? esc_attr( $_POST["cf-com"] ) : '' );
    echo '<label for="cf-com">Commercial </label>';
	echo '<br/></fieldset>';
    echo '<fieldset>';
	echo '<label for="cf-property">Property Size </label>';
	echo'<input type="text" name="cf-property">' . ( isset( $_POST["cf-property"] ) ? esc_attr( $_POST["cf-property"] ) : '' );
	echo '<br/></fieldset>';
    echo '<fieldset>';
	echo '<label for="cf-message">Service Required <br/></label>';
	echo '<textarea rows="5" cols="35" name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
	echo '</fieldset>';
	echo '<fieldset id="buttons">';
    echo '<label>&nbsp;</label>';
    echo '<input type="submit" id="send" name="cf-submitted" value="Send">';
    echo '<input type="reset" id="reset" value="Reset Fields"></fieldset>';
	echo '</<form>';
}

function deliver_mail() {

	// if the submit button is clicked, send the email
	if ( isset( $_POST['cf-submitted'] ) ) {

		// sanitize form values
		$name    = sanitize_text_field( $_POST["cf-firstName"] );
        $street    = sanitize_text_field( $_POST["cf-street"] );
        $city   = sanitize_text_field( $_POST["cf-city"] );
        $postal   = sanitize_text_field( $_POST["cf-postal"] );
        $number   = sanitize_text_field( $_POST["cf-number"] );
		$email   = sanitize_email( $_POST["cf-email"] );
		$res = sanitize_readio( $_POST["cf-res"] );
        $com = sanitize_readio( $_POST["cf-com"] );
        $size = sanitize_text_field( $_POST["cf-property"] );
		$message = esc_textarea( $_POST["cf-message"] );


		// get the blog administrator's email address
		$to = get_option( 'project2lawncare@gmail.com' );

		$headers = "From: $name <$email>" . "\r\n";

		// If email has been process for sending, display a success message
		 wp_mail( $to, $message, $headers)
			echo '<div>';
			echo '<p>Thanks for contacting me, expect a response soon.</p>';
			echo '</div>';
}

function cf_shortcode() {
	ob_start();
	deliver_mail();
	html_form_code();

	return ob_get_clean();
}

add_shortcode( 'sitepoint_contact_form', 'cf_shortcode' );

wp_register_style('your_css_and_js', plugins_url('styles.css', __FILE__));
wp_enqueue_style('your_css_and_js')

?>
