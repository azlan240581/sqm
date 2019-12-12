<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupRewardCategories */

$this->title = 'Update Reward Category : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Reward Categories', 'url' => ['/lookup-reward-categories']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-reward-categories-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
