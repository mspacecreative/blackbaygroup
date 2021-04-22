<?php

add_filter('wp_mail_smtp_custom_options', function( $phpmailer ) {
	$phpmailer->SMTPOptions = array(
		'ssl' => array(
			'verify_peer'       => false,
			'verify_peer_name'  => false,
			'allow_self_signed' => true
		)
	);

	return $phpmailer;
} );