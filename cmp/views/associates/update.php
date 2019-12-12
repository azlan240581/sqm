<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserAssociateDetails */

$this->title = 'Update Associate Details : ' . $modelUsers->name;
$this->params['breadcrumbs'][] = 'Associates Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/associates']];
$this->params['breadcrumbs'][] = ['label' => $modelUsers->name, 'url' => ['view', 'id' => $modelUserAssociateDetails->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-associate-details-update">

    <?= $this->render('_form', [
            'modelUsers' => $modelUsers,
            'modelUserAssociateDetails' => $modelUserAssociateDetails,
            'countryList' => $countryList,
            'countryCodeList' => $countryCodeList,
            'domicileList' => $domicileList,
            'occupationList' => $occupationList,
            'industryBackgroundList' => $industryBackgroundList,
    ]) ?>

</div>
