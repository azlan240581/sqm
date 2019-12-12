<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupMaritalStatus */

$this->title = 'Create Marital Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Marital Status', 'url' => ['/lookup-marital-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-marital-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
