<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupProductStatus */

$this->title = 'Create Product Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Product Status', 'url' => ['/lookup-product-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-product-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
