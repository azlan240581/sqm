<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserPoints */

$this->title = 'Create User Points';
$this->params['breadcrumbs'][] = ['label' => 'User Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-points-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
