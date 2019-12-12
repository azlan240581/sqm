<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserAssociateDetails */

$this->title = '+ Invite New Associate';
$this->params['breadcrumbs'][] = 'Associates Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/associates/invite']];
?>
<div class="user-associate-details-create">

    <?= $this->render('_formInviteAssociate', [
        'model' => $model,
        'error' => $error,
        'agentList' => $agentList,
        'countryCodeList' => $countryCodeList,
    ]) ?>

</div>
