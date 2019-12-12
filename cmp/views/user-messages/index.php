<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserMessagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Messages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-messages-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Messages', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'subject',
            'message:ntext',
            'mark_as_read',
            // 'createdby',
            // 'createdat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
