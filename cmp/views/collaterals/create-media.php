<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CollateralsMedias */

$this->title = $modelCollaterals->title.' : Create Collaterals Medias';
$this->params['breadcrumbs'][] = 'Collaterals Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/collaterals']];
$this->params['breadcrumbs'][] = ['label' => $modelCollaterals->title, 'url' => ['view', 'id' => $modelCollaterals->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collaterals-medias-create">

    <?= $this->render('_formMedia', [
			'modelCollaterals' => $modelCollaterals,
			'modelCollateralsMedias' => $modelCollateralsMedias,
			'collateralMediaTypeList' => $collateralMediaTypeList,
    ]) ?>

</div>
