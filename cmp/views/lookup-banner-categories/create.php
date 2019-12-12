<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupBannerCategories */

$this->title = 'Create Banner Category';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Banner Categories', 'url' => ['/lookup-banner-categories']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-banner-categories-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
