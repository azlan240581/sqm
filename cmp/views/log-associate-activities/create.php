<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogAssociateActivities */

$this->title = 'Create Log Associate Activities';
$this->params['breadcrumbs'][] = ['label' => 'Log Associate Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-associate-activities-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
