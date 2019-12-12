<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupPositions */

$this->title = 'Create Position';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Positions', 'url' => ['/lookup-positions']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-positions-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
