<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupProspectStatus */

$this->title = 'Create Prospect Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Prospect Status', 'url' => ['/lookup-prospect-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-prospect-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
