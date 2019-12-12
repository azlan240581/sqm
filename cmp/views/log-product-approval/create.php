<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogProductApproval */

$this->title = 'Create Log Product Approval';
$this->params['breadcrumbs'][] = ['label' => 'Log Product Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-product-approval-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
