<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupProductivityStatus */

$this->title = 'Create Productivity Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Productivity Status', 'url' => ['/lookup-productivity-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-productivity-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
