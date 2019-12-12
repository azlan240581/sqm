<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProspectBookings */

$this->title = 'Create Prospect Bookings';
$this->params['breadcrumbs'][] = ['label' => 'Prospect Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospect-bookings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
