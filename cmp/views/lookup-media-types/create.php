<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupMediaTypes */

$this->title = 'Create Media Type';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Media Types', 'url' => ['/lookup-media-types']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-media-types-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
