<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupRedemptionStatus */

$this->title = 'Create Redemption Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Redemption Status', 'url' => ['/lookup-redemption-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-redemption-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
