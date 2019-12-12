<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupCommissionStatus */

$this->title = 'Create Commission Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Commission Status', 'url' => ['/lookup-commission-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-commission-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
