<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NewPotentialProspects */

$this->title = 'Update New Potential Prospects: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'New Potential Prospects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="new-potential-prospects-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
