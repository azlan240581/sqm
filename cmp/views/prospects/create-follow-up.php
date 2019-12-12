<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Prospects */

$this->title = 'Create Follow Up';
$this->params['breadcrumbs'][] = ['label' => 'Prospects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospects-create">

    <?php /*?><h1><?= Html::encode($this->title) ?></h1><?php */?>

    <?= $this->render('_form_follow_up', [
        'model' => $model,
		'modelPH' => $modelPH,
    ]) ?>

</div>
