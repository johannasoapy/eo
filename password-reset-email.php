<?php
/*
Plugin Name: EO Custom Password Reset Email
Plugin URI: http://livelearn.ca
Description: Customizes the password reset email
Version: 1.0
Author: English Online
Author URI: http://myenglishonline.ca
License: GPL2
*/

/* with help from https://www.smashingmagazine.com/2011/10/create-perfect-emails-wordpress-website/ */
add_filter ("wp_mail_content_type", "my_awesome_mail_content_type");
function my_awesome_mail_content_type() {
	return "text/html";
}

add_filter('retrieve_password_title', 'retrieve_password_title_eo', 10,3);
function retrieve_password_title_eo($title, $user_login, $user_data)
{
    $title = sprintf( __('Live & Learn Password Reset') );
    return $title;
}

add_filter('retrieve_password_message', 'retrieve_password_message_eo', 10,4);
function retrieve_password_message_eo( $message, $key, $user_login, $user_data)
{
    global $wpdb;
    
	// Redefining user_login ensures we return the right case in the email.
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;
	$key = get_password_reset_key( $user_data );

	if ( is_wp_error( $key ) ) {
		return $key;
	}
	
	ob_start();
    $email_subject = retrieve_password_title_eo(); ?>

    <div style="width: 100%;"><img src="http://livelearn.ca/wp-content/uploads/2016/08/livelearn_newsletter-header.png"></div>
<div style="max-width: 600px;"><h2>Password Reset for livelearn.ca</h2><p style="font-family: Calibri, sans-serif;font-size: 12px; color: #000; background: #e5e5e5; padding: 8px;"><strong>CONFIDENTIALITY NOTE:</strong> This message is intended only for the use of the individual to whom it is addressed and may contain information that is privileged/confidential. Any other distribution, copying or disclosure is strictly prohibited. If you are not the intended recipient or have received this message in error, please notify us immediately by reply e-mail and permanently delete this message without reading it or making a copy. Thank you.</p>
    
        <p>Someone has requested a password reset for the following account:<br>
        <?php echo network_home_url( '/' ); ?></p>
        <p><?php sprintf(__('Username: %s'), $user_login); ?></p>
        <p>If you do not want to change your password, just ignore this email and nothing will happen.</p>
        <p>To reset your password, visit the following address, type your own chosen password into the field, and then click the orange "Reset Password" button:<br>
            <a href='<?php echo network_site_url("/"); ?>wp-login.php?action=rp&key=<?php echo $key; ?>&login=<?php echo rawurlencode($user_login); ?>'><?php echo network_site_url("/"); ?>wp-login.php?action=rp&key=<?php echo $key; ?>&login=<?php echo rawurlencode($user_login); ?></a>
        </p>
    
    
    
    <p><em>Happy e-learning!</em></p></div><div style="font-family: Calibri, sans-serif;font-size: 12px; color: #000;">
        <p><strong>The English Online Team</strong><br>
            info@myenglishonline.ca<br>
            204.946.5140</p>
             <p><img src="http://livelearn.ca/wp-content/uploads/2016/08/signature-line-220px.png" style="width: 220px;" alt="dotted line"></p>

<p><strong>English Online Inc.</strong><br>
    <strong><a href="myenglishonline.ca" style="color: #616161; text-decoration: none;">myenglishonline.ca</a></strong><br>
610-294 Portage Avenue<br>
Winnipeg, MB R3C 0B9<br>
<p><img src="http://livelearn.ca/wp-content/uploads/2016/08/eo-logo-tagline-220px.png" style="width: 220px;" alt="English Online: Your settlement and language learning network"></p></div>
    <?php $message = ob_get_contents();

	ob_end_clean();
    
    return $message;
}
?>