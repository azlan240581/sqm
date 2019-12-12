<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserAssociateBrokerDetails */

$this->title = 'Create User Associate Broker Details';
$this->params['breadcrumbs'][] = ['label' => 'User Associate Broker Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-associate-broker-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
