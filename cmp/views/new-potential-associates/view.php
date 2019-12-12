<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\NewPotentialAssociates */

$this->title = $model->name;
$this->params['breadcrumbs'][] = 'Associates Management';
$this->params['breadcrumbs'][] = ['label' => 'Potential Associate', 'url' => ['/new-potential-associates']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-potential-associates-view">
    <p>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			[
				'label'=>'Inviter',
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
				'label'=>$model->getAttributeLabel('registered'),
				'value' => $model->registered==1?'Yes':'No',
			],
        ],
    ]) ?>

</div>
