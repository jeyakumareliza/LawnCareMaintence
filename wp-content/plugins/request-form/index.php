<?php
/*
Plugin Name: Example Contact Form Plugin
*/
function html_form_code() {
    <link rel='stylesheet' type='text/css' href='style.php' />
	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
    echo '<fieldset>';
	echo '<label for="firstName">First Name</label>';
	echo '<input type="text" name="firstName" required" value="' . ( isset( $_POST["firstName"] ) ? esc_attr( $_POST["firstName"] ) : '' ) . '" size="40" />';
    echo '<label for="lastName">Last Name</label>';
	echo '<input type="text" name="lastName" required" value="' . ( isset( $_POST["lastName"] ) ? esc_attr( $_POST["lastName"] ) : '' ) . '" size="40" />';
    echo '</fieldset>';
    echo '<fieldset>';
    echo '<label for="cf-street">Street</label>';
	echo '<input type="text" name="cf-street" value="' . ( isset( $_POST["cf-street"] ) ? esc_attr( $_POST["cf-street"] ) : '' ) . '" size="80" />';
	echo '</fieldset>';
    echo '<fieldset>';
	echo '<label for="cf-city">City</label>'
	echo '<input type="text" name="cf-city" value="' . ( isset( $_POST["cf-city"] ) ? esc_attr( $_POST["cf-city"] ) : '' ) . '" size="40" />';
	echo '<label for="cf-city">Postal Code</label>'
	echo '<input type="text" name="cf-postal" value="' . ( isset( $_POST["cf-postal"] ) ? esc_attr( $_POST["cf-postal"] ) : '' ) . '" size="40" />';
	echo '</fieldset>';
    echo '<fieldset>';
	echo '<label for="cf-number">Phone Number</label>';
	echo '<input type="text" name="cf-number" value="' . ( isset( $_POST["cf-number"] ) ? esc_attr( $_POST["cf-number"] ) : '' ) . '" size="40" />';
	echo '/fielset>';
	echo '<fieldset>';
	echo '<label for="cf-email">E-mail</label>';
	echo '<input type="e-mail" name="cf-email" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" />';
	echo '</fieldset>';
	echo '<fieldset>';
	echo '<legend>Type of Property</legend>';
	echo '<input type="radio" name="cf-res" id="cf-res">' . ( isset( $_POST["cf-res"] ) ? esc_attr( $_POST["cf-res"] ) : '' );
    echo '<label for="cf-res">Residential</label>';
    echo '<input type="radio" name="cf-com" id="cf-com">' . ( isset( $_POST["cf-com"] ) ? esc_attr( $_POST["cf-com"] ) : '' );
    echo '<label for="cf-res">Residential</label>';
	echo '</fieldset>';
    echo '<fieldset>';
	echo '<label for="cf-property">Property Size</label>';
	echo'<input type="text" name="cf-property">' . ( isset( $_POST["cf-property"] ) ? esc_attr( $_POST["cf-property"] ) : '' );
	echo '</fieldset>';
    echo '<fieldset>';
	echo '<label for="cf-message">Service Required</label>';
	echo '<textarea rows="10" cols="35" name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
	echo '</fieldset>';
	echo '<fieldset>';'<input type="submit" name="cf-submitted" value="Send"></fielset>';
    echo'<fieldset>';
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
		if ( wp_mail( $to, $message, $headers) ) {
			echo '<div>';
			echo '<p>Thanks for contacting me, expect a response soon.</p>';
			echo '</div>';
		} else {
			echo 'An unexpected error occurred';
		}
	}
}

function cf_shortcode() {
	ob_start();
	deliver_mail();
	html_form_code();

	return ob_get_clean();
}

add_shortcode( 'sitepoint_contact_form', 'cf_shortcode' );

?>
