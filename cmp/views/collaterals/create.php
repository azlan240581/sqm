<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Collaterals */

$this->title = '+ Add New Collaterals';
$this->params['breadcrumbs'][] = 'Collaterals Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/collaterals']];
?>
<div class="collaterals-create">

    <?= $this->render('_form', [
		'model' => $model,
		'modelCollateralsMedias' => $modelCollateralsMedias,
		'projectList' => $projectList,
		'collateralMediaTypeList' => $collateralMediaTypeList,
    ]) ?>

</div>
