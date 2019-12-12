<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupMediaTypes */

$this->title = 'Update Media Type : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Media Types', 'url' => ['/lookup-media-types']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-media-types-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
