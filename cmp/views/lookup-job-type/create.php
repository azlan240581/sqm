<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupJobType */

$this->title = 'Create Job Type';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Job Type', 'url' => ['/lookup-job-type']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-job-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
