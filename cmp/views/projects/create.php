<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use maksyutin\duallistbox\Widget;


/* @var $this yii\web\View */
/* @var $model app\models\Projects */

$this->title = '+ Add New Project';
$this->params['breadcrumbs'][] = 'Projects Management';
$this->params['breadcrumbs'][] = ['label' => '+ Add New Project', 'url' => ['/projects/create']];
?>
<div class="projects-create">

    <?= $this->render('_form', [
		'model' => $model,
		'modelProjectAgents' => $modelProjectAgents,
		'developerList' => $developerList,
		'sqmAccountManagerObj' => $sqmAccountManagerObj,
    ]) ?>

</div>
