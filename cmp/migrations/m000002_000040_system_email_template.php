<?php

use yii\db\Migration;

class m000002_000040_system_email_template extends Migration
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
		$this->createTable("system_email_template", array(
		"id" => "pk",
		"code" => "varchar(100) NOT NULL",
		"name" => "varchar(100) NOT NULL",
		"description" => "varchar(255) DEFAULT NULL",
		"subject" => "varchar(255) NOT NULL",
		"template" => "text DEFAULT NULL",
		), "ENGINE=InnoDB");
		
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
						  'subject'=>'Welcome to Square Meter Property',
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
																		<div style="background:white;background-color:white;Margin:0px auto;max-width:560px;">
																			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
																				<tbody>
																					<tr>
																						<td style="border:1px solid #540110;;border-bottom:none;border-top:none;direction:ltr;font-size:0px;padding:60px 20px 30px;text-align:center;vertical-align:top;">
																							<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																								<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																									<tbody>
																										<tr>
																											<td style="vertical-align:top;padding:0;">
																												<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
																													<tr>
																														<td align="left" style="font-size:0px;padding:0;padding-bottom:30px;word-break:break-word;">
																															<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:center;color:#540110;">
																																[subject]
																															</div>
																														</td>
																													</tr>
																													<tr>
																														<td align="left" style="font-size:0px;padding:0;word-break:break-word;">
																															<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:16px;font-weight:normal;line-height:22px;text-align:center;color:#540110;">
																																[description]
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
																		
																		<div style="background:white;background-color:white;Margin:0px auto;max-width:560px;">
																			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
																				<tbody>
																					<tr>
																						<td style="border:1px solid #540110;;border-bottom:none;border-top:none;direction:ltr;font-size:0px;padding:30px 20px;text-align:center;vertical-align:top;">
																							
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
																																Username
																															</div>
																														</td>
																													</tr>
																													<tr>
																														<td align="center" style="font-size:0px;padding:0;word-break:break-word;">
																															<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:16px;font-weight:normal;line-height:22px;text-align:center;color:#540110;">
																																[username]
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
																																Temporary Password
																															</div>
																														</td>
																													</tr>
																													<tr>
																														<td align="center" style="font-size:0px;padding:0;word-break:break-word;">
																															<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:16px;font-weight:normal;line-height:22px;text-align:center;color:#540110;">
																																[password]
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
																		
																		<!--Start Header And Description-->
																		<div style="background:white;background-color:white;Margin:0px auto;max-width:560px;">
																			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
																				<tbody>
																					<tr>
																						<td style="border:1px solid #540110;;border-bottom:none;border-top:none;direction:ltr;font-size:0px;padding:0px 20px 0px;text-align:center;vertical-align:top;">
																							<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																								<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																									<tbody>
																										<tr>
																											<td style="vertical-align:top;padding:0;">
																												<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
																													<tr>
																														<td align="left" style="font-size:0px;padding:0;word-break:break-word;">
																															<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:16px;font-weight:normal;line-height:22px;text-align:center;color:#540110;">
																																You have been invited by [inviter_name] ([group_name]) to become a member under agent [agent_name]. Click <a href="[site_url]/server/api/member-cancel-account/?uuid=[member_uuid]&email=[member_email]&contact_number=[member_contact_number]">here</a> if you wish to cancel or delete you account.
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
																		
																		<!--Start Button Login-->
																		<div style="background:white;background-color:white;Margin:0px auto;max-width:560px;">
																			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
																				<tbody>
																					<tr>
																						<td style="border:1px solid #540110;;border-top:none;direction:ltr;font-size:0px;padding:30px 20px;text-align:center;vertical-align:top;">
																							<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																								<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
																									<tr>
																										<td align="center" style="font-size:0px;padding:0;padding-bottom:15px;word-break:break-word;">
																											<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:16px;font-weight:normal;line-height:22px;text-align:center;color:#540110;">
																												You may go to the installation process by clicking the button below.
																											</div>
																										</td>
																									</tr>
																									<tr>
																										<td align="center" vertical-align="middle" style="font-size:0px;padding:0;word-break:break-word;">
																											<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;">
																												<tr>
																													<td align="center" bgcolor="#540110" role="presentation" style="border:none;border-radius:3px;cursor:auto;padding:10px 25px;" valign="middle">
																														<p style="background:#540110;color:white;font-family:Gotham, Helvetica, Arial, sans-serif;font-size:16px;font-weight:normal;line-height:22px;Margin:0;text-decoration:none;text-transform:none;">
																															<a href="[site_url]/installation/">Install Now</a>
																														</p>
																													</td>
																												</tr>
																											</table>
																										</td>
																									</tr>
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
						  'subject'=>'New Square Meter Property Password',
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
																		<div style="background:white;background-color:white;Margin:0px auto;max-width:560px;">
																			<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
																				<tbody>
																					<tr>
																						<td style="border:1px solid #540110;border-bottom:none;border-top:none;direction:ltr;font-size:0px;padding:60px 20px 30px;text-align:center;vertical-align:top;">
																							<div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
																								<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																									<tbody>
																										<tr>
																											<td style="vertical-align:top;padding:0;">
																												<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
																													<tr>
																														<td align="left" style="font-size:0px;padding:0;padding-bottom:30px;word-break:break-word;">
																															<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:20px;font-weight:bold;line-height:22px;text-align:left;color:#540110;">
																																Hi [name],
																															</div>
																														</td>
																													</tr>
																													<tr>
																														<td align="left" style="font-size:0px;padding:0;word-break:break-word;">
																															<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:16px;font-weight:normal;line-height:22px;text-align:left;color:#540110;">
																																We received a request to reset your Square Meter Property password. Below is your newly generated password.
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
																																Temporary Password
																															</div>
																														</td>
																													</tr>
																													<tr>
																														<td align="center" style="font-size:0px;padding:0;word-break:break-word;">
																															<div style="font-family:Gotham, Helvetica, Arial, sans-serif;font-size:16px;font-weight:normal;line-height:22px;text-align:center;color:#540110;">
																																[password]
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
    						  ',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('system_email_template');
		$this->dropTable('system_email_template');
    }
}
