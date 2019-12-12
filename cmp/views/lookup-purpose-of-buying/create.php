<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupPurposeOfBuying */

$this->title = 'Create Purpose Of Buying';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Purpose Of Buying List', 'url' => ['/lookup-purpose-of-buying']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-purpose-of-buying-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
