<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LogAssociatePoints */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Associate Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-associate-points-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'points_value',
            'status',
            'remarks:ntext',
            'createdby',
            'createdat',
        ],
    ]) ?>

</div>
