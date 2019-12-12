<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserAssociateBrokerDetails */

$this->title = 'Update User Associate Broker Details: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Associate Broker Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-associate-broker-details-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
