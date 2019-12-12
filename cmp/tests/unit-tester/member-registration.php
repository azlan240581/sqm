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

$projects = json_decode(httpRequest((isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/lookup-projects-list',array('site_password'=>'sqm@H$3pqp'),'POST'));
$projects = $projects->data;

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
<title>Member Registration</title>

</head>

<body>
<div class="container">
<h2>Member Registration</h2>
<p>To register member by reference member id or none (from public).</p>
<p><strong>URL : <?= (isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/member-registration' ?></strong></p>

<form id="test" name="test" method="post" enctype="multipart/form-data" action="/cmp/server/api/member-registration">
<input type="hidden" name="debug_mode" value="true" />

<br />
<br />

<div class="form-group">
<label for="sqm_account_manager_id">SQM Account Manager UUID:</label>
<input type="text" class="form-control" id="sqm_account_manager_id" name="sqm_account_manager_id">
</div>

<p>Or</p>

<div class="form-group">
<label for="preferred_project_id">Preferred Project:</label>
<select class="form-control" id="preferred_project_id" name="preferred_project_id">
<?php
foreach($projects as $project)
{
?>
<option value="<?= $project->id ?>"><?= $project->project_name ?></option>
<?php
}
?>
</select>
</div>

<br />
<br />

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
<input type="email" class="form-control" id="email" name="email">
</div>

<div class="form-group">
<label for="password">Password:</label>
<input type="text" class="form-control" id="password" name="password">
</div>

<div class="form-group">
<label for="password_repeat">Password Repeat:</label>
<input type="text" class="form-control" id="password_repeat" name="password_repeat">
</div>

<div class="form-group">
<label for="country_code">Contact No:</label>
<div class="row">
<div class="col-xs-4">
<select class="form-control" id="country_code" name="country_code">
<option value="62">+62</option>
<option value="60">+60</option>
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
<div class="radio"><label><input type="radio" name="gender" value="Female" checked>Female</label></div>
</div>

<div class="form-group">
<label for="verification_code">Email Verification Code:</label>
<input type="text" class="form-control" id="verification_code" name="verification_code">
</div>

<br />
<br />
<br />

<p>Please provide information below if related to Member Get Member Activities</p>
<div class="form-group">
<label for="preferred_project_id">Member Get Member Reference Code:</label>
<input type="text" class="form-control" id="reference_code" name="reference_code">
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
