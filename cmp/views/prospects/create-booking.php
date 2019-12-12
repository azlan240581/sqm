<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Prospects */

$this->title = 'Create Booking';
$this->params['breadcrumbs'][] = ['label' => 'Prospects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospects-create">

    <?= $this->render('_form_booking', [
        'model' => $model,
        'modelPB' => $modelPB,
        'modelPBB' => $modelPBB,
    ]) ?>

</div>
