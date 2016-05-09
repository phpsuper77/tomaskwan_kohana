<?php defined('SYSPATH') or die('No direct access allowed.');

class Util {

    public static function backtrace() { 
        ob_start(); 
        debug_print_backtrace(); 
        $trace = ob_get_contents(); 
        ob_end_clean(); 
        // Remove first item from backtrace as it's this function which 
        // is redundant. 
        $trace = preg_replace ('/^#0\s+' . __FUNCTION__ . "[^\n]*\n/", '', $trace, 1); 
        // Renumber backtrace items. 
        $trace = preg_replace ('/^#(\d+)/me', '\'#\' . ($1 - 1)', $trace); 
        return $trace; 
    } 

    public static function prepareUrl($s)
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

    public static function sendMail($subject,$to,$message)
    {

        if(!$subject) {
            $subject = Kohana::$config->load('mail')->get('subject');
        }

        require_once APPPATH.'../resources/functions/mailer/PHPMailerAutoload.php';

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

    public static function sendSMS($to,$message)
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


    public static function cropImage($file,$x,$y,$w,$h,$targ_w,$targ_h)
    {
        $jpeg_quality = 90;
        list($width, $height) = getimagesize($file);
        $ext=exif_imagetype($file);
        if ($ext==1) {
            $img_r = imagecreatefromgif($file);
        } else if ($ext==2)  {
            $img_r = imagecreatefromjpeg($file);
        } else if ($ext==3)  {
            $img_r = imagecreatefrompng($file);
        } else {
            // unknown type; no change
            return;
        }
        $dst_r = imagecreatetruecolor( $targ_w, $targ_h );
        //imagecopyresized($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $w, $h);
        $ret = imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $w, $h);
        imagejpeg($dst_r,$file,$jpeg_quality);
    }

    public static function payTransaction($data)
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
        $data_res = json_decode($response,true);
        curl_close($ch);
        return $data_res;
    }
}
