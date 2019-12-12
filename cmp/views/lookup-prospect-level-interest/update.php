<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupProspectLevelInterest */

$this->title = 'Update Lookup Prospect Level Interest: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Lookup Prospect Level Interests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-prospect-level-interest-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
