<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupProspectLevelInterest */

$this->title = 'Create Lookup Prospect Level Interest';
$this->params['breadcrumbs'][] = ['label' => 'Lookup Prospect Level Interests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-prospect-level-interest-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
