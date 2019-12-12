<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LogAudit */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Audits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-audit-view">

    <h1><?php //echo Html::encode($this->title) ?></h1>

    <p>
        <?php //echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/ ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'module_id',
            'record_id',
            'action',
            'newdata:ntext',
            'olddata:ntext',
            'user_id',
            'createdat',
        ],
    ]) ?>

</div>
