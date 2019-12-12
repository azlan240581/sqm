<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Fintech */

$this->title = '+ Add New Fintech';
$this->params['breadcrumbs'][] = 'Fintech Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/fintechs/create']];
?>
<div class="fintech-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
