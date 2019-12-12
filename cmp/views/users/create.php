<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = 'User Management';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['/users']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">
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
