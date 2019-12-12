<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupBanks */

$this->title = 'Create Banks';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Banks', 'url' => ['/lookup-banks']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-banks-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
