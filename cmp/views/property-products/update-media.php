<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PropertyProductMedias */

$this->title = 'Update Property Product Media : ' . $modelPropertyProductMedias->media_title;
$this->params['breadcrumbs'][] = 'Property Products Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/property-products']];
$this->params['breadcrumbs'][] = ['label' => $modelPropertyProducts->title, 'url' => ['view', 'id' => $modelPropertyProducts->id]];
$this->params['breadcrumbs'][] = ['label' => $modelPropertyProductMedias->media_title, 'url' => ['view-media', 'id' => $modelPropertyProductMedias->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="property-product-medias-update">

    <?= $this->render('_formMedia', [
			'modelPropertyProducts' => $modelPropertyProducts,
			'modelPropertyProductMedias' => $modelPropertyProductMedias,
			'lookupMediaTypeList' => $lookupMediaTypeList,
    ]) ?>

</div>
