<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupUserCommissionStatus */

$this->title = 'Create Commission Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Commission Status', 'url' => ['/lookup-user-commission-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-user-commission-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
