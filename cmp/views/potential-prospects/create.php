<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PotentialProspects */

$this->title = 'Create Potential Prospects';
$this->params['breadcrumbs'][] = ['label' => 'Potential Prospects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="potential-prospects-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
