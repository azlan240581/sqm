<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SettingsRulesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings Rules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-rules-index">
    <p>
        <?= Html::a('Create Settings Rules', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'employer_id',
			[
            	'label'=>'Settings Category Name',
				'value'=>'settingsCategories.settings_category_name',
				'filter' => true
            ],
			'settings_rules_key',
            'settings_rules_value',
            'settings_rules_desc:ntext',
            // 'settings_rules_config_type',
            // 'settings_rules_config',
            // 'settings_rules_sort',
            // 'updatedat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
