<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupProspectHistory */

$this->title = 'Create Prospect History';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Prospect History', 'url' => ['/lookup-prospect-history']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-prospect-history-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
