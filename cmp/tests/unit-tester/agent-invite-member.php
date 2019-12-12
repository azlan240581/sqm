<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<title>Agent Invite Member</title>

</head>

<body>
<div class="container">
<h2>Agent Invite Member</h2>
<p>Send invitation to potential user to join as a member.</p>
<p><strong>URL : <?= (isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/agent-invite-member' ?></strong></p>

<form id="test" name="test" method="post" enctype="multipart/form-data" action="/cmp/server/api/agent-invite-member">
<input type="hidden" name="debug_mode" value="true" />

<br />

<div class="form-group">
<label for="uuid">UUID:</label>
<input type="text" class="form-control" id="uuid" name="uuid">
</div>

<br />
<br />

<div class="form-group">
<label for="firstname">First name:</label>
<input type="text" class="form-control" id="firstname" name="firstname">
</div>

<div class="form-group">
<label for="lastname">Last name:</label>
<input type="text" class="form-control" id="lastname" name="lastname">
</div>

<div class="form-group">
<label for="email">Email:</label>
<input type="text" class="form-control" id="email" name="email">
</div>

<div class="form-group">
<label for="country_code">Contact Number:</label>
<div class="row">
<div class="col-xs-4">
<select class="form-control" id="country_code" name="country_code">
<option value="62">+62</option>
<option value="65">+65</option>
</select>
</div>
<div class="col-xs-8">
<input type="text" class="form-control" id="contact_no" name="contact_no">
</div>
</div>
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
