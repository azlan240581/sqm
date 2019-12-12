<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Banners */

$this->title = '+ Add New Banner';
$this->params['breadcrumbs'][] = 'Banners Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/banners/create']];
?>
<div class="banners-create">

    <?= $this->render('_form', [
		'model' => $model,
		'lookupBannerCategoryList' => $lookupBannerCategoryList,
    ]) ?>

</div>
