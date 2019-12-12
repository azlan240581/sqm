<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LookupPurposeOfBuying */

$this->title = $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Purpose Of Buying List', 'url' => ['/lookup-purpose-of-buying']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-purpose-of-buying-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		
            'name',
            'deleted',
			
        ],
    ]) ?>

</div>
