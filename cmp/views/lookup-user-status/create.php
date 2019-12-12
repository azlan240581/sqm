<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupUserStatus */

$this->title = 'Create User Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage User Status', 'url' => ['/lookup-user-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-user-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
