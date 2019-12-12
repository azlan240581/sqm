<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserDeveloper */

$this->title = 'Update User Developer: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Developers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-developer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
