<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupCommissionType */

$this->title = 'Create Lookup Commission Type';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Commission Type', 'url' => ['/lookup-commission-type']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-commission-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
