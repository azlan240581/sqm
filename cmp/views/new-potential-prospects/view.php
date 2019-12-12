<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\NewPotentialProspects */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'New Potential Prospects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-potential-prospects-view">

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
            'associate_id',
            'name',
            'email:email',
            'contactno',
            'registered',
        ],
    ]) ?>

</div>
