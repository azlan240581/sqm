<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Prospects */

$this->title = 'EOI to Booking';
$this->params['breadcrumbs'][] = ['label' => 'Prospects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospects-create">

    <?php /*?><h1><?= Html::encode($this->title) ?></h1><?php */?>

    <?= $this->render('_form_eoi_booking', [
        'model' => $model,
		'modelPB' => $modelPB,
 		'modelPBB' => $modelPBB,
    ]) ?>

</div>
