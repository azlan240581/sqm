<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupHowYouKnowAboutUs */

$this->title = 'Create How You Know About Us';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage How You Know About Us List', 'url' => ['/lookup-how-you-know-about-us']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-how-you-know-about-us-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
