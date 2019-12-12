<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupSalutations */

$this->title = 'Create Salutation';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Salutations', 'url' => ['/lookup-salutations']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-salutations-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
