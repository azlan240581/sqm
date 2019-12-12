<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SettingsRules */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Settings Rules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-rules-view">
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
            'employer_id',
            'settings_categories_id',
            'settings_rules_key',
            'settings_rules_value',
            'settings_rules_desc:ntext',
            'settings_rules_config_type',
            'settings_rules_config',
            'settings_rules_sort',
            'updatedat',
        ],
    ]) ?>

</div>
