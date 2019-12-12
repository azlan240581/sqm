<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupWhatsNewStatus */

$this->title = 'Create Whats New Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Whats New Status', 'url' => ['/lookup-whats-new-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-whats-new-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
