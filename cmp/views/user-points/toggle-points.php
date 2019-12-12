<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserPoints */

$this->title = 'Add / Deduct Associate Points : ' . $model->associateName->name;
$this->params['breadcrumbs'][] = 'Points Management';
$this->params['breadcrumbs'][] = ['label' => 'Associate Points', 'url' => ['/user-points']];
$this->params['breadcrumbs'][] = ['label' => $model->associateName->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-points-update">

    <?= $this->render('_formTogglePoints', [
		'model' => $model,
		'modelLogUserPoints' => $modelLogUserPoints,
    ]) ?>

</div>
