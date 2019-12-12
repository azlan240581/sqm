<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupIndustryBackground */

$this->title = 'Create Industry Background';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Industry Background List', 'url' => ['/lookup-industry-background']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-industry-background-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
