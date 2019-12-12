<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogAssociatePoints */

$this->title = 'Create Log Associate Points';
$this->params['breadcrumbs'][] = ['label' => 'Log Associate Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-associate-points-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
