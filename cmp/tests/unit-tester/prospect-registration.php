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
	$tmpurl = (isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/member-register-prospect';
	$fields = array();
	$fields['interested_project_id'] = $_POST['interested_project_id'];
	$fields['prospect_name'] = $_POST['name'];
	$fields['prospect_email'] = $_POST['email'];
	$fields['prospect_contact_number'] = $_POST['country_code'].$_POST['contact_number'];
	$fields['remarks'] = $_POST['remarks'];


	if(empty($_POST['uuid']))
	{
		$defaultUser = json_decode(httpRequest((isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/get-default-sqm-associate','','GET'));
		if(strlen($defaultUser->error)==0)
		{
			$fields['uuid'] = $defaultUser->profile->uuid;
		}
	}
	else
	$fields['uuid'] = $_POST['uuid'];
	
	if(!strlen($error))
	$response = json_decode(httpRequest($tmpurl,$fields,'POST'));

	echo '<pre>';
	print_r($response);
	echo '</pre>';
	exit();
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
<title>Prospect Registration</title>
</head>

<body>
<div class="container">
<h2>Prospect Registration</h2>
<p>To register prospect by reference member id in UUID format or none (from public).</p>
<p><strong>URL : <?= (isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/member-register-prospect' ?></strong></p>

<form id="test" name="test" method="post" enctype="multipart/form-data" action="">
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
<label for="name">Name *:</label>
<input type="text" class="form-control" id="name" name="name">
</div>

<div class="form-group">
<label for="email">Email *:</label>
<input type="text" class="form-control" id="email" name="email">
</div>

<div class="form-group">
<label for="country_code">Contact No *:</label>
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
<label for="remarks">Comments:</label>
<textarea class="form-control" rows="5" id="remarks" name="remarks"></textarea>
</div>

<div class="form-group">
<label for="interested_project_id">Interested Projects *:</label>
<select class="form-control" id="interested_project_id" name="interested_project_id">
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
<button type="submit" class="btn btn-primary">Process</button>
</div>

</form>
</div>
</body>
</html>
