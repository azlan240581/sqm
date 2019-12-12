<?php

use yii\db\Migration;

class m000009_000001_alter_system_email_template extends Migration
{
    /*
    public function up()
    {
    }

    public function down()
    {
    }
    */

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
		//Stop Checking foreign key
		$this->execute("SET foreign_key_checks = 0;");
		
		//Clear Modules
		$this->truncateTable('system_email_template');

		$this->insert('system_email_template',array(
						  'code'=>'STANDARD_EMAIL_TEMPLATE',
						  'name'=>'Standard Email Template',
						  'subject'=>'System Notification',
						  'template'=>'
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
																<table background="#540110" border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
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
																											<img alt="" src="[site_url]/contents/img/logo-small-sqm.png" style="border:0;display:block;outline:none;text-decoration:none;width:120px;"/>
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
										
										<div style="background:white;background-color:white;Margin:0px auto;max-width:560px;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-top:none;direction:ltr;font-size:0px;padding:30px 20px;text-align:center;vertical-align:top;">
															
															<!--Start Repeatable-->
															<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																<table background="#F3EDEE" border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																	<tbody>
																		<tr>
																			<td style="background-color:#F3EDEE;border-radius:5px;vertical-align:top;padding:20px;">
																				<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
																					<tr>
																						<td align="center" style="font-size:0px;padding:0;word-break:break-word;">
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:center;color:#540110;">
																								You have a new message!
																							</div>
																						</td>
																					</tr>
																					<tr>
																						<td align="center" style="font-size:0px;padding:0;word-break:break-word;">
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:center;color:#540110;">
																								&nbsp;
																							</div>
																						</td>
																					</tr>
																					<tr>
																						<td align="center" style="font-size:0px;padding:0;word-break:break-word;">
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:16px;font-weight:normal;line-height:22px;text-align:left;color:#540110;">
																								[details]
																							</div>
																						</td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</div>
															<!--End Repeatable-->
															
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
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
												&copy; [year] SQM Property. All Rights Reserved.
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
</html>
      						  ',
					  ));		
		
		$this->insert('system_email_template',array(
						  'code'=>'MEMBER_INVITATION_TEMPLATE',
						  'name'=>'Member Invitation Template',
						  'subject'=>'[inviter_name] mengirimkan Anda undangan untuk bergabung ke SQM Property',
						  'template'=>'
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
		@media only screen and (max-width:1199px) {
			.container-table {
				width: 90%;
			}
		}
		@media only screen and (min-width:1200px) {
			.container-table {
				width: 70%;
			}
		}
		li {
			padding-bottom: 10px;
		}
		p, ol li {
			font-size: 14px;
			font-weight: 400;
		}
		.title {
			border-bottom: 2px solid #540110;
		}
	</style>

</head>
<body style="background-color:#fbfbfb;">
	<div style="background-color:#fbfbfb;">
		<div style="height:30px;">
			&nbsp;
		</div>

		<div class="container-fluid">
			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:0 20px;text-align:center;vertical-align:top;">
							<table class="container-table" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
									
										<!--Start Logo-->
										<div>
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
																											<img alt="" src="[site_url]/contents/img/logo-small-sqm.png" style="border:0;display:block;outline:none;text-decoration:none;width:120px;"/>
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
										
										<!--Start Header And Description-->
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-bottom:none;border-top:none;direction:ltr;font-size:0px;padding:20px 20px 10px;text-align:center;vertical-align:top;">
															<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																	<tbody>
																		<tr>
																			<td style="vertical-align:top;padding:0;">
																				<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
																					<tr>
																						<td align="left" style="font-size:0px;padding:0;padding-bottom:30px;word-break:break-word;">
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:center;color:#540110;">
																								<p>
																									[inviter_name] ingin mengundang Anda untuk bergabung ke SQM Property
                                                                                                    <br>
																								</p>
                                                                                                <img src="[profile_image]" style="width:200; height:200" width="200" height="200">
                                                                                                <p>
                                                                                                [sqm_id_reference_code_title] : <strong>[sqm_id_reference_code_value]</strong>
                                                                                                <br>
                                                                                                [inviter_group_name] at SQM Property
                                                                                                <br>
                                                                                                <br>
                                                                                                <a href="[site_url_no_cmp]/installation/"><button type="button" style="color:#fff;background-color: #dc3545;border-color:#dc3545;padding:.375rem .75rem;font-size: 1rem;">Bargabung menjadi SQM Associate</button></a>
                                                                                                </p>
                                                                                                <p>
																									Dengan SQM Property, Sekarang Anda bisa berjualan properti dimana pun dan kapan pun. <a href="[site_url_no_cmp]">Pelajari lebih lanjut</a>
																								</p>
                                                                                                <p>
                                                                                                	<br>
																									Anda menerima email undangan. SQM Property akan menggunakan alamat email untuk memberi saran ke anggota lainnya di fitur seperti Orang yang Anda Kenal
																									<br>
                                                                                                    MASUKAN KODE REFERENSI DARI SQM ASSOCIATES LAINNYA YANG ANDA KENAL
																									<br>
                                                                                                    SQM Property adalah nama bisnis terdaftar dari PT Properti Teknologi Internasional
																									<br>
                                                                                                    SQM Propery dan logo SQM Property adalah merek dagang terdaftar yang dimiliki oleh PT Properti Teknologi Internasional
																								</p>
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
										<!--End Header And Description-->
										
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-top:none;direction:ltr;font-size:0px;text-align:center;vertical-align:top;">
															
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<!--Start Copyright-->
		<div  style="Margin:0px auto;">
			<table class="container-table"  align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin: auto;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:30px 40px;text-align:center;vertical-align:top;">
							<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
								<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
									<tr>
										<td align="left" style="font-size:0px;padding:0;word-break:break-word;">
											<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:12px;font-weight:normal;line-height:22px;text-align:left;color:#540110;">
												&copy; [year] SQM Property. All Rights Reserved.
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
    						  ',
					  ));
		
		$this->insert('system_email_template',array(
						  'code'=>'MEMBER_FORGOT_PASSWORD',
						  'name'=>'New Password Request',
						  'subject'=>'Informasi Lupa Password',
						  'template'=>'
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
		@media only screen and (max-width:1199px) {
			.container-table {
				width: 90%;
			}
		}
		@media only screen and (min-width:1200px) {
			.container-table {
				width: 70%;
			}
		}
		li {
			padding-bottom: 10px;
		}
		p, ol li {
			font-size: 14px;
			font-weight: 400;
		}
		.title {
			border-bottom: 2px solid #540110;
		}
	</style>

</head>
<body style="background-color:#fbfbfb;">
	<div style="background-color:#fbfbfb;">
		<div style="height:30px;">
			&nbsp;
		</div>

		<div class="container-fluid">
			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:0 20px;text-align:center;vertical-align:top;">
							<table class="container-table" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
									
										<!--Start Logo-->
										<div>
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
																											<img alt="" src="[site_url]/contents/img/logo-small-sqm.png" style="border:0;display:block;outline:none;text-decoration:none;width:120px;"/>
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
										
										<!--Start Header And Description-->
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-bottom:none;border-top:none;direction:ltr;font-size:0px;padding:50px 20px 10px;text-align:center;vertical-align:top;">
															<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																	<tbody>
																		<tr>
																			<td style="vertical-align:top;padding:0;">
																				<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
																					<tr>
																						<td align="left" style="font-size:0px;padding:0;padding-bottom:30px;word-break:break-word;">
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:center;color:#540110;">
																								<p>
																									Hi [name],<br> <br>
																									Kami menerima permintaan anda untuk mengatur ulang kata sandi Anda. Berikut kata sandi Anda yang baru.
                                                                                                    <br>
																								</p>
																							</div>
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:center;color:#540110;">
                                                                                                <h3>[password]</h3>
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
										<!--End Header And Description-->
										
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-top:none;direction:ltr;font-size:0px;text-align:center;vertical-align:top;">
															
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<!--Start Copyright-->
		<div  style="Margin:0px auto;">
			<table class="container-table"  align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin: auto;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:30px 40px;text-align:center;vertical-align:top;">
							<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
								<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
									<tr>
										<td align="left" style="font-size:0px;padding:0;word-break:break-word;">
											<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:12px;font-weight:normal;line-height:22px;text-align:left;color:#540110;">
												&copy; [year] SQM Property. All Rights Reserved.
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
    						  ',
					  ));
					  
		$this->insert('system_email_template',array(
						  'code'=>'MEMBER_EMAIL_VERIFICATION',
						  'name'=>'Email Verification',
						  'subject'=>'Verifikasi Email SQM Property',
						  'template'=>'
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
		@media only screen and (max-width:1199px) {
			.container-table {
				width: 90%;
			}
		}
		@media only screen and (min-width:1200px) {
			.container-table {
				width: 70%;
			}
		}
		li {
			padding-bottom: 10px;
		}
		p, ol li {
			font-size: 14px;
			font-weight: 400;
		}
		.title {
			border-bottom: 2px solid #540110;
		}
	</style>

</head>
<body style="background-color:#fbfbfb;">
	<div style="background-color:#fbfbfb;">
		<div style="height:30px;">
			&nbsp;
		</div>

		<div class="container-fluid">
			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:0 20px;text-align:center;vertical-align:top;">
							<table class="container-table" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
									
										<!--Start Logo-->
										<div>
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
																											<img alt="" src="[site_url]/contents/img/logo-small-sqm.png" style="border:0;display:block;outline:none;text-decoration:none;width:120px;"/>
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
										
										<!--Start Header And Description-->
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-bottom:none;border-top:none;direction:ltr;font-size:0px;padding:50px 20px 10px;text-align:center;vertical-align:top;">
															<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																	<tbody>
																		<tr>
																			<td style="vertical-align:top;padding:0;">
																				<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
																					<tr>
																						<td align="left" style="font-size:0px;padding:0;padding-bottom:30px;word-break:break-word;">
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:left;color:#540110;">
																								<p>
																									Hi [firstname] [lastname],<br> <br>
																									Proses pendaftaran Anda sebagai SQM Property Associate hampir selesai. Untuk memverifikasi alamat email Anda, masukan kode dibawah pada halaman verifikasi email Anda:
                                                                                                    <br>
																								</p>
																							</div>
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:center;color:#540110;">
                                                                                                <h2>[verification_code]</h2>
                                                                                                <p>
																									Kode ini akan berakhir <strong>setelah tiga jam</strong> email ini terkirim
																								</p>
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
										<!--End Header And Description-->
										
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-top:none;direction:ltr;font-size:0px;text-align:center;vertical-align:top;">
															
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<!--Start Copyright-->
		<div  style="Margin:0px auto;">
			<table class="container-table"  align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin: auto;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:30px 40px;text-align:center;vertical-align:top;">
							<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
								<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
									<tr>
										<td align="left" style="font-size:0px;padding:0;word-break:break-word;">
											<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:12px;font-weight:normal;line-height:22px;text-align:left;color:#540110;">
												&copy; [year] SQM Property. All Rights Reserved.
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
    						  ',
					  ));	
					  				  
		$this->insert('system_email_template',array(
						  'code'=>'PROSPECT_BOOKING_EOI',
						  'name'=>'Prospect Booking EOI',
						  'subject'=>'[buyer_name], [project_name], Acknowledgement of Receipt for NUP with T&C, #[eoi_ref_no]',
						  'template'=>'
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
		div { text-align:justify !important;text-justify:inter-word !important; }
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
		@media only screen and (max-width:1199px) {
			.container-table {
				width: 90%;
			}
		}
		@media only screen and (min-width:1200px) {
			.container-table {
				width: 70%;
			}
		}
		li {
			padding-bottom: 10px;
		}
		p, ol li {
			font-size: 14px;
			font-weight: 400;
		}
		.title {
			border-bottom: 2px solid #540110;
		}
	</style>

</head>
<body style="background-color:#fbfbfb;">
	<div style="background-color:#fbfbfb;">
		<div style="height:30px;">
			&nbsp;
		</div>

		<div class="container-fluid">
			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:0 20px;text-align:center;vertical-align:top;">
							<table class="container-table" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
									
										<!--Start Logo-->
										<div>
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
																											<img alt="" src="[site_url]/contents/img/logo-small-sqm.png" style="border:0;display:block;outline:none;text-decoration:none;width:120px;"/>
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
										
										<!--Start Header And Description-->
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-bottom:none;border-top:none;direction:ltr;font-size:0px;padding:50px 20px 10px;text-align:center;vertical-align:top;">
															<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																	<tbody>
																		<tr>
																			<td style="vertical-align:top;padding:0;">
																				<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
																					<tr>
																						<td align="left" style="font-size:0px;padding:0;padding-bottom:30px;word-break:break-word;">
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:left;color:#540110;">
																								<p>
																									Pelanggan yang terhomat,<br> <br>
																									Terima kasih atas minat Anda terhadap [project_name]. <br> <br>
																									Untuk memproses pendaftaran NUP Anda, mohon nyatakan ketersediaan Anda dalam mengikuti syarat dan ketentuan di bawah dengan membalas email ini. Semua pembayaran yang diperlukan harus dilakukan melalui akun yang kami lampirkan di bawah.  <br> <br>
																									<b class="title">SYARAT DAN KETENTUAN</b> <br>
																								</p>
																									<ol>
																										<li>Pendaftar menunjuk SQM sebagai agen tunggal untuk pendaftaran dan pembelian properti di atas. </li>
																										<li>Pendaftaran hanya berlaku untuk pendaftaran dan pembelian satu unit. </li>
																										<li>Pendaftar wajib membayar sebesar [booking_eoi_amount] untuk pembelian unit yang dipilih ke SQM melalui transfer bank, debit, dan/atau kartu kredit. </li>
																										<li>Pembayaran dilakukan ke rekening bank resmi SQM yang sudah ditentukan di atas. Demi identifikasi yang lebih mudah, pembayaran juga harus disertakan dengan keterangan berikut: </li>
																										<li>SQM tidak bertanggung jawab atas tiap proses pembayaran yang gagal. </li>
																										<li>Semua biaya dari bank yang ada berdasarkan hukum dan peraturan yang berlaku, baik itu dari bank pendaftar (bank pembayar), bank SQM (bank penerima), maupun bank yang berkoresponden dengan proses pembayaran NUP, akan jadi tanggung jawab pendaftar.</li>
																									
																										<li>Pendaftar tidak berhak mendapatkan refund atau pengembalian uang jika melakukan pembatalan. Semua pembayaran yang terjadi sebelum pembatalan dinyatakan hangus (terkecuali di syarat & ketentuan yang ditetapkan developer). </li>
																										<li>Jika proses pendaftaran gagal, pendaftar akan menerima refund pembayaran dari developer dengan jumlah yang sudah dikurangi biaya bank. Jika pendaftaran ternyata berhasil dan pendaftar melanjutkan proses pembelian, pembayaran yang terjadi sebelumnya akan digunakan untuk pembayaran 
																												yang menjadi bagian dari harga pembelian properti.</li>
																										<li>Pembayaran yang sudah dilakukan oleh pendaftar akan ditransfer oleh SQM ke developer yang bersangkutan. Apabila terjadi proses pengembalian uang, proses akan dilakukan oleh developer langsung ke pendaftar. </li>
																										<li>Pendaftar dilarang memindahtangankan NUP ini ke pihak lain tanpa persetujuan tertulis dari SQM/developer yang bersangkutan. Jika proses pindahtangan diajukan langsung antara pendaftar dan developer, maka pendaftar wajib memberi tahu pihak SQM.</li>
																										<li>Ketika menerima undangan dari SQM/developer, pendaftar akan diminta menandatangani Surat Perjanjian/Perjanjian Pengikatan Jual Beli (SP/PPJB) untuk menentukan unit properti yang dipilih serta pembayaran untuk properti tersebut.</li>
																										<li>Jika pendaftar tidak menandatangani Surat Perjanjian/Perjanjian Peingikatan Jual Beli (SP/PPJB), maka NUP otomatis dibatalkan dan pendaftar tidak berhak mendapatkan pengembalian uang atas pembayaran NUP. </li>
																									</ol>
																								<p>
																									Terima Kasih dan Hormat Kami, <br> <br>
																									<b>SQM PROPERTY</b> <br>
																									PT PROPERTI TEKNOLOGI INTERNASIONAL
																								</p>
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
										<!--End Header And Description-->
										
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-top:none;direction:ltr;font-size:0px;text-align:center;vertical-align:top;">
															
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<!--Start Copyright-->
		<div  style="Margin:0px auto;">
			<table class="container-table"  align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin: auto;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:30px 40px;text-align:center;vertical-align:top;">
							<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
								<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
									<tr>
										<td align="left" style="font-size:0px;padding:0;word-break:break-word;">
											<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:12px;font-weight:normal;line-height:22px;text-align:left;color:#540110;">
												&copy; [year] SQM Property. All Rights Reserved.
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
    						  ',
					  ));					  
		
		$this->insert('system_email_template',array(
						  'code'=>'PROSPECT_BOOKING_EOI_APPROVAL',
						  'name'=>'Prospect Booking EOI Approval',
						  'subject'=>'[buyer_name], [project_name], Confirmation of Payment Received for NUP with T&C, #[eoi_ref_no]',
						  'template'=>'
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
		div { text-align:justify !important;text-justify:inter-word !important; }
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
		@media only screen and (max-width:1199px) {
			.container-table {
				width: 90%;
			}
		}
		@media only screen and (min-width:1200px) {
			.container-table {
				width: 70%;
			}
		}
		li {
			padding-bottom: 10px;
		}
		p, ol li {
			font-size: 14px;
			font-weight: 400;
		}
		.title {
			border-bottom: 2px solid #540110;
		}
	</style>

</head>
<body style="background-color:#fbfbfb;">
	<div style="background-color:#fbfbfb;">
		<div style="height:30px;">
			&nbsp;
		</div>

		<div class="container-fluid">
			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:0 20px;text-align:center;vertical-align:top;">
							<table class="container-table" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
									
										<!--Start Logo-->
										<div>
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
																											<img alt="" src="[site_url]/contents/img/logo-small-sqm.png" style="border:0;display:block;outline:none;text-decoration:none;width:120px;"/>
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
										
										<!--Start Header And Description-->
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-bottom:none;border-top:none;direction:ltr;font-size:0px;padding:50px 20px 10px;text-align:center;vertical-align:top;">
															<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																	<tbody>
																		<tr>
																			<td style="vertical-align:top;padding:0;">
																				<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
																					<tr>
																						<td align="left" style="font-size:0px;padding:0;padding-bottom:30px;word-break:break-word;">
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:left;color:#540110;">
																								<p>
																									Pelanggan yang terhomat,<br> <br>
																									Selamat! Pendaftaran NUP untuk proyek [project_name] sudah diterima. Account manager kami akan menghubungi Anda saat tanggal peresmian.<br> <br>
																									Konfirmasi ketersediaan Anda mengikuti syarat dan ketentuan NUP dengan membalas email yang kami kirimkan sebelumnya (jika belum). <br> <br>
																									Jika kami tidak mendapatkan balasan dalam waktu 24 jam, maka kami menganggap Anda setuju dan membebaskan SQM Property dari segala tanggung jawab atas biaya, klaim, kerusakan, dan  proses hukum yang terjadi terkait NUP yang diajukan. <br><br>
																									
																									Terima Kasih dan Hormat Kami, <br> <br>
																									<b>SQM PROPERTY</b> <br>
																									PT PROPERTI TEKNOLOGI INTERNASIONAL
																								</p>
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
										<!--End Header And Description-->
										
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-top:none;direction:ltr;font-size:0px;text-align:center;vertical-align:top;">
															
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<!--Start Copyright-->
		<div  style="Margin:0px auto;">
			<table class="container-table"  align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin: auto;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:30px 40px;text-align:center;vertical-align:top;">
							<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
								<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
									<tr>
										<td align="left" style="font-size:0px;padding:0;word-break:break-word;">
											<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:12px;font-weight:normal;line-height:22px;text-align:left;color:#540110;">
												&copy; [year] SQM Property. All Rights Reserved.
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
    						  ',
					  ));					  
		
		$this->insert('system_email_template',array(
						  'code'=>'PROSPECT_BOOKING',
						  'name'=>'Prospect Booking',
						  'subject'=>'[buyer_name], [project_name], [product_unit], Acknowledgement of Receipt for OTP with Property Details and T&C, #[booking_ref_no]',
						  'template'=>'
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
		div { text-align:justify !important;text-justify:inter-word !important; }
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
		@media only screen and (max-width:1199px) {
			.container-table {
				width: 90%;
			}
		}
		@media only screen and (min-width:1200px) {
			.container-table {
				width: 70%;
			}
		}
		li {
			padding-bottom: 10px;
		}
		p, ol li {
			font-size: 14px;
			font-weight: 400;
		}
	</style>

</head>
<body style="background-color:#fbfbfb;">
	<div style="background-color:#fbfbfb;">
		<div style="height:30px;">
			&nbsp;
		</div>

		<div class="container-fluid">
			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:0 20px;text-align:center;vertical-align:top;">
							<table class="container-table" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
									
										<!--Start Logo-->
										<div>
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
																											<img alt="" src="[site_url]/contents/img/logo-small-sqm.png" style="border:0;display:block;outline:none;text-decoration:none;width:120px;"/>
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
										
										<!--Start Header And Description-->
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-bottom:none;border-top:none;direction:ltr;font-size:0px;padding:50px 20px 10px;text-align:center;vertical-align:top;">
															<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																	<tbody>
																		<tr>
																			<td style="vertical-align:top;padding:0;">
																				<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
																					<tr>
																						<td align="left" style="font-size:0px;padding:0;padding-bottom:30px;word-break:break-word;">
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:left;color:#540110;">
																								<p>
																									Pelanggan yang terhomat,<br> <br>
																									Terima kasih sudah memilih SQM sebagai tempat untuk membeli properti idaman Anda. <br> <br>
																									Untuk memproses Offer to Purchase (OTP), masukkan detail properti dan konfirmasi ketersediaan Anda mengikuti syarat dan ketentuan dengan membalas emal ini. <br> <br>
																									A.  Detail Unit Properti <br> <br>
																									Pembeli dengan ini mengirimkan penawarannya untuk membeli untuk Unit sebagaimana dijelaskan di bawah ini: <br> <br>
																								 	Nama Developer 	: <b>[developer_name]</b> <br>
																									Nama Proyek	: <b>[project_name]</b> <br>
																									Cluster/Tower	: <b>[project_product_name]</b>     Unit: <b>[product_unit]</b>      Tipe:  <b>[project_product_unit_type]</b>  <br>
																									Luas (Bangunan / Tanah)          :  <b>[building_size_sm]</b> m2 (bangunan)   <b>[land_size_sm]</b>  m2 (tanah) <br>
																									Harga (termasuk PPN)	:	IDR <b>[total_product_unit_price]</b> <br>
																									Biaya Pemesanan	:	IDR <b>[booking_amount]</b> <br>
																										(paid via bank transfer, debit, and/or payment via credit card) <br><br>
																									Dengan ini pembeli mengajukan penawarannya untuk membeli unit yang disebutkan di bawah: <br> <br>
																									B.  SYARAT DAN KETENTUAN <br>
																								</p>
																									<ol>
																										<li>Pembeli menunjuk SQM sebagai agen tunggal untuk Offer to Purchase (OTP) properti di atas.</li>
																										<li>Setelah diterima, tanpa permintaan tertulis dari pembeli dan persetujuan dari SQM/Developer, OTP tidak bisa lagi diubah.</li>
																										<li>Pembeli mengetahui dan setuju bahwa pembangunan unit harus mengikuti kebijakan dan/atau peraturan dari developer, termasuk amandemen yang akan muncul atau diminta oleh pihak yang pihak berwajib.</li>
																										<li>OTP ini mengikuti aturan persetujuan resmi dari developer yang bersangkutan dan valid selama 14 hari sejak OTP ini 
																											diterima/disetujui. Jika pihak pembeli gagal menyediakan dokumen yang diperlukan termasuk tapi tidak terbatas pada Surat Perjanjian/Perjanjian Pengikatan Jual Beli (SP/PPJB) dan pembayaran dalam periode 14 hari, maka status persetujuan dianggap batal mengikuti kebijakan dari developer. </li>
																										<li>Formulir ini akan menggantikan semua persetujuan dan pemahaman terkait baik lisan maupun tertulis yang sudah ada sebelumnya.</li>
																										<li>Apabila terjadi perselisihan, keputusan SQM/developer bersifat final dan absolut.</li>
																									</ol>
																								<p>
																									Terima Kasih dan Hormat Kami, <br> <br>
																									<b>SQM PROPERTY</b> <br>
																									PT PROPERTI TEKNOLOGI INTERNASIONAL
																								</p>
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
										<!--End Header And Description-->
										
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-top:none;direction:ltr;font-size:0px;text-align:center;vertical-align:top;">
															
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<!--Start Copyright-->
		<div  style="Margin:0px auto;">
			<table class="container-table"  align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin: auto;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:30px 40px;text-align:center;vertical-align:top;">
							<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
								<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
									<tr>
										<td align="left" style="font-size:0px;padding:0;word-break:break-word;">
											<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:12px;font-weight:normal;line-height:22px;text-align:left;color:#540110;">
												&copy; [year] SQM Property. All Rights Reserved.
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
    						  ',
					  ));					  
		
		$this->insert('system_email_template',array(
						  'code'=>'PROSPECT_BOOKING_APPROVAL',
						  'name'=>'Prospect Booking Approval',
						  'subject'=>'[buyer_name], [project_name], [product_unit], Confirmation of OTP with Property Details and Terms & Conditions, #[booking_ref_no]',
						  'template'=>'
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
		div { text-align:justify !important;text-justify:inter-word !important; }
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
		@media only screen and (max-width:1199px) {
			.container-table {
				width: 90%;
			}
		}
		@media only screen and (min-width:1200px) {
			.container-table {
				width: 70%;
			}
		}
		li {
			padding-bottom: 10px;
		}
		p, ol li {
			font-size: 14px;
			font-weight: 400;
		}
		.title {
			border-bottom: 2px solid #540110;
		}
	</style>

</head>
<body style="background-color:#fbfbfb;">
	<div style="background-color:#fbfbfb;">
		<div style="height:30px;">
			&nbsp;
		</div>

		<div class="container-fluid">
			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:0 20px;text-align:center;vertical-align:top;">
							<table class="container-table" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
									
										<!--Start Logo-->
										<div>
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
																											<img alt="" src="[site_url]/contents/img/logo-small-sqm.png" style="border:0;display:block;outline:none;text-decoration:none;width:120px;"/>
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
										
										<!--Start Header And Description-->
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-bottom:none;border-top:none;direction:ltr;font-size:0px;padding:50px 20px 10px;text-align:center;vertical-align:top;">
															<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																	<tbody>
																		<tr>
																			<td style="vertical-align:top;padding:0;">
																				<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
																					<tr>
																						<td align="left" style="font-size:0px;padding:0;padding-bottom:30px;word-break:break-word;">
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:left;color:#540110;">
																								<p>
																									Pelanggan yang terhomat,
                                                                                                    <br><br>
																									Selamat! Offer to Purchase (OTP) Anda diterima oleh developer proyek [project_name]. Account manager kami, [dedicated_agent_name] akan segera menghubungi dan berkoordinasi dengan Anda untuk penandatangan dokumen terkait.
                                                                                                    <br> <br>
																									Konfirmasi ketersediaan Anda mengikuti syarat dan ketentuan OTP yang berlaku dengan membalas email yang kami kirimkan sebelumnya (jika belum).
                                                                                                    <br> <br>
																									Jika kami tidak mendapatkan balasan dalam waktu 24 jam, maka kami menganggap Anda setuju dan membebaskan SQM Property dari segala tanggung jawab atas biaya, klaim, kerusakan, dan  proses hukum yang terjadi terkait hal ini. 
                                                                                                    <br><br>
																									Kami juga mengingatkan Anda untuk menyelesaikan semua proses pembayaran dan melengkapi dokumen yang diperlukan dalam waktu 14 hari dari tanggal yang tertera di email ini. Jika terjadi kelalaian dalam melengkapi dokumen penting termasuk tapi tidak terbatas pada Surat Perjanjian/Perjanjian Pengikat Jual beli (SP/PPJB) dan pembayaran dalam waktu yang ditentukan, maka persetujuan dibatalkan sesuai dengan kebijakan dari developer.
                                                                                                    <br><br>
																									
																									Terima Kasih dan Hormat Kami,
                                                                                                    <br> <br>
																									<b>SQM PROPERTY</b>
                                                                                                    <br>
																									PT PROPERTI TEKNOLOGI INTERNASIONAL
																								</p>
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
										<!--End Header And Description-->
										
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-top:none;direction:ltr;font-size:0px;text-align:center;vertical-align:top;">
															
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<!--Start Copyright-->
		<div  style="Margin:0px auto;">
			<table class="container-table"  align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin: auto;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:30px 40px;text-align:center;vertical-align:top;">
							<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
								<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
									<tr>
										<td align="left" style="font-size:0px;padding:0;word-break:break-word;">
											<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:12px;font-weight:normal;line-height:22px;text-align:left;color:#540110;">
												&copy; [year] SQM Property. All Rights Reserved.
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
    						  ',
					  ));					  
		
		$this->insert('system_email_template',array(
						  'code'=>'PROSPECT_CANCELLATION_EOI',
						  'name'=>'Prospect Cancellation EOI',
						  'subject'=>'[buyer_name], [project_name], Cancellation of Purchase, #[cancel_ref_no]',
						  'template'=>'
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
		div { text-align:justify !important;text-justify:inter-word !important; }
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
		@media only screen and (max-width:1199px) {
			.container-table {
				width: 90%;
			}
		}
		@media only screen and (min-width:1200px) {
			.container-table {
				width: 70%;
			}
		}
		li {
			padding-bottom: 10px;
		}
		p, ol li {
			font-size: 14px;
			font-weight: 400;
		}
		.title {
			border-bottom: 2px solid #540110;
		}
	</style>

</head>
<body style="background-color:#fbfbfb;">
	<div style="background-color:#fbfbfb;">
		<div style="height:30px;">
			&nbsp;
		</div>

		<div class="container-fluid">
			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:0 20px;text-align:center;vertical-align:top;">
							<table class="container-table" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
									
										<!--Start Logo-->
										<div>
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
																											<img alt="" src="[site_url]/contents/img/logo-small-sqm.png" style="border:0;display:block;outline:none;text-decoration:none;width:120px;"/>
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
										
										<!--Start Header And Description-->
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-bottom:none;border-top:none;direction:ltr;font-size:0px;padding:50px 20px 10px;text-align:center;vertical-align:top;">
															<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																	<tbody>
																		<tr>
																			<td style="vertical-align:top;padding:0;">
																				<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
																					<tr>
																						<td align="left" style="font-size:0px;padding:0;padding-bottom:30px;word-break:break-word;">
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:left;color:#540110;">
																								<p>
																									Pelanggan yang terhomat,
                                                                                                    <br><br>
																									Kami menerima pemberitahuan megenai pengajuan Anda dalam hal pembatalan pembelian untuk properti yang disebutkan diatas dan sistem akan segera melakukan proses pembatalan tersebut sesuai dengan pengajuan Anda.
                                                                                                    <br> <br>
																									Jika Anda tidak pernah mengajukan pembatalan pembelian properti diatas , mohon untuk segera membalas email kami dalam waktu 48 jam dari tanggal email ini dikirimkan ke Anda. Jika tidak ada balasan atas email ini atau kami tidak menerima informasi lanjutan dari anda, maka Anda dianggap setuju untuk melanjutkan proses pembatalan pembelian properti yang bersangkutan dan sistem akan secara otomatis memproses pengajuan pembatalan Anda.
                                                                                                    <br> <br>
																									
																									Terima Kasih dan Hormat Kami,
                                                                                                    <br> <br>
																									<b>SQM PROPERTY</b>
                                                                                                    <br>
																									PT PROPERTI TEKNOLOGI INTERNASIONAL
																								</p>
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
										<!--End Header And Description-->
										
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-top:none;direction:ltr;font-size:0px;text-align:center;vertical-align:top;">
															
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<!--Start Copyright-->
		<div  style="Margin:0px auto;">
			<table class="container-table"  align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin: auto;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:30px 40px;text-align:center;vertical-align:top;">
							<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
								<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
									<tr>
										<td align="left" style="font-size:0px;padding:0;word-break:break-word;">
											<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:12px;font-weight:normal;line-height:22px;text-align:left;color:#540110;">
												&copy; [year] SQM Property. All Rights Reserved.
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
    						  ',
					  ));					  
		
		$this->insert('system_email_template',array(
						  'code'=>'PROSPECT_CANCELLATION_BOOKING',
						  'name'=>'Prospect Cancellation Booking',
						  'subject'=>'[buyer_name], [project_name], [product_unit], Cancellation of Purchase, #[cancel_ref_no]',
						  'template'=>'
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
		div { text-align:justify !important;text-justify:inter-word !important; }
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
		@media only screen and (max-width:1199px) {
			.container-table {
				width: 90%;
			}
		}
		@media only screen and (min-width:1200px) {
			.container-table {
				width: 70%;
			}
		}
		li {
			padding-bottom: 10px;
		}
		p, ol li {
			font-size: 14px;
			font-weight: 400;
		}
		.title {
			border-bottom: 2px solid #540110;
		}
	</style>

</head>
<body style="background-color:#fbfbfb;">
	<div style="background-color:#fbfbfb;">
		<div style="height:30px;">
			&nbsp;
		</div>

		<div class="container-fluid">
			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:0 20px;text-align:center;vertical-align:top;">
							<table class="container-table" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
									
										<!--Start Logo-->
										<div>
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
																											<img alt="" src="[site_url]/contents/img/logo-small-sqm.png" style="border:0;display:block;outline:none;text-decoration:none;width:120px;"/>
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
										
										<!--Start Header And Description-->
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-bottom:none;border-top:none;direction:ltr;font-size:0px;padding:50px 20px 10px;text-align:center;vertical-align:top;">
															<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																	<tbody>
																		<tr>
																			<td style="vertical-align:top;padding:0;">
																				<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
																					<tr>
																						<td align="left" style="font-size:0px;padding:0;padding-bottom:30px;word-break:break-word;">
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:left;color:#540110;">
																								<p>
																									Pelanggan yang terhomat,
                                                                                                    <br><br>
																									Kami menerima pemberitahuan megenai pengajuan Anda dalam hal pembatalan pembelian untuk properti yang disebutkan diatas dan sistem akan segera melakukan proses pembatalan tersebut sesuai dengan pengajuan Anda.
                                                                                                    <br> <br>
																									Jika Anda tidak pernah mengajukan pembatalan pembelian properti diatas , mohon untuk segera membalas email kami dalam waktu 48 jam dari tanggal email ini dikirimkan ke Anda. Jika tidak ada balasan atas email ini atau kami tidak menerima informasi lanjutan dari anda, maka Anda dianggap setuju untuk melanjutkan proses pembatalan pembelian properti yang bersangkutan dan sistem akan secara otomatis memproses pengajuan pembatalan Anda.
                                                                                                    <br> <br>
																									
																									Terima Kasih dan Hormat Kami,
                                                                                                    <br> <br>
																									<b>SQM PROPERTY</b>
                                                                                                    <br>
																									PT PROPERTI TEKNOLOGI INTERNASIONAL
																								</p>
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
										<!--End Header And Description-->
										
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-top:none;direction:ltr;font-size:0px;text-align:center;vertical-align:top;">
															
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<!--Start Copyright-->
		<div  style="Margin:0px auto;">
			<table class="container-table"  align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin: auto;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:30px 40px;text-align:center;vertical-align:top;">
							<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
								<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
									<tr>
										<td align="left" style="font-size:0px;padding:0;word-break:break-word;">
											<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:12px;font-weight:normal;line-height:22px;text-align:left;color:#540110;">
												&copy; [year] SQM Property. All Rights Reserved.
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
    						  ',
					  ));					  
		
		$this->insert('system_email_template',array(
						  'code'=>'PROSPECT_CANCELLATION',
						  'name'=>'Prospect Cancellation',
						  'subject'=>'[buyer_name], [project_name], [product_unit], Cancellation of Purchase, #[cancel_ref_no]',
						  'template'=>'
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
		div { text-align:justify !important;text-justify:inter-word !important; }
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
		@media only screen and (max-width:1199px) {
			.container-table {
				width: 90%;
			}
		}
		@media only screen and (min-width:1200px) {
			.container-table {
				width: 70%;
			}
		}
		li {
			padding-bottom: 10px;
		}
		p, ol li {
			font-size: 14px;
			font-weight: 400;
		}
		.title {
			border-bottom: 2px solid #540110;
		}
	</style>

</head>
<body style="background-color:#fbfbfb;">
	<div style="background-color:#fbfbfb;">
		<div style="height:30px;">
			&nbsp;
		</div>

		<div class="container-fluid">
			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:0 20px;text-align:center;vertical-align:top;">
							<table class="container-table" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
									
										<!--Start Logo-->
										<div>
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
																											<img alt="" src="[site_url]/contents/img/logo-small-sqm.png" style="border:0;display:block;outline:none;text-decoration:none;width:120px;"/>
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
										
										<!--Start Header And Description-->
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-bottom:none;border-top:none;direction:ltr;font-size:0px;padding:50px 20px 10px;text-align:center;vertical-align:top;">
															<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																	<tbody>
																		<tr>
																			<td style="vertical-align:top;padding:0;">
																				<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
																					<tr>
																						<td align="left" style="font-size:0px;padding:0;padding-bottom:30px;word-break:break-word;">
																							<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:left;color:#540110;">
																								<p>
																									Pelanggan yang terhomat,
                                                                                                    <br><br>
																									Kami menerima pemberitahuan megenai pengajuan Anda dalam hal pembatalan pembelian untuk properti yang disebutkan diatas dan sistem akan segera melakukan proses pembatalan tersebut sesuai dengan pengajuan Anda.
                                                                                                    <br> <br>
																									Jika Anda tidak pernah mengajukan pembatalan pembelian properti diatas , mohon untuk segera membalas email kami dalam waktu 48 jam dari tanggal email ini dikirimkan ke Anda. Jika tidak ada balasan atas email ini atau kami tidak menerima informasi lanjutan dari anda, maka Anda dianggap setuju untuk melanjutkan proses pembatalan pembelian properti yang bersangkutan dan sistem akan secara otomatis memproses pengajuan pembatalan Anda.
                                                                                                    <br> <br>
																									
																									Terima Kasih dan Hormat Kami,
                                                                                                    <br> <br>
																									<b>SQM PROPERTY</b>
                                                                                                    <br>
																									PT PROPERTI TEKNOLOGI INTERNASIONAL
																								</p>
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
										<!--End Header And Description-->
										
										<div style="background:white;background-color:white;Margin:0px auto;">
											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
												<tbody>
													<tr>
														<td style="border:1px solid #540110;border-top:none;direction:ltr;font-size:0px;text-align:center;vertical-align:top;">
															
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<!--Start Copyright-->
		<div  style="Margin:0px auto;">
			<table class="container-table"  align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin: auto;">
				<tbody>
					<tr>
						<td style="direction:ltr;font-size:0px;padding:30px 40px;text-align:center;vertical-align:top;">
							<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
								<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
									<tr>
										<td align="left" style="font-size:0px;padding:0;word-break:break-word;">
											<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:12px;font-weight:normal;line-height:22px;text-align:left;color:#540110;">
												&copy; [year] SQM Property. All Rights Reserved.
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
    						  ',
					  ));					  
		
		//Start Checking foreign key
		$this->execute("SET foreign_key_checks = 1;");
	}

    public function safeDown()
    {
    }
}
