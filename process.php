<?php
ini_set('display_errors',1);

function httpRequest($url,$data,$method)
{
	$ch = curl_init();

	if($method=='GET')
	{
		curl_setopt($ch, CURLOPT_URL, $url . '?' . $data);
	}
	elseif($method=='POST')
	{
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-type: multipart/form-data;charset=UTF-8','Accept: text/html'));
	}
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, '60');
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
	//curl_setopt($ch, CURLOPT_PORT,80);

	$content = curl_exec($ch);

	if(strlen(curl_error($ch)))
	$content = curl_error($ch);

	return $content;
}

if(count($_POST))
{
	//initialize
	$error = '';
	require_once "library/class.phpmailer.php";

	//validate google captcha
	$data['secret'] = '6LfecbkUAAAAAHWIHnYJcdxq1dEaFn1GII4dq7nc';
	$data['response'] = $_POST['g-recaptcha-response'];
	$data = http_build_query($data);
	$result = json_decode(httpRequest("https://www.google.com/recaptcha/api/siteverify",$data,'GET'));

	if(!$result->success)
	$error = implode('. ',$result->{'error-codes'});

	//capture
	$fullname = trim($_POST['fullname']);
	$email = trim($_POST['email']);
	$contactno = trim($_POST['contactno']);
	$inquiry = trim($_POST['inquiry']);

	//validate
	if(!strlen($error) and !strlen($fullname))
	$error = 'Please enter your Name.';

	if(!strlen($error) and !strlen($contactno))
	$error = 'Please enter your Phone Number.';

	if(!strlen($error) && strlen($contactno) && preg_match("/^([\+\-0-9]{5,20})$/",$contactno) == 0)
	$error = 'Please insert a valid Phone Number.';

	if(!strlen($error) and !strlen($email))
	$error = 'Please enter your Email.';

	if(!strlen($error) and strlen($email) and preg_match("/^([\w\.-]{1,50}+[@]{1}+[\w-]{1,50})+?([\.\w]{1,50})?([\.][\w]{1,50})$/",$email) == 0)
	$error = 'Please insert a valid Email.';

	//send email
	if(!strlen($error))
	{
		$mail = new PHPMailer(); //Create PHPmailer class
		$mail->IsSMTP();                                      // set mailer to use SMTP
		$mail->IsHTML(true);                                  // set email format to HTML
		$mail->Mailer = "smtp"; //Protocol to use
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Host = "srv42.niagahoster.com";  // specify main and backup server
		$mail->Username = "support@sqmproperty.co.id";  // SMTP username
		$mail->Password = "l4v0n-ff5"; // SMTP password
		$mail->Port = 587; // SMTP password
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAutoTLS = true;

				$mail->From = 'inquiry@sqmproperty.co.id'; //Sender address
		$mail->FromName = 'SQM Property Contact Us Form'; //The name that you'll see as Sender
		$mail->AddAddress('inquiry@sqmproperty.co.id','SQM Property Inquiry');// name is optional
		//$mail->AddAddress('techdev@forefront.com.my');
		$mail->AddBCC('techdev@forefront.com.my');
		$mail->Subject = "SQM Property Contact Us Form : ".$fullname."(".$contactno.")"; //Subject of the mail

		//Body of the message
		$message = '<p><b><u>Contact Us</u></b></p>';
		$message .= '<p><b>Name:</b> <br> '.$fullname.'</p>';
		$message .= '<p><b>Email:</b> <br> '.$email.'</p>';
		$message .= '<p><b>Phone Number:</b> <br> '.$contactno.'</p>';
		$message .= '<p><b>Comments:</b> <br> '.$inquiry.'</p>';

		$mail->Body = $message; 
		$mail->Send();
	}

	//redirection
	if(strlen($error))
	{
		$_SESSION['alertmessage'] = $error;
		header("Location:/contact.html");
		exit();
	}
	else
	{
		header("Location:/contact-thank-you.html");
		exit();
	}
}
?>