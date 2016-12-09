<?php
/*
Plugin Name: Example Contact Form Plugin
*/

function html_form_code() {
	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
	echo '<p>';
    echo 'All fields are required </br>';
    echo '</p>';
    echo '<p>';
	echo 'Name <br/>';
	echo '<input type="text" name="cf-name" pattern=" placeholder="required" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Street <br/>';
	echo '<input type="text" name="cf-street" value="' . ( isset( $_POST["cf-street"] ) ? esc_attr( $_POST["cf-street"] ) : '' ) . '" size="40" />';
	echo '</p>';
    echo '<p>';
	echo 'City <br/>';
	echo '<input type="text" name="cf-city" value="' . ( isset( $_POST["cf-city"] ) ? esc_attr( $_POST["cf-city"] ) : '' ) . '" size="40" />';
	echo '</p>';
    echo '<p>';
	echo 'Postal Code <br/>';
	echo '<input type="text" name="cf-postal" value="' . ( isset( $_POST["cf-postal"] ) ? esc_attr( $_POST["cf-postal"] ) : '' ) . '" size="40" />';
	echo '</p>';
    echo '<p>';
	echo 'Phone Number <br/>';
	echo '<input type="text" name="cf-number" value="' . ( isset( $_POST["cf-number"] ) ? esc_attr( $_POST["cf-number"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'E-mail <br/>';
	echo '<input type="e-mail" name="cf-subject" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Type of Property <br/>';
    echo '</p>';
    echo '<p>';
    echo '  Residential';
	echo '<input type="radio" name="cf-res">' . ( isset( $_POST["cf-res"] ) ? esc_attr( $_POST["cf-res"] ) : '' ) . '"/>';
    echo '</p>';
    echo '<p>';
    echo '  Commercial';
    echo '<input type="radio" name="cf-com">' . ( isset( $_POST["cf-com"] ) ? esc_attr( $_POST["cf-com"] ) : '' ) . '"/>';
	echo '</p>';
    echo '<p>';
	echo 'Size of Property <br/>';
	echo'<input type="text" name="cf-property">' . ( isset( $_POST["cf-property"] ) ? esc_attr( $_POST["cf-property"] ) : '' ) . '" />';
	echo '</p>';
    echo '<p>';
	echo 'Service Required <br/>';
	echo '<textarea rows="10" cols="35" name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
	echo '</p>';
	echo '<p><input type="submit" name="cf-submitted" value="Send"></p>';
    echo'<p>';
    echo '<input type="reset" id="reset" value="Reset Fields"><br></p>';
	echo '</<form>';
}

function deliver_mail() {

	// if the submit button is clicked, send the email
	if ( isset( $_POST['cf-submitted'] ) ) {

		// sanitize form values
		$name    = sanitize_text_field( $_POST["cf-name"] );
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
