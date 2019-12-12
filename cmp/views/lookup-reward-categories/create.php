<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupRewardCategories */

$this->title = 'Create Reward Category';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Reward Categories', 'url' => ['/lookup-reward-categories']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-reward-categories-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
