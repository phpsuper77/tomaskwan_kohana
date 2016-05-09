<?php defined('SYSPATH') or die('No direct script access.');

function getGeoDistance($lat1, $lon1, $lat2, $lon2, $unit = 'M') {
	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
 
	if ($unit == "K") {
		return round($miles * 1.609344, 2);
	} else if ($unit == "N") {
		return round($miles * 0.8684, 2);
	} else {
		return round($miles, 2);
	}
}

function sanitizeValue($value) 
{
	$value = Kohana::sanitize($value);
	
	return (isset($value) ? (is_array($value) ? array_map('trim', 
		array_map('strip_tags', array_map('stripslashes', $value))) : 
		trim(strip_tags(stripslashes($value)))) : NULL);
}

function sanitizeHTMLValue($value) 
{
	# FIXME: what about arrays?
  	return (isset($value) ? trim(htmlentities(stripslashes($value), ENT_QUOTES, 'UTF-8')) : NULL);
}

function strftimeV($format,$timestamp){
	return iconv("ISO-8859-2","UTF-8",ucfirst(strftime($format,$timestamp)));
}

function prepareUrl($s)
{        
 $s = mb_strtolower($s, 'UTF-8');
 $s = str_replace(array('ą', 'ś', 'ż', 'ź', 'ć', 'ń', 'ł', 'ó', 'ę', ',', ' ', '/'), array('a', 's', 'z', 'z', 'c', 'n', 'l', 'o', 'e', '-', '-', '-'), $s);

 // remove all unallowed characters
 $s = preg_replace('/[^0-9a-z\-]+/', '', $s);

 // remove double, triple '-'
 $s = preg_replace('/\-+/', '-', $s);

 // trim it
 $s = trim($s, '-');

 return $s;
}

function getFileExtension($str) 
{
		$i = strrpos($str,".");
		if (!$i)
		return "";
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
}

function cropImage($file,$x,$y,$w,$h,$targ_w,$targ_h)
{
	$jpeg_quality = 90;
	list($width, $height) = getimagesize($file);
	$ext=exif_imagetype($file);
	if ($ext==1) $img_r = imagecreatefromgif($file);
	if ($ext==2) $img_r = imagecreatefromjpeg($file);
	if ($ext==3) $img_r = imagecreatefrompng($file);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
	//imagecopyresized($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $w, $h);
	imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $w, $h);
	imagejpeg($dst_r,$file,$jpeg_quality);

/*
	$jpeg_quality = 90;
						
	list($width, $height) = getimagesize($file);
	$ext=exif_imagetype($file);
				
	if ($ext==1) $img_r = imagecreatefromgif($file);
	if ($ext==2) $img_r = imagecreatefromjpeg($file);
	if ($ext==3) $img_r = imagecreatefrompng($file);
		
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
						
//	if($width>600)
//	{
		$width_new=600;
		$height_new=round(($height*$width_new)/$width);
   		$temp = imagecreatetruecolor($width_new, $height_new);
		imagecopyresampled($temp, $img_r, 0, 0, 0, 0, $width_new, $height_new, $width, $height);
		imagecopyresampled($dst_r,$temp,0,0,$x,$y,$targ_w,$targ_h,$w,$h);
		imagedestroy($temp);
//	}
//	else
//	{
//		imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$targ_w,$targ_h,$w,$h);
//	}
						
	imagejpeg($dst_r,$file,$jpeg_quality);
	return TRUE;
*/
}

function getRole($roleId)
{
	$roles = array(
		0 => 'Administrator',
		1 => 'Business',
		2 => 'Individual Trainer',
		3 => 'Supplement Store / Other Business',
		4 => 'Regular User'
	);
	
	return $roles[$roleId];
}

function getDay($day)
{
	$days = array(
		1 => 'Monday',
		2 => 'Tuesday',
		3 => 'Wednesday',
		4 => 'Thursday',
		5 => 'Friday',
		6 => 'Saturday',
		7 => 'Sunday'
	);
	
	return $days[$day];	
}

function timeElapse ($time)
{
    $time = time() - $time; // to get the time since that moment

    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }
}

function getBookingType($type)
{
	
	$fullType = array(
		'booking' => 'Individual Session',
		'tour' => 'Free Tour',
		'class' => 'Class');
		
	return $fullType[$type];	
}

function getPeriod($period)
{
	
	$type = array(
		1 => 'Month',
		3 => 'Quarter',
		12 => 'Year');
		
	return $type[$period];	
}

function sendMail($subject,$to,$message)
{
	
	if(!$subject) {
		$subject = Kohana::$config->load('mail')->get('subject');
	}
		
	require_once 'mailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = Kohana::$config->load('mail')->get('Host');  
	$mail->SMTPAuth = Kohana::$config->load('mail')->get('SMTPAuth');        
	$mail->Username = Kohana::$config->load('mail')->get('Username');                 
	$mail->Password = Kohana::$config->load('mail')->get('Password');                          
	$mail->SMTPSecure = Kohana::$config->load('mail')->get('SMTPSecure');     
	$mail->Port = Kohana::$config->load('mail')->get('Port');                                   

	$mail->From = Kohana::$config->load('mail')->get('From');
	$mail->FromName = Kohana::$config->load('mail')->get('FromName');
	$mail->addAddress($to);     // Add a recipient

	//$mail->addReplyTo($data['useremail'], $data['name']);

	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $message;
	$mail->AltBody = $message;

	if(!$mail->send()) {
    	$error = 'Message could not be sent.<br />';
    	$error .= 'Mailer Error: ' . $mail->ErrorInfo;
		return $error;
	}
}

function sendSMS($to,$message)
{	
	$text = urlencode($message);
	
	$ch = curl_init();
	$url = 'https://rest.nexmo.com/sms/json?api_key='.Kohana::$config->load('sms')->get('api_key').'&api_secret='.Kohana::$config->load('sms')->get('api_secret').'&from=12132633539&to='.$to.'&text='.$text;
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_exec($ch);
	if (curl_errno($ch)) {
    	$error = 'Błąd #' . curl_errno($ch) . ': ' . curl_error($ch);
		return $error;
	}
	curl_close($ch);	
}

function payTransaction($data)
{
	
	$ch = curl_init();
	$url = Kohana::$config->load('optimal')->get('url');
	//curl_setopt ($ch, CURLOPT_CAINFO, "c:/webserv/httpd/curl/cacert.pem");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_USERPWD, $data['key']);
	$success = array(
		'rel'=>'on_success',
		'returnKeys'=>array('id'),
		'uri'=>$data['success']
	);
	$error = array(
		'rel'=>'on_error',
		'returnKeys'=>array('id','transaction.errorMessage'),
		'uri'=>$data['error']
	);
	$decline = array(
		'rel'=>'on_decline',
		'returnKeys'=>array('id','transaction.errorMessage'),
		'uri'=>$data['error']
	);
	$data = array('merchantRefNum'=>$data['id'],'currencyCode'=>'USD','totalAmount'=>$data['sum']*100,'redirect'=>array($success,$error,$decline),'customerNotificationEmail'=>$data['customerMail'],'merchantNotificationEmail'=>$data['merchantMail']);
	$data_string = json_encode($data);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    	'Content-Type: application/json',                                                                                
    	'Content-Length: ' . strlen($data_string))                                                                       
	);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	$response = curl_exec($ch);
	$data_res = json_decode($response);
	curl_close($ch);
	
	return $data_res;
}

function checkTransaction($data)
{
	
	$ch = curl_init();
	$url = Kohana::$config->load('optimal')->get('url').'/'.$data['id'];
	//curl_setopt ($ch, CURLOPT_CAINFO, "c:/webserv/httpd/curl/cacert.pem");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_USERPWD, $data['key']);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	$response = curl_exec($ch);
	$data_res = json_decode($response);
	curl_close($ch);
	
	return $data_res;
}

function getAnalytics()
{
	
	include('GoogleAnalyticsAPI.class.php');

	$ga = new GoogleAnalyticsAPI('service');
	$ga->auth->setClientId('926146298490-cgb0opb9u1n9mhrtt5k24aln56a7el1t.apps.googleusercontent.com'); // From the APIs console
	$ga->auth->setEmail('926146298490-cgb0opb9u1n9mhrtt5k24aln56a7el1t@developer.gserviceaccount.com'); // From the APIs console
	$ga->auth->setPrivateKey(FS.'Gymhit-686347f53ab0.p12');


	$auth = $ga->auth->getAccessToken();

	// Try to get the AccessToken
	if ($auth['http_code'] == 200) {
    	$accessToken = $auth['access_token'];
    	$tokenExpires = $auth['expires_in'];
    	$tokenCreated = time();
	} else {
   		$visits = 'error getting access token';
	}
	
	$ga->setAccessToken($accessToken);
	$ga->setAccountId('ga:106078767');
	
	// Set the default params. For example the start/end dates and max-results
	$defaults = array(
    	'start-date' => '2015-07-15',
    	'end-date' => date('Y-m-d'),
	);
	$ga->setDefaultQueryParams($defaults);

	// Example1: Get visits by date
	$params = array(
    	'metrics' => 'ga:visits',
    	'dimensions' => 'ga:date',
	);
	$visits = $ga->query($params);
		
	
	return $visits;
}
?>
