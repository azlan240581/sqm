<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProjectProducts */

$this->title = '+ Add New Product';
$this->params['breadcrumbs'][] = 'Projects Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/project-products/create']];
?>
<div class="project-products-create">

    <?= $this->render('_form', [
		'model' => $model,
		'modelProjectProductUnitTypes' => $modelProjectProductUnitTypes,
		'projectList' => $projectList,
    ]) ?>

</div>
