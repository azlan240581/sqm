<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\NewsFeeds */

$this->title = '+ Add News Feed';
$this->params['breadcrumbs'][] = 'News Feed Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/news-feeds/create']];
?>
<div class="news-feeds-create">

    <?= $this->render('_form', [
			'model' => $model,
			'modelNewsFeedMedias' => $modelNewsFeedMedias,
			'projectList' => $projectList,
			'collateralObj' => $collateralObj,
			'propertyProductList' => $propertyProductList,
			'lookupNewsFeedCategoryList' => $lookupNewsFeedCategoryList,
    ]) ?>

</div>
