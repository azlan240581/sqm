<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

/*
$this->title = 'My Profiles: ' . $modelUser->name;
$this->params['breadcrumbs'][] = 'User Manager';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelUser->username, 'url' => ['view', 'id' => $modelUser->id]];
$this->params['breadcrumbs'][] = 'Update';
*/

$this->title = 'Profile';
$this->params['breadcrumbs'][] = 'User Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/users/profile']];
?>
<div class="users-update">    
    <?= $this->render('_formProfile', [
        'modelUser' => $modelUser,
		'avatar' => $avatar,
		'countryList' => $countryList,
		'countryCodeList' => $countryCodeList,
    ]) ?>

</div>
