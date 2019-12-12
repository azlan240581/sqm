<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CollateralsMedias */

$this->title = 'Create Collaterals Medias';
$this->params['breadcrumbs'][] = ['label' => 'Collaterals Medias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collaterals-medias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
