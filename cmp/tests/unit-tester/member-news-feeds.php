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

$categories = json_decode(httpRequest((isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/lookup-news-feed-categories-list',array('site_password'=>'sqm@H$3pqp'),'POST'));
$categories = $categories->data;
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
<title>Member News Feeds</title>
</head>

<body>
<div class="container">
<h2>Member News Feeds</h2>
<p>Get news feeds list.</p>
<p><strong>URL : <?= (isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/member-news-feeds' ?></strong></p>

<form id="test" name="test" method="post" enctype="multipart/form-data" action="/cmp/server/api/member-news-feeds">
<input type="hidden" name="debug_mode" value="true" />

<br />

<div class="form-group">
<label for="uuid">UUID:</label>
<input type="text" class="form-control" id="uuid" name="uuid">
</div>

<br />
<br />

<div class="form-group">
<label for="project">Project :</label>
<select class="form-control" id="project" name="project">
<option value=""></option>
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

<div class="form-group">
<label for="category">News Feed Category :</label>
<select class="form-control" id="category" name="category">
<option value=""></option>
<?php
foreach($categories as $category)
{
?>
<option value="<?= $category->id ?>"><?= $category->name ?></option>
<?php
}
?>
</select>
</div>

<div class="form-group">
<label for="news_feed_id">News Feed ID :</label>
<input type="text" class="form-control" id="news_feed_id" name="news_feed_id">
</div>

<div class="form-group">
<label for="permalink">Permalink :</label>
<input type="text" class="form-control" id="permalink" name="permalink">
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
