<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupIndustryBackground */

$this->title = 'Update Industry Background : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Industry Background List', 'url' => ['/lookup-industry-background']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-industry-background-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
