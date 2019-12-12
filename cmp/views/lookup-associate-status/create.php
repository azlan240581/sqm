<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupAssociateStatus */

$this->title = 'Create Associate Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Associate Status', 'url' => ['/lookup-associate-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-associate-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
