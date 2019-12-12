<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PropertyProductMedias */

$this->title = 'Create Property Product Media';
$this->params['breadcrumbs'][] = 'Property Products Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/property-products']];
$this->params['breadcrumbs'][] = ['label' => $modelPropertyProducts->title, 'url' => ['view', 'id' => $modelPropertyProducts->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-product-medias-create">

    <?= $this->render('_formMedia', [
			'modelPropertyProducts' => $modelPropertyProducts,
			'modelPropertyProductMedias' => $modelPropertyProductMedias,
			'lookupMediaTypeList' => $lookupMediaTypeList,
    ]) ?>

</div>
