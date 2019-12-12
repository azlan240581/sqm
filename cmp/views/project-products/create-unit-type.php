<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProjectProductUnitTypes */

$this->title =  $modelProjectProducts->product_name.' Unit Type';
$this->params['breadcrumbs'][] = 'Projects Management';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['/project-products']];
$this->params['breadcrumbs'][] = ['label' => $modelProjectProducts->product_name, 'url' => ['view', 'id' => $modelProjectProducts->id]];
$this->params['breadcrumbs'][] = 'Create Unit Type';
?>
<div class="project-product-unit-types-create">

    <?= $this->render('_formUnitType', [
		'modelProjectProducts' => $modelProjectProducts,
		'modelProjectProductUnitTypes' => $modelProjectProductUnitTypes,
    ]) ?>

</div>
