<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\NewPotentialProspects */

$this->title = 'Create New Potential Prospects';
$this->params['breadcrumbs'][] = ['label' => 'New Potential Prospects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-potential-prospects-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
