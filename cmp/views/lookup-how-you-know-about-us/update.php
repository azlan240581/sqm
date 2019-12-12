<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupHowYouKnowAboutUs */

$this->title = 'Update How You Know About Us : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage How You Know About Us List', 'url' => ['/lookup-how-you-know-about-us']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-how-you-know-about-us-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
