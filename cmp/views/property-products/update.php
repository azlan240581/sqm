<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PropertyProducts */

$this->title = 'Update Property Product : ' . $model->title;
$this->params['breadcrumbs'][] = 'Property Products Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/property-products']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="property-products-update">

    <?= $this->render('_form', [
			'model' => $model,
			'projectList' => $projectList,
			'projectProductList' => $projectProductList,
			'collateralObj' => $collateralObj,
			'propertyProductTypeList' => $propertyProductTypeList,
    ]) ?>

</div>
