<?php
/*
* Plugin Name: branded login
* Description: brands the default WordPress login screen.
* Version: 2.1
* Author: Jake Price | JP Creative Media
* Author URI: https://jpcreative.ca/
* License: GPLv2
*/

// hooks
add_action( 'login_enqueue_scripts' , 'brandedLogin_enqueue_scripts' );
add_filter( 'login_headerurl', 'customLogoURL' );
add_filter( 'login_title', 'customLogoTitle' );
add_filter( 'login_headertext', 'customLogoHeaderText' );
add_filter('login_errors', 'customLoginErrorMessage');
add_action('login_footer','customLoginFooter');
add_action( 'init', 'loginRememberMe' );
add_filter('login_redirect', 'customLoginRedirect', 10, 3);

// register styles & scripts
function brandedLogin_enqueue_scripts() {

    // stylesheets
    wp_register_style('login-CSS-style', plugin_dir_url( __FILE__ ) . 'brandedLogin/css/login-style.css', 1.0, false);
    wp_enqueue_style('login-CSS-style');

}

function customLoginFooter() {

	// stylesheets
    wp_register_style('customFooter-CSS-style', plugin_dir_url( __FILE__ ) . 'brandedLogin/css/customFooter-style.css', 1.0, false);
    wp_enqueue_style('customFooter-CSS-style');

    // content
	?>
	<div class="customFooter">

		<!-- text -->
		<p>design by <a href="https://jpcreativemedia.ca" target="_blank">JP Creative Media</a></p>
		
		<!-- img -->
		<img src="/wp-content/mu-plugins/brandedLogin/assets/jpcreativemedia-logo.png">
	</div>
	<?php
}

// login logo URL
function customLogoURL() {

	return 'https://bodhibodies.ca/';
}

function customLogoTitle($titleText) {

	$titleText = esc_html__( 'Bodhi Bodies Wellness', 'plugin-textdomain' );
    return $titleText;
}

function customLogoHeaderText($headerText) {

    $headerText = esc_html__( 'Bodhi Bodies Wellness', 'plugin-textdomain' );
    return $headerText;
}

// login error message
function customLoginErrorMessage() {

	return "oops, something wasn't quite right. please try again!";
}

// remember me checked
function loginRememberMe() {

	add_filter( 'login_footer', 'rememberme_checked' );
}

function rememberme_checked() {

	echo "<script>document.getElementById('rememberme').checked = true;</script>";
}

// login redirect
function customLoginRedirect( $redirect_to, $request, $user ) {

	if ( isset( $user->roles ) && is_array( $user->roles ) ) {

			if( in_array('administrator', $user->roles)) {

					return admin_url();
				} else {

					return home_url();
				}
  			} else {

  				return home_url();
  			}
}
?>