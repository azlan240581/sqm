<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupCountry */

$this->title = 'Create Country';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Countries', 'url' => ['/lookup-country']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-country-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
