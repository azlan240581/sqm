<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsFeedsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News Feeds';
$this->params['breadcrumbs'][] = 'News Feed Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/news-feeds']];
?>
<div class="news-feeds-index">
    <p>
    </p>
    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'project',
                'filter'=>ArrayHelper::map($projectList, 'project_name', 'project_name'),
                'label' => 'Project Name',
                'value' => function($model){
                            return $model->project->project_name;
                        },
            ],
            [
                'attribute' => 'category_id',
                'filter'=>ArrayHelper::map($lookupNewsFeedCategoryList, 'id', 'name'),
                'label' => 'Category',
                'value' => function($model){
                            return $model->lookupNewsFeedCategory->name;
                        },
            ],
            'title',
            [
                'attribute' => 'status',
                'filter'=>ArrayHelper::map($lookupNewsFeedStatusList, 'id', 'name'),
                'value' => function($model){
                            return $model->lookupNewsFeedStatus->name;
                        },
            ],
            [
                'attribute' => 'createdat',
                'format' => 'datetime',
                'filter' => DateRangePicker::widget([
                            'model'=>$searchModel,
                            'attribute'=>'createdatrange',
                            'convertFormat'=>true,
                            'readonly'=>true,
                            'presetDropdown'=>true,
                            'pluginOptions'=>[
                                'locale'=>[
                                    'format'=>'Y-m-d H:i:s',
                                    'cancelLabel' => 'Clear',
                                ],
                            ],
                            'options' => [
                                'class' => 'form-control',
                            ],
                            'pluginEvents' => [
                                        'apply.daterangepicker' => 'function(ev, picker) {
                                                if($(this).val() == "") {
                                                    $(this).val(picker.startDate.format(picker.locale.format) + picker.locale.separator +
                                                    picker.endDate.format(picker.locale.format)).trigger("change");
                                                }
                                            }',
                                            'show.daterangepicker' => 'function(ev, picker) {
                                                picker.container.find(".ranges").off("mouseenter.daterangepicker", "li");
                                                    if($(this).val() == "") {
                                                    picker.container.find(".ranges .active").removeClass("active");
                                                }
                                            }',
                                            'cancel.daterangepicker' => 'function(ev, picker) {
                                                if($(this).val() != "") {
                                                    $(this).val("").trigger("change");
                                                }
                                            }'
                            ],
                        ]),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
