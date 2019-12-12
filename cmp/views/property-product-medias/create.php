<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PropertyProductMedias */

$this->title = 'Create Property Product Medias';
$this->params['breadcrumbs'][] = ['label' => 'Property Product Medias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-product-medias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
