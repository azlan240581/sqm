<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Projects */

$this->title = $model->project_name;
$this->params['breadcrumbs'][] = 'Projects Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/projects']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-view">

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

			[
				'label'=>'Developer Name',
				'value'=>$model->developer->company_name,
			],
            'project_name',
            'project_description:ntext',
			[
				'attribute' => 'thumb_image',
				'format'=>'raw',
				'value'=> !strlen($model->thumb_image)?NULL:Html::a(Html::img($model->thumb_image, ['width'=>200]),$model->thumb_image, ['data-fancybox'=>true]),
			],
			[
				'label'=>'Project Handler',
				'format' => 'raw',
				'value'  => call_user_func(function ($modelProjectAgents) {
					if(count($modelProjectAgents)!=0)
					{
						$tmp = '';
						$i=1;
						foreach($modelProjectAgents as $value)
						{
							$tmp .= Yii::$app->AccessMod->getName($value['agent_id']);
							$tmp .= '<br>';
							$i++;
						}
						$tmp .= '';
						return $tmp;
					}
					else
					return NULL;
				}, $modelProjectAgents),
			],
			[
				'label'=>'Status',
				'value'=>$model->status==1?'Active':'Inactive',
			],
			[
				'label'=>'Created By',
				'value'=>Yii::$app->AccessMod->getName($model->createdby),
			],
            'createdat:datetime',
			[
				'label'=>'Updated By',
				'value'=>Yii::$app->AccessMod->getName($model->updatedby),
			],
            'updatedat:datetime',
            //'deletedby',
            //'deletedat:datetime',
			
        ],
    ]) ?>

</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
