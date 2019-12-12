<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<title>Public Banners</title>
</head>

<body>
<div class="container">
<h2>Public Banners</h2>
<p>Get banner list : Introduction and Highlights.</p>
<p><strong>URL : <?= (isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/public-banners' ?></strong></p>

<form id="test" name="test" method="post" enctype="multipart/form-data" action="/cmp/server/api/public-banners">
<input type="hidden" name="debug_mode" value="true" />

<br />

<div class="form-group">
<label for="banner_category">Banner Category :</label>
<select class="form-control" id="banner_category" name="banner_category">
<option value=""></option>
<option value="Introduction">Introduction</option>
<option value="Highlights">Highlights</option>
</select>
</div>

<div class="form-group">
<label for="banner_id">Banner ID :</label>
<input type="text" class="form-control" id="banner_id" name="banner_id">
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
