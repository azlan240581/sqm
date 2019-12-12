<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LogApi */

$this->title = $model->id;
$this->params['breadcrumbs'][] = 'Reports';
$this->params['breadcrumbs'][] = 'Log';
$this->params['breadcrumbs'][] = ['label' => 'API Request', 'url' => ['/log-api']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="log-api-view" style="max-height:calc(95vh - 210px); overflow-y:scroll; display:block;">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			[
				'attribute'=>'user.name',
				'label'=>'Staff Name',
			],
            'api_actions',
			[
				'label'=>'Request',
				'format' => 'raw',
				'value' => $model->request($model->request),
			],
			[
				'label'=>'Response',
				'format' => 'raw',
				'value' => $model->response($model->response),
			],
            'createdat:datetime',
        ],
    ]) ?>

</div>
