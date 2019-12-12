<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupPurposeOfBuying */

$this->title = 'Update Purpose Of Buying : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Purpose Of Buying List', 'url' => ['/lookup-purpose-of-buying']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-purpose-of-buying-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
