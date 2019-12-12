<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Activities */

$this->title = 'Create Activity';
$this->params['breadcrumbs'][] = 'Points Management';
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['/activities']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activities-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
