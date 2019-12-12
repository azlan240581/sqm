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

$projectProducts = json_decode(httpRequest((isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/lookup-project-products-list',array('site_password'=>'sqm@H$3pqp'),'POST'));
$projectProducts = $projectProducts->data;

$propertyTypes = json_decode(httpRequest((isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/lookup-product-type-list',array('site_password'=>'sqm@H$3pqp'),'POST'));
$propertyTypes = $propertyTypes->data;

$productTypes = json_decode(httpRequest((isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/lookup-property-product-type-list',array('site_password'=>'sqm@H$3pqp'),'POST'));
$productTypes = $productTypes->data;

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
<title>Public Property Products</title>
</head>

<body>
<div class="container">
<h2>Public Property Products</h2>
<p>Get property products list.</p>
<p><strong>URL : <?= (isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/public-property-products' ?></strong></p>

<form id="test" name="test" method="post" enctype="multipart/form-data" action="/cmp/server/api/public-property-products">
<input type="hidden" name="debug_mode" value="true" />

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
<label for="project_product">Project Product :</label>
<select class="form-control" id="project_product" name="project_product">
<option value=""></option>
<?php
foreach($projectProducts as $project_product)
{
?>
<option value="<?= $project_product->id ?>"><?= $project_product->product_name ?></option>
<?php
}
?>
</select>
</div>

<div class="form-group">
<label for="property_type">Property Type :</label>
<select class="form-control" id="property_type" name="property_type">
<option value=""></option>
<?php
foreach($propertyTypes as $property_type)
{
?>
<option value="<?= $property_type->id ?>"><?= $property_type->name ?></option>
<?php
}
?>
</select>
</div>

<div class="form-group">
<label for="product_type">Product Type :</label>
<select class="form-control" id="product_type" name="product_type">
<option value=""></option>
<?php
foreach($productTypes as $product_type)
{
?>
<option value="<?= $product_type->id ?>"><?= $product_type->name ?></option>
<?php
}
?>
</select>
</div>

<div class="form-group">
<label for="product_id">Product ID :</label>
<input type="text" class="form-control" id="product_id" name="product_id">
</div>

<div class="form-group">
<label for="permalink">Permalink :</label>
<input type="text" class="form-control" id="permalink" name="permalink">
</div>

<div class="form-group">
<label for="filter_by_price_range">Price Range (sm) :</label>
<select class="form-control" id="filter_by_price_range" name="filter_by_price_range">
<option value=""></option>
<option value="0-10000000000">0-10000000000</option>
<option value="10000000001-20000000000">10000000001-20000000000</option>
<option value="20000000001-30000000000">20000000001-30000000000</option>
</select>
</div>

<div class="form-group">
<label for="filter_by_building_size_range">Building Size Range (sm) :</label>
<select class="form-control" id="filter_by_building_size_range" name="filter_by_building_size_range">
<option value=""></option>
<option value="0-500">0-500</option>
<option value="501-1000">501-1000</option>
<option value="1001-2000">1001-2000</option>
</select>
</div>

<div class="form-group">
<label for="filter_by_land_size_range">Land Size Range (sm) :</label>
<select class="form-control" id="filter_by_land_size_range" name="filter_by_land_size_range">
<option value=""></option>
<option value="0-500">0-500</option>
<option value="501-1000">501-1000</option>
<option value="1001-2000">1001-2000</option>
</select>
</div>

<div class="form-group">
<label for="filter_by_bedroom_range">Bedroom Range :</label>
<select class="form-control" id="filter_by_bedroom_range" name="filter_by_bedroom_range">
<option value=""></option>
<option value="0-3">0-3</option>
<option value="4-7">4-7</option>
<option value="8-10">8-10</option>
<option value="11-15">11-15</option>
</select>
</div>

<div class="form-group">
<label for="filter_by_bathroom_range">Bathroom Range :</label>
<select class="form-control" id="filter_by_bathroom_range" name="filter_by_bathroom_range">
<option value=""></option>
<option value="0-3">0-3</option>
<option value="4-7">4-7</option>
<option value="8-10">8-10</option>
<option value="11-15">11-15</option>
</select>
</div>

<div class="form-group">
<label for="filter_by_parking_lot_range">Parking Lot Range :</label>
<select class="form-control" id="filter_by_parking_lot_range" name="filter_by_parking_lot_range">
<option value=""></option>
<option value="0-3">0-3</option>
<option value="4-7">4-7</option>
<option value="8-10">8-10</option>
<option value="11-15">11-15</option>
</select>
</div>

<div class="form-group">
<label for="createdby_id">Created By ID :</label>
<input type="text" class="form-control" id="createdby_id" name="createdby_id">
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
