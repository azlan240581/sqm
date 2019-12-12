<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogUserMessagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log User Messages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-user-messages-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log User Messages', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'subject',
            'message:ntext',
            'long_message:ntext',
            'recepients_list:ntext',
            // 'priority',
            // 'createdby',
            // 'createdat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
