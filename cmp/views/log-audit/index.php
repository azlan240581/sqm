<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogAuditSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Audits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-audit-index">
    <p>
        <?php //echo Html::a('Create Log Audit', ['create'], ['class' => 'btn btn-success']) ?>
        <!--<button onclick="printContent('divLogAuditIndex')" class="btn btn-primary">Print this page</button>-->
        <button onclick="window.print()" class="btn btn-primary">Print this page</button>
    </p>

	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'module_id',
            'record_id',
            'action',
            'newdata:ntext',
            // 'olddata:ntext',
            // 'user_id',
            // 'createdat',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['class' => 'header-options'],
                'contentOptions' => ['class' => 'content-options'],
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp&nbsp', $url);
                    },
                ],
                'urlCreator' => function ($action, $model) {
                    if ($action === 'view') {
                        $url = ['view', 'id'=>$model->id];
                        return $url;
                    }
                },
            ],
        ],
    ]); ?>
</div>
