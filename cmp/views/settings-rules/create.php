<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SettingsRules */

$this->title = 'Create Settings Rules';
$this->params['breadcrumbs'][] = ['label' => 'Settings Rules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-rules-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
