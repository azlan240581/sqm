<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupOccupation */

$this->title = 'Create Occupation';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Occupation List', 'url' => ['/lookup-occupation']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-occupation-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
