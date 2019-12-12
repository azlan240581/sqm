<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SettingsCategories */

$this->title = 'Update Settings Categories: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Settings Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="settings-categories-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
