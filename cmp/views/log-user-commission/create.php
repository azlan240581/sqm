<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogUserCommission */

$this->title = 'Create Log User Commission';
$this->params['breadcrumbs'][] = ['label' => 'Log User Commissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-user-commission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
