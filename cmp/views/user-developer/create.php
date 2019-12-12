<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserDeveloper */

$this->title = 'Create User Developer';
$this->params['breadcrumbs'][] = ['label' => 'User Developers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-developer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
