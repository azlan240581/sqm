<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogUserPoints */

$this->title = 'Create Log User Points';
$this->params['breadcrumbs'][] = ['label' => 'Log User Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-user-points-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
