<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupCommissionGroup */

$this->title = 'Create Commission Group';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Commission Group', 'url' => ['/lookup-commission-group']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-commission-group-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
