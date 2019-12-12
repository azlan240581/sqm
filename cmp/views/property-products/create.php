<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PropertyProducts */

$this->title = '+ Add Property Product';
$this->params['breadcrumbs'][] = 'Property Products Management';
$this->params['breadcrumbs'][] = ['label' => '+ Add Property Product', 'url' => ['/property-products/create']];
?>
<div class="property-products-create">

    <?= $this->render('_form', [
			'model' => $model,
			'modelPropertyProductMedias' => $modelPropertyProductMedias,
			'projectList' => $projectList,
			'projectProductList' => $projectProductList,
			'collateralObj' => $collateralObj,
			'propertyProductTypeList' => $propertyProductTypeList,
    ]) ?>

</div>
