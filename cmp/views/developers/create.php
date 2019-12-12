<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Developers */

$this->title = '+ Add New Developer';
$this->params['breadcrumbs'][] = 'Developer Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/developers/create']];
?>
<div class="developers-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
