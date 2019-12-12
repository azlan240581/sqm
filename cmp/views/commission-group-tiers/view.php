<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Commission */

$this->title = $model->lookupCommissionGroup->name;
$this->params['breadcrumbs'][] = 'Commission Management';
$this->params['breadcrumbs'][] = ['label' => 'Commission Tiers Manager', 'url' => ['/commission-group-tiers']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commission-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/ ?>
    </p>    
    
    <table id="w0" class="table table-striped table-bordered detail-view">
    <tbody>
        <tr>
            <th>Product Type</th>
            <td colspan="<?php echo count($commissionTierList); ?>"><?php echo $model->lookupProductType->name ?></td>
        </tr>
        <tr>
            <th>Group</th>
            <td colspan="<?php echo count($commissionTierList); ?>"><?php echo $model->lookupCommissionGroup->name ?></td>
        </tr>
        <tr>
            <th>Tier</th>
            <?php
            foreach($commissionTierList as $tier)
            {
                ?>
                <td><?php echo $tier['name'] ?></td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <th>Minimum Transaction Value</th>
            <?php
            foreach($commissionTierList as $tier)
            {
                ?>
                <td><?php echo Yii::$app->AccessMod->getPriceFormat($commissionList[$tier['id']]['minimum_transaction_value']) ?></td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <th>Maximum Transaction Value</th>
            <?php
            foreach($commissionTierList as $tier)
            {
                ?>
                <td><?php echo Yii::$app->AccessMod->getPriceFormat($commissionList[$tier['id']]['maximum_transaction_value']) ?></td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <th>Commission Type</th>
            <?php
            foreach($commissionTierList as $tier)
            {
                ?>
                <td>
                    <?php echo $commissionType[$commissionList[$tier['id']]['commission_type']] ?>
                </td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <th>Commission Value</th>
            <?php
            foreach($commissionTierList as $tier)
            {
                ?>
                <td>
                    <?php 
					if($commissionList[$tier['id']]['commission_type']==1)
					echo number_format($model->commission_value,'2','.','').'%';
					else
					echo Yii::$app->AccessMod->getPriceFormat($commissionList[$tier['id']]['commission_value']);
					?>
                </td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <th>Expiration Period</th>
            <?php
            foreach($commissionTierList as $tier)
            {
                ?>
                <td>
                    <?php echo $commissionList[$tier['id']]['expiration_period'] ?>
                </td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <th>Created By</th>
            <td colspan="<?php echo count($commissionTierList); ?>">
                <?php echo Yii::$app->AccessMod->getName($model->createdby) ?>
            </td>
        </tr>
        <tr>
            <th>Created At</th>
            <td colspan="<?php echo count($commissionTierList); ?>">
                <?php echo Yii::$app->formatter->asDatetime($model->createdat) ?>
            </td>
        </tr>
        <tr>
            <th>Updated By</th>
            <td colspan="<?php echo count($commissionTierList); ?>">
                <?php echo Yii::$app->AccessMod->getName($model->updatedby) ?>
            </td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td colspan="<?php echo count($commissionTierList); ?>">
                <?php echo Yii::$app->formatter->asDatetime($model->updatedat) ?>
            </td>
        </tr>
    </tbody>
    </table>    
    
</div>
