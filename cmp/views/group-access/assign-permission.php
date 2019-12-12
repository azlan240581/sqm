<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GroupAccess */

$this->title = 'Assign Permission : '.$model->group_access_name;
$this->params['breadcrumbs'][] = 'User Management';
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['/group-access']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-access-create">

    <?= $this->render('_assign-permission', [
        'model' => $model,
        'module' => $module,
        'module_groups' => $module_groups,
    ]) ?>

</div>
