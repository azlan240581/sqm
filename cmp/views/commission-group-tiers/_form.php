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
                    <?php //echo $form->field($model, 'minimum_transaction_value['.$tier['id'].']')->textInput(['type' => 'number', 'min'=>0, 'step'=>0.01])->label(false) ?>
					<?= $form->field($model, 'minimum_transaction_value['.$tier['id'].']', ['inputOptions' => ['class' => 'form-control']])
                        ->textInput(['maxlength' => true])
                        ->widget(NumberControl::classname(), [
                            'maskedInputOptions' => [
                                'prefix' => $_SESSION['settings']['CURRENCY_SYMBOL'].' ',
                                'suffix' => '',
                                'allowMinus' => false,
                                'rightAlign' => false,
                            ],
                            'options' => ['type' => 'hidden'],
                        ])->label(false);
                    ?>
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
                    <?php //echo $form->field($model, 'maximum_transaction_value['.$tier['id'].']')->textInput(['type' => 'number', 'min'=>0, 'step'=>0.01])->label(false) ?>
					<?= $form->field($model, 'maximum_transaction_value['.$tier['id'].']', ['inputOptions' => ['class' => 'form-control']])
                        ->textInput(['maxlength' => true])
                        ->widget(NumberControl::classname(), [
                            'maskedInputOptions' => [
                                'prefix' => $_SESSION['settings']['CURRENCY_SYMBOL'].' ',
                                'suffix' => '',
                                'allowMinus' => false,
                                'rightAlign' => false,
                            ],
                            'options' => ['type' => 'hidden'],
                        ])->label(false);
                    ?>
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
                    )->label(false);
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
                    <?php //echo $form->field($model, 'commission_value['.$tier['id'].']')->textInput(['type' => 'number', 'min'=>0, 'step'=>0.01])->label(false) ?>
					<?= $form->field($model, 'commission_value['.$tier['id'].']', ['inputOptions' => ['class' => 'form-control']])
                        ->textInput(['maxlength' => true])
                        ->widget(NumberControl::classname(), [
                            'maskedInputOptions' => [
                                'prefix' => '',
                                'suffix' => '',
                                'allowMinus' => false,
                                'rightAlign' => false,
                            ],
                            'options' => ['type' => 'hidden'],
                        ])->label(false);
                    ?>
                    </td>
                    <?php
                }
                ?>
            </tr>
            <tr>
                <th><?php echo $model->getAttributeLabel('expiration_period') ?></th>
                <?php
                foreach($commissionTierList as $tier)
                {
                    ?>
                    <td>
                    <?= $form->field($model, 'expiration_period['.$tier['id'].']')->textInput(['type' => 'number', 'min'=>0, 'step'=>1])->label(false) ?>
                    </td>
                    <?php
                }
                ?>
            </tr>
        </tbody>
    </table>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
