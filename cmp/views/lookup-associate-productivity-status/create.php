<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupAssociateProductivityStatus */

$this->title = 'Create Associate Productivity Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Associate Productivity Status', 'url' => ['/lookup-associate-productivity-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-associate-productivity-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
