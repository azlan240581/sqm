<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Developers */

$this->title = 'Update Developer : ' . $model->company_name;
$this->params['breadcrumbs'][] = 'Developer Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/developers']];
$this->params['breadcrumbs'][] = ['label' => $model->company_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="developers-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
