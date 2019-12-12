<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewPotentialAssociatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Potential Associate';
$this->params['breadcrumbs'][] = 'Associates Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/new-potential-associates']];
?>
<div class="new-potential-associates-index">
    <p>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
				'attribute' => 'user',
				'label' => 'Inviter',
				'value' => function($model){
							if($model->inviter_id==1)
							return $model->user->name.' (Administrator)';
							else
							return $model->user->name.' ('.Yii::$app->AccessMod->getUserGroupName(Yii::$app->AccessMod->getUserGroupID($model->inviter_id)).')';
						},
			],
            'name',
            'email:email',
            'contactno',
			[
				'attribute' => 'registered',
				'filter'=>ArrayHelper::map($registeredList, 'value', 'name'),
				'value' => function($model){
							return $model->registered==1?'Yes':'No';
						},
			],
        ],
    ]); ?>
</div>
