<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fintech */

$this->title = 'Update Fintech : ' . $model->company_name;
$this->params['breadcrumbs'][] = 'Fintech Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/fintechs']];
$this->params['breadcrumbs'][] = ['label' => $model->company_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fintech-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
