<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Activities */

$this->title = 'Update Activity : ' . $model->activity_code;
$this->params['breadcrumbs'][] = 'Points Management';
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['/activities']];
$this->params['breadcrumbs'][] = ['label' => $model->activity_code, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="activities-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
