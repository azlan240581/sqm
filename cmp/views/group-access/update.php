<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GroupAccess */

$this->title = 'Update Group : ' . $model->group_access_name;
$this->params['breadcrumbs'][] = 'User Management';
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['/group-access']];
$this->params['breadcrumbs'][] = ['label' => $model->group_access_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="group-access-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
