<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PotentialProspects */

$this->title = 'Update Potential Prospects: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Potential Prospects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="potential-prospects-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
