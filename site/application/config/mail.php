<?php defined('SYSPATH') or die('No direct access allowed.');

//key for GYMHIT
return array(
  'Host' => 'mail.etechfocus.com',
  'SMTPAuth' => true, 						// Enable SMTP authentication
  'Username' => 'test@etechfocus.com',		// SMTP Login
  'Password' => '1111',				// SMTP Password
  'SMTPSecure' => '', 					// Enable TLS encryption, `ssl` also accepted
  'Port' => 587,
  'From' => 'test@etechfocus.com',
  'FromName' => 'GYMHIT',
  'subject' => 'Message from gymhit.com' 	// Default subject
);
