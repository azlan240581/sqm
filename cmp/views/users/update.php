<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Update User : ' . $modelUser->name;
$this->params['breadcrumbs'][] = 'User Management';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['/users']];
$this->params['breadcrumbs'][] = ['label' => $modelUser->name, 'url' => ['view', 'id' => $modelUser->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="users-update">
    <?= $this->render('_form', [
		'modelUser' => $modelUser,
		'modelUserGroups' => $modelUserGroups,
		'modelUserPosition' => $modelUserPosition,
		'groupAccess' => $groupAccess,
		'avatar' => $avatar,
		'countryList' => $countryList,
		'positionList' => $positionList,
		'countryCodeList' => $countryCodeList,
		'bankList' => $bankList,
		'modelUserBank' => $modelUserBank,
		'developerList' => $developerList,
		'modelUserDeveloper' => $modelUserDeveloper,
		'fintechList' => $fintechList,
		'modelUserFintech' => $modelUserFintech,
		'modelAssistantUpline' => $modelAssistantUpline,
		'uplineList' => $uplineList,
		'projectObj' => $projectObj,
		'modelProjectAgents' => $modelProjectAgents,
		'modelUserAssociateBrokerDetails' => $modelUserAssociateBrokerDetails,
    ]) ?>

</div>
