<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Projects */

$this->title = 'Update Project : ' . $model->project_name;
$this->params['breadcrumbs'][] = 'Projects Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/projects']];
$this->params['breadcrumbs'][] = ['label' => $model->project_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="projects-update">

    <?= $this->render('_form', [
			'model' => $model,
			'modelProjectAgents' => $modelProjectAgents,
			'developerList' => $developerList,
			'sqmAccountManagerObj' => $sqmAccountManagerObj,
    ]) ?>

</div>
