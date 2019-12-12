<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProjectAgents */

$this->title = 'Create Project Agents';
$this->params['breadcrumbs'][] = ['label' => 'Project Agents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-agents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
