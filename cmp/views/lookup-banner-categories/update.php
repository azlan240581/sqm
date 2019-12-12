<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupBannerCategories */

$this->title = 'Update Banner Category : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Banner Categories', 'url' => ['/lookup-banner-categories']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-banner-categories-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
