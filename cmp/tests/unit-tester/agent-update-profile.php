<?php
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
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
	//curl_setopt($ch, CURLOPT_PORT,80);
	
	$content = curl_exec($ch);
	
	if(strlen(curl_error($ch)))
	$content = curl_error($ch);
	
	return $content;
}

if(count($_POST)!=0)
{	
	//initialize
	$error = '';
	$tmpurl = (isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/agent-upload-file';

	$fields = array();
	$fields['uuid'] = $_POST['uuid'];
	
	//get profile_photo
	if($_FILES['profile_photo']['error']==0)
	{
		$fields['file'] = new CURLFile(
					$_FILES['profile_photo']['tmp_name'],
					$_FILES['profile_photo']['type'],
					$_FILES['profile_photo']['name']
				);
		$response = json_decode(httpRequest($tmpurl,$fields,'POST'));
		$fields['profile_photo'] = $response->filepath;
	}
	
	$tmpurl = (isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/agent-profile';
	$fields['action'] = $_POST['action'];
	$fields['sqm_id'] = $_POST['sqm_id'];
	$fields['firstname'] = $_POST['firstname'];
	$fields['lastname'] = $_POST['lastname'];
	$fields['email'] = $_POST['email'];
	$fields['country_code'] = $_POST['country_code'];
	$fields['contact_number'] = $_POST['contact_number'];
	$fields['profile_description'] = $_POST['profile_description'];
	$fields['dob'] = $_POST['dob'];
	$fields['gender'] = $_POST['gender'];
	$fields['address_1'] = $_POST['address_1'];
	$fields['address_2'] = $_POST['address_2'];
	$fields['address_3'] = $_POST['address_3'];
	$fields['city'] = $_POST['ffscity'];
	$fields['postcode'] = $_POST['postcode'];
	$fields['state'] = $_POST['state'];
	$fields['country'] = $_POST['country'];
	
	if(!strlen($error))
	$response = json_decode(httpRequest($tmpurl,$fields,'POST'));

	echo '<pre>';
	print_r($response);
	echo '</pre>';
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<title>Agent Profile</title>
<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
</head>

<body>
<div class="container">
<h2>Agent Update Profile</h2>
<p>Update profiles details.</p>
<p><strong>URL : <?= (isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/agent-profile' ?></strong></p>
<p><strong>Upload API URL : <?= (isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/agent-upload-file' ?></strong></p>

<form id="test" name="test" method="post" enctype="multipart/form-data" action="">
<input type="hidden" name="action" value="update" />
<input type="hidden" name="debug_mode" value="true" />

<br />

<div class="form-group">
<label for="uuid">UUID:</label>
<input type="text" class="form-control" id="uuid" name="uuid">
</div>

<br />
<hr />
<br />

<div class="form-group">
<label for="sqm_id">SQM ID:</label>
<input type="text" class="form-control" id="sqm_id" name="sqm_id">
</div>

<div class="form-group">
<label for="firstname">First Name:</label>
<input type="text" class="form-control" id="firstname" name="firstname">
</div>

<div class="form-group">
<label for="lastname">Last Name:</label>
<input type="text" class="form-control" id="lastname" name="lastname">
</div>

<div class="form-group">
<label for="email">Email:</label>
<input type="text" class="form-control" id="email" name="email">
</div>

<div class="form-group">
<label for="country_code">Contact No:</label>
<div class="row">
<div class="col-xs-4">
<select class="form-control" id="country_code" name="country_code">
<option value="62">+62</option>
<option value="65">+65</option>
</select>
</div>
<div class="col-xs-8">
<input type="text" class="form-control" id="contact_number" name="contact_number">
</div>
</div>
</div>

<div class="form-group">
<label for="dob">Date of Birth:</label>
<input type="text" class="form-control datepicker" id="dob" name="dob" readonly="readonly">
</div>

<div class="form-group">
<label for="gender">Gender:</label>
<div class="radio"><label><input type="radio" name="gender" value="Male" checked>Male</label></div>
<div class="radio"><label><input type="radio" name="gender" value="Female">Female</label></div>
</div>

<div class="form-group">
<label for="profile_photo">Profile Photo:</label>
<input type="file" class="form-control" id="profile_photo" name="profile_photo">
</div>

<div class="form-group">
<label for="profile_description">Profile Description:</label>
<textarea class="form-control" id="profile_description" name="profile_description" row="10"></textarea>
<script>
	CKEDITOR.replace('profile_description');
</script>
</div>

<div class="form-group">
<label for="address_1">Address:</label>
<input type="text" class="form-control" id="address_1" name="address_1">
<input type="text" class="form-control" id="address_2" name="address_2">
<input type="text" class="form-control" id="address_3" name="address_3">
</div>

<div class="form-group">
<label for="city">City:</label>
<input type="text" class="form-control" id="city" name="city">
</div>

<div class="form-group">
<label for="postcode">Postcode:</label>
<input type="text" class="form-control" id="postcode" name="postcode">
</div>

<div class="form-group">
<label for="state">State:</label>
<input type="text" class="form-control" id="state" name="state">
</div>

<div class="form-group">
<label for="country">Country:</label>
<select class="form-control" id="country" name="country">
<option value="100">Indonesia</option>
<option value="129">Malaysia</option>
<option value="188">Singapore</option>
</select>
</div>

<br />
<br />

<div class="form-group">
<button type="submit" class="btn btn-primary">Process</button>
</div>

</form>
</div>

<script>
$('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
});
</script>
</body>
</html>
