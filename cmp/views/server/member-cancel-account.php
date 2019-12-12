<?php
/* 
member-cancel-account
*/

use app\models\Users;

//initialize
$data = array();
$data['error'] = '';
$request = array();
$request['server'] = json_encode($_SERVER);
$request['get'] = json_encode($_GET);
$request['post'] = json_encode($_POST);

//create Log API
$logapi = Yii::$app->AccessMod->LogAPI('', 'member-cancel-account', $request, '', '');
if(isset($logapi['error']))
$data['error'] = '0000-'.$logapi['error'];

//validate user
if(!strlen($data['error']) && !isset($_REQUEST['uuid']))
$data['error'] = '0001-Invalid ID.';

if(!strlen($data['error']) and !strlen($_REQUEST['uuid']))
$data['error'] = '0002-Invalid ID.';

if(!strlen($data['error']) && !isset($_REQUEST['email']))
$data['error'] = '0003-Invalid email.';

if(!strlen($data['error']) and !strlen($_REQUEST['email']))
$data['error'] = '0004-Invalid email.';

if(!strlen($data['error']) and preg_match("/^([\w\.-]{1,50}+[@]{1}+[\w-]{1,50})+?([\.\w]{1,50})?([\.][\w]{1,50})$/",$_REQUEST['email']) == 0)
$data['error'] = '0005-Invalid email format.';

if(!strlen($data['error']) && !isset($_REQUEST['contact_number']))
$data['error'] = '0006-Invalid contact number.';

if(!strlen($data['error']) and !strlen($_REQUEST['contact_number']))
$data['error'] = '0007-Invalid contact number.';

if(!strlen($data['error']) and preg_match("/^([0-9]{5,20})$/",$_REQUEST['contact_number']) == 0)
$data['error'] = '0008-Invalid contact number format.';

//process
if(!strlen($data['error']))
{
	$result = Yii::$app->MemberMod->memberCancelAccount($_REQUEST['uuid'],$_REQUEST['email'],$_REQUEST['contact_number']);
	
	if(!$result)
	$data['error'] = '0009-'.Yii::$app->MemberMod->errorMessage;
}

//format response
if(!strlen($data['error']))
{
	$data['success'] = true;
}

//update log api
if(!strlen($data['error']))
{
	$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'member-cancel-account', $request, json_encode($data), $result['id']);
	if(isset($logapi['error']))
	$data['error'] = '0000-'.$logapi['error'];
}

//debug mode
if(isset($_REQUEST['debug_mode']))
{
	if(strtolower($_REQUEST['debug_mode'])=='true')
	{
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit();
	}
}
?>

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        #outlook a { padding:0; }
        .ReadMsgBody { width:100%; }
        .ExternalClass { width:100%; }
        .ExternalClass * { line-height:100%; }
        body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }
        table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }
        img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }
        p { display:block;margin:13px 0; }
    </style>
    <style type="text/css">
        @media only screen and (max-width:480px) {
            @-ms-viewport { width:320px; }
            @viewport { width:320px; }
        }
    </style>
    <style type="text/css">
        @media only screen and (min-width:480px) {
            .mj-column-per-100 { width:100% !important; max-width: 100%; }
        }
    </style>
    <style type="text/css">
        @media only screen and (max-width:480px) {
            table.full-width-mobile { width: 100% !important; }
            td.full-width-mobile { width: auto !important; }
        }
    </style>

</head>
<body style="background-color:#fbfbfb;">
    <div style="background-color:#fbfbfb;">
        <div style="height:30px;">
            &nbsp;
        </div>

        <div  style="Margin:0px auto;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:0 20px;text-align:center;vertical-align:top;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:560px;" width="560">
                                <tr>
                                    <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
                                    
                                        <!--Start Logo-->
                                        <div style="Margin:0px auto;max-width:560px;">
                                            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                                                <tbody>
                                                    <tr>
                                                        <td style="direction:ltr;font-size:0px;padding:0;text-align:center;vertical-align:top;">
                                                            <div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                                                <table background="#B82025" border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="background-color:#B82025;vertical-align:top;padding:5px 15px;">
                                                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
                                                                                    <tr>
                                                                                        <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                                                            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td style="width:50px;">
                                                                                                            <img alt="" src="<?php echo $_SESSION['settings']['SITE_URL'] ?>/contents/img/logo-small-sqm.png" style="border:0;display:block;outline:none;text-decoration:none;width:120px;"/>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--End Logo-->
                                                                                                                        
                                        <!--Start Button Login-->
                                        <div style="background:white;background-color:white;Margin:0px auto;max-width:560px;">
                                            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
                                                <tbody>
                                                    <tr>
                                                        <td style="border:1px solid #540110;;border-top:none;direction:ltr;font-size:0px;padding:30px 20px;text-align:center;vertical-align:top;">
                                                            <div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                                                <table background="#F3EDEE" border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="background-color:#F3EDEE;border-radius:5px;vertical-align:top;padding:20px;">
                                                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
                                                                                    <tr>
                                                                                        <td align="center" style="font-size:0px;padding:0;word-break:break-word;">
                                                                                            <div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:center;color:#540110;">
                                                                                                <?php
																								if(strlen($data['error']))
																								{
																									echo 'Error! '.$data['error'];
																								}
																								else
																								{
																									?>
                                                                                                    Dear <?php echo $result['name'] ?>, you has successful cancel your SQM Property account.
                                                                                                    <?php
																								}
																								?>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--End Button Login-->
                                        
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!--Start Copyright-->
        <div  style="Margin:0px auto;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:30px 40px;text-align:center;vertical-align:top;">
                            <div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                                    <tr>
                                        <td align="left" style="font-size:0px;padding:0;word-break:break-word;">
                                            <div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:12px;font-weight:normal;line-height:22px;text-align:left;color:#540110;">
                                                &copy; <?php echo date('Y') ?> SQM Property. All Rights Reserved.
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--End Copyright-->
        
    </div>
</body>
</html>

