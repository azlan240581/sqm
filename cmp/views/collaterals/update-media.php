<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CollateralsMedias */

$this->title = $modelCollaterals->title.' : Update Collaterals Media : ' . $modelCollateralsMedias->media_title;
$this->params['breadcrumbs'][] = 'Collaterals Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/collaterals']];
$this->params['breadcrumbs'][] = ['label' => $modelCollaterals->title, 'url' => ['view', 'id' => $modelCollaterals->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="collaterals-medias-update">

    <?= $this->render('_formMedia', [
			'modelCollaterals' => $modelCollaterals,
			'modelCollateralsMedias' => $modelCollateralsMedias,
			'collateralMediaTypeList' => $collateralMediaTypeList,
    ]) ?>

</div>
