<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rewards */

$this->title = '+ Add New Reward';
$this->params['breadcrumbs'][] = 'Rewards Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/rewards/create']];
?>
<div class="rewards-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
