<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SettingsCategories */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Settings Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-categories-view">
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
            'settings_category_name',
            'settings_category_description',
            'updatedat',
        ],
    ]) ?>

</div>
