<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupPointsActions */

$this->title = 'Create Point Action';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Points Actions', 'url' => ['/lookup-points-actions']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-points-actions-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
