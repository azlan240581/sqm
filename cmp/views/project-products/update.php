<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectProducts */

$this->title = 'Update Product : ' . $model->product_name;
$this->params['breadcrumbs'][] = 'Projects Management';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['/project-products']];
$this->params['breadcrumbs'][] = ['label' => $model->product_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-products-update">

    <?= $this->render('_form', [
		'model' => $model,
		'modelProjectProductUnitTypes' => $modelProjectProductUnitTypes,
		'projectList' => $projectList,
    ]) ?>

</div>
