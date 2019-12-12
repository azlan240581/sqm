<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Banks */

$this->title = '+ Add New Bank';
$this->params['breadcrumbs'][] = 'Banks Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/banks/create']];
?>
<div class="banks-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
