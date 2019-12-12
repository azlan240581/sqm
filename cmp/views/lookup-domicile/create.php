<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupDomicile */

$this->title = 'Create Domicile';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Domicile List', 'url' => ['/lookup-domicile']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-domicile-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
