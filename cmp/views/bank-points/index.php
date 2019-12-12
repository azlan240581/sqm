<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\BankPoints */

$this->title = 'Bank Points';
$this->params['breadcrumbs'][] = 'Points Management';
$this->params['breadcrumbs'][] = ['label' => 'Bank Points', 'url' => ['/bank-points']];
?>
<div class="bank-points-view">
    <p>
        <?= Html::a('Topup Credits', ['topup', 'ajaxView' => ''], ['class' => 'btn btn-warning modal-button-01']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

			[
				'attribute'=>'credits',
				'value' => Yii::$app->AccessMod->getPointsFormat($model->credits),
			],
			[
				'label'=>'Created By',
				'value' => Yii::$app->AccessMod->getUsername($model->createdby),
			],
            'createdat:datetime',
			[
				'label'=>'Updated By',
				'value' => Yii::$app->AccessMod->getUsername($model->updatedby),
			],
            'updatedat:datetime',
        ],
    ]) ?>

   <?php
	Modal::begin([
		'header' => '<h4>Topup Credits</h4>',
		'id' => 'modal-id-01',
		'size' => 'modal-lg',
		'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
		]);
	echo '<div id="modal-content-01"></div>';
	Modal::end();
   ?>

</div>
