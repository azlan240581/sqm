<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Collaterals */

$this->title = 'Update Collateral : ' . $model->title;
$this->params['breadcrumbs'][] = 'Collaterals Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/collaterals']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="collaterals-update">

    <?= $this->render('_form', [
		'model' => $model,
		'modelCollateralsMedias' => $modelCollateralsMedias,
		'projectList' => $projectList,
		'collateralMediaTypeList' => $collateralMediaTypeList,
    ]) ?>

</div>
