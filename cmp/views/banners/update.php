<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Banners */

$this->title = 'Update Banner : ' . $model->banner_title;
$this->params['breadcrumbs'][] = 'Banners Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/banners']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="banners-update">

    <?= $this->render('_form', [
			'model' => $model,
			'lookupBannerCategoryList' => $lookupBannerCategoryList,
    ]) ?>

</div>
