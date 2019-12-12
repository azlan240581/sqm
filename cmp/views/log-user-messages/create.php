<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogUserMessages */

$this->title = 'Create Log User Messages';
$this->params['breadcrumbs'][] = ['label' => 'Log User Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-user-messages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
