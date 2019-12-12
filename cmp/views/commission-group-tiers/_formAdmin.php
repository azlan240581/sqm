<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use maksyutin\duallistbox\Widget;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\Commission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="commission-form">

    <?php $form = ActiveForm::begin(); ?>

	<?php
	foreach($productTypeList as $productType)
	{
		if(isset($commissionGroupTierList[$productType['id']]))
		{
			?>
            <div style="clear:both;"><br /></div>
            <div class="panel panel-default">
                <div class="panel-heading"><strong><?= $productType['name'] ?></strong></div>
                <div class="panel-body">
                <?php
                foreach($commissionGroupList as $commissionGroup)
				{
					if(isset($commissionGroupTierList[$productType['id']][$commissionGroup['id']]))
					{
						?>
                        <div class="row bg-dark-grey">
                            <div class="col-xs-12"><h4><?= $commissionGroup['name'] ?></h4></div>
                        </div>
                        <table id="w0" class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <th>Tier</th>
                                    <?php
                                    foreach($commissionTierList as $commissionTier)
                                    {
                                        ?>
                                        <td><?php echo $commissionTier['name'] ?></td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <th><?php echo $model->getAttributeLabel('minimum_transaction_value') ?></th>
                                    <?php
                                    foreach($commissionTierList as $commissionTier)
                                    {
                                        ?>
                                        <td>
                                        <div class="form-group field-commissiongrouptiers-<?= $productType['id'] ?>-<?= $commissionGroup['id'] ?>-<?= $commissionTier['id'] ?>-minimum_transaction_value">
                                        <?php /*?><input type="number" id="commissiongrouptiers-<?= $productType['id'] ?>-<?= $commissionGroup['id'] ?>-<?= $commissionTier['id'] ?>-minimum_transaction_value" class="form-control" name="CommissionGroupTiers[<?= $productType['id'] ?>][<?= $commissionGroup['id'] ?>][<?= $commissionTier['id'] ?>][minimum_transaction_value]" value="<?= number_format($commissionGroupTierList[$productType['id']][$commissionGroup['id']][$commissionTier['id']]['minimum_transaction_value'],'2','.','') ?>" min="0" step="0.01"><?php */?>
										<?php
										echo NumberControl::widget([
											'name' => 'CommissionGroupTiers['.$productType['id'].']['.$commissionGroup['id'].']['.$commissionTier['id'].'][minimum_transaction_value]',
											'value' => $commissionGroupTierList[$productType['id']][$commissionGroup['id']][$commissionTier['id']]['minimum_transaction_value'],
											'maskedInputOptions' => [
												'prefix' => $_SESSION['settings']['CURRENCY_SYMBOL'].' ',
												'suffix' => '',
												'allowMinus' => false,
												'rightAlign' => false,
											],
											'options' => ['type' => 'hidden'],
										]);
                                        ?>
                                        <div class="help-block"></div>
                                        </div>				
                                        </td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <th><?php echo $model->getAttributeLabel('maximum_transaction_value') ?></th>
                                    <?php
                                    foreach($commissionTierList as $commissionTier)
                                    {
                                        ?>
                                        <td>
                                        <div class="form-group field-commissiongrouptiers-<?= $productType['id'] ?>-<?= $commissionGroup['id'] ?>-<?= $commissionTier['id'] ?>-maximum_transaction_value">
                                        <?php /*?><input type="number" id="commissiongrouptiers-<?= $productType['id'] ?>-<?= $commissionGroup['id'] ?>-<?= $commissionTier['id'] ?>-maximum_transaction_value" class="form-control" name="CommissionGroupTiers[<?= $productType['id'] ?>][<?= $commissionGroup['id'] ?>][<?= $commissionTier['id'] ?>][maximum_transaction_value]" value="<?= number_format($commissionGroupTierList[$productType['id']][$commissionGroup['id']][$commissionTier['id']]['maximum_transaction_value'],'2','.','') ?>" min="0" step="0.01"><?php */?>
										<?php
										echo NumberControl::widget([
											'name' => 'CommissionGroupTiers['.$productType['id'].']['.$commissionGroup['id'].']['.$commissionTier['id'].'][maximum_transaction_value]',
											'value' => $commissionGroupTierList[$productType['id']][$commissionGroup['id']][$commissionTier['id']]['maximum_transaction_value'],
											'maskedInputOptions' => [
												'prefix' => $_SESSION['settings']['CURRENCY_SYMBOL'].' ',
												'suffix' => '',
												'allowMinus' => false,
												'rightAlign' => false,
											],
											'options' => ['type' => 'hidden'],
										]);
                                        ?>
                                        <div class="help-block"></div>
                                        </div>				
                                        </td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <th><?php echo $model->getAttributeLabel('commission_type') ?></th>
                                    <?php
                                    foreach($commissionTierList as $commissionTier)
                                    {
                                        ?>
                                        <td>
                                        <div class="form-group field-commissiongrouptiers-<?= $productType['id'] ?>-<?= $commissionGroup['id'] ?>-<?= $commissionTier['id'] ?>-commission_type">
                                        <select id="commissiongrouptiers-<?= $productType['id'] ?>-<?= $commissionGroup['id'] ?>-<?= $commissionTier['id'] ?>-commission_type" class="form-control" name="CommissionGroupTiers[<?= $productType['id'] ?>][<?= $commissionGroup['id'] ?>][<?= $commissionTier['id'] ?>][commission_type]">
                                        <?php
                                        foreach($commissionTypeList as $commissionType)
                                        {
                                            ?>
                                            <option value="<?= $commissionType['id'] ?>" <?= $commissionType['id']==$commissionGroupTierList[$productType['id']][$commissionGroup['id']][$commissionTier['id']]['commission_type']?'selected="selected"':'' ?>><?= $commissionType['name'] ?></option>
                                            <?php
                                        }
                                        ?>
                                        </select>                    
                                        <div class="help-block"></div>
                                        </div>				
                                        </td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <th><?php echo $model->getAttributeLabel('commission_value') ?></th>
                                    <?php
                                    foreach($commissionTierList as $commissionTier)
                                    {
                                        ?>
                                        <td>
                                        <div class="form-group field-commissiongrouptiers-<?= $productType['id'] ?>-<?= $commissionGroup['id'] ?>-<?= $commissionTier['id'] ?>-commission_value">
                                        <?php /*?><input type="number" id="commissiongrouptiers-<?= $productType['id'] ?>-<?= $commissionGroup['id'] ?>-<?= $commissionTier['id'] ?>-commission_value" class="form-control" name="CommissionGroupTiers[<?= $productType['id'] ?>][<?= $commissionGroup['id'] ?>][<?= $commissionTier['id'] ?>][commission_value]" value="<?= number_format($commissionGroupTierList[$productType['id']][$commissionGroup['id']][$commissionTier['id']]['commission_value'],'2','.','') ?>" min="0" step="0.01"><?php */?>
										<?php
										echo NumberControl::widget([
											'name' => 'CommissionGroupTiers['.$productType['id'].']['.$commissionGroup['id'].']['.$commissionTier['id'].'][commission_value]',
											'value' => $commissionGroupTierList[$productType['id']][$commissionGroup['id']][$commissionTier['id']]['commission_value'],
											'maskedInputOptions' => [
												'prefix' => '',
												'suffix' => '',
												'allowMinus' => false,
												'rightAlign' => false,
											],
											'options' => ['type' => 'hidden'],
										]);
                                        ?>
                                        <div class="help-block"></div>
                                        </div>				
                                        </td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php /*?><tr>
                                    <th><?php echo $model->getAttributeLabel('expiration_period') ?></th>
                                    <?php
                                    foreach($commissionTierList as $commissionTier)
                                    {
                                        ?>
                                        <td>
                                        <div class="form-group field-commissiongrouptiers-<?= $productType['id'] ?>-<?= $commissionGroup['id'] ?>-<?= $commissionTier['id'] ?>-expiration_period">
                                        <input type="number" id="commissiongrouptiers-<?= $productType['id'] ?>-<?= $commissionGroup['id'] ?>-<?= $commissionTier['id'] ?>-expiration_period" class="form-control" name="CommissionGroupTiers[<?= $productType['id'] ?>][<?= $commissionGroup['id'] ?>][<?= $commissionTier['id'] ?>][expiration_period]" value="<?= number_format($commissionGroupTierList[$productType['id']][$commissionGroup['id']][$commissionTier['id']]['expiration_period'],'0','','') ?>" min="0" step="1">
                                        <div class="help-block"></div>
                                        </div>				
                                        </td>
                                        <?php
                                    }
                                    ?>
                                </tr><?php */?>
                            </tbody>
                        </table>
                        <?php
					}
				}
                ?>
                </div>
            </div>    
			<?php
		}
	}
	?>

	<?php /*?>
	<?php
    echo $form->field($model, 'product_type_id')->dropDownList(
            ArrayHelper::map($productTypeList, 'id', 'name'),['prompt' => 'Please select','disabled'=>($_SESSION['user']['action']=='create'?FALSE:TRUE)]
    )->label('Product Type');
    ?>
    
	<?php
    echo $form->field($model, 'commission_group_id')->dropDownList(
            ArrayHelper::map($commissionGroupList, 'id', 'name'),['prompt' => 'Please select','disabled'=>($_SESSION['user']['action']=='create'?FALSE:TRUE)]
    )->label('Group');
    ?>

    <table id="w0" class="table table-striped table-bordered">
        <tbody>
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
                <th><?php echo $model->getAttributeLabel('minimum_transaction_value') ?></th>
                <?php
                foreach($commissionTierList as $tier)
                {
                    ?>
                    <td>
                    <?= $form->field($model, 'minimum_transaction_value['.$tier['id'].']')->textInput(['type' => 'number', 'min'=>0, 'step'=>0.01])->label(false) ?>
                    </td>
                    <?php
                }
                ?>
            </tr>
            <tr>
                <th><?php echo $model->getAttributeLabel('maximum_transaction_value') ?></th>
                <?php
                foreach($commissionTierList as $tier)
                {
                    ?>
                    <td>
                    <?= $form->field($model, 'maximum_transaction_value['.$tier['id'].']')->textInput(['type' => 'number', 'min'=>0, 'step'=>0.01])->label(false) ?>
                    </td>
                    <?php
                }
                ?>
            </tr>
            <tr>
                <th><?php echo $model->getAttributeLabel('commission_type') ?></th>
                <?php
                foreach($commissionTierList as $tier)
                {
                    ?>
                    <td>
                    <?php
                    echo $form->field($model, 'commission_type['.$tier['id'].']')->dropDownList(
                            ArrayHelper::map($commissionTypeList, 'id', 'name'),['prompt' => 'Please select']
                    )->label('Type');
                    ?>
                    </td>
                    <?php
                }
                ?>
            </tr>
            <tr>
                <th><?php echo $model->getAttributeLabel('commission_value') ?></th>
                <?php
                foreach($commissionTierList as $tier)
                {
                    ?>
                    <td>
                    <?= $form->field($model, 'commission_value['.$tier['id'].']')->textInput(['type' => 'number', 'min'=>0, 'step'=>0.01])->label(false) ?>
                    </td>
                    <?php
                }
                ?>
            </tr>
            <tr>
                <th><?php echo $model->getAttributeLabel('commission_value') ?></th>
                <?php
                foreach($commissionTierList as $tier)
                {
                    ?>
                    <td>
                    <?= $form->field($model, 'expiration_period['.$tier['id'].']')->textInput(['type' => 'number', 'min'=>0, 'step'=>0.01]) ?>
                    </td>
                    <?php
                }
                ?>
            </tr>
        </tbody>
    </table>
	<?php */?>


    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
