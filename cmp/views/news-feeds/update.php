<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NewsFeeds */

$this->title = 'Update News Feed : ' . $model->title;
$this->params['breadcrumbs'][] = 'News Feed Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/news-feeds']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="news-feeds-update">

    <?= $this->render('_form', [
			'model' => $model,
			'projectList' => $projectList,
			'collateralObj' => $collateralObj,
			'propertyProductList' => $propertyProductList,
			'lookupNewsFeedCategoryList' => $lookupNewsFeedCategoryList,
    ]) ?>

</div>
