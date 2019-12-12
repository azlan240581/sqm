<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupBookingStatus */

$this->title = 'Create Booking Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Booking Status', 'url' => ['/lookup-booking-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-booking-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
