<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Prospects */

$this->title = 'Create Level Of Interest';
$this->params['breadcrumbs'][] = ['label' => 'Prospects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospects-create">

    <?php /*?><h1><?= Html::encode($this->title) ?></h1><?php */?>

    <?= $this->render('_form_level_interest', [
        'modelPH' => $modelPH,
		'prospect_id' => $prospect_id,
    ]) ?>

</div>
