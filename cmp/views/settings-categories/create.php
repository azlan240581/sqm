<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SettingsCategories */

$this->title = 'Create Settings Categories';
$this->params['breadcrumbs'][] = ['label' => 'Settings Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-categories-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
