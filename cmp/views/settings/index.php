<?php
use yii\helpers\Html;
//use yii\grid\GridView;
use app\models\SettingsRules;
use app\models\SettingsRulesValue;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserRetailerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/settings']];
?>
<div class="user-retailer-index">
    
    <?php 
	$form = ActiveForm::begin(); 
	?>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

    <?php
	foreach($data as $record)
	{
		$rules = SettingsRules::find()->where(['settings_categories_id'=>$record->id])->all();
	?>
	
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading<?php echo $record->id ?>">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $record->id ?>" aria-expanded="false" aria-controls="collapse<?php echo $record->id ?>">
                    <h4 class="panel-title">
                            <strong><?= $record->settings_category_name ?></strong>
                    </h4>
                </a>
            </div>
            <div id="collapse<?php echo $record->id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $record->id ?>">
    			<div class="panel-body">
    
    <table class="table table-striped">
    <tbody>
    <?php 
	foreach($rules as $rule)
	{
		$ruleValue = SettingsRulesValue::find()->where(array('settings_rules_id'=>$rule->id))->one();
	?>
    <tr>
    <td><?= ucwords(strtolower(str_replace('_',' ',$rule->settings_rules_key))) ?></td>
    <td>
    <?php 
	if($rule->settings_rules_config_type == 'img')
	{
		echo ((isset($ruleValue->value) && strlen($ruleValue->value)) ? '<img src="'.$ruleValue->value.'" class="img-thumbnail" style="max-width:50%;max-height:50px" />' : '');
	?>
    <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
    <input type="text" class="form-control" name="rule[<?= $rule->settings_rules_key ?>]" value="<?= isset($ruleValue->value)?$ruleValue->value:'' ?>" placeholder="<?= $rule->settings_rules_desc ?>" />
    </div>
    <?php
	}
	elseif($rule->settings_rules_config_type == 'msel')
	{
		$configs = unserialize($rule->settings_rules_config);
		foreach($configs as $config)
		{
	?>
    <div class="input-group">
    <span class="input-group-addon">
    <input type="checkbox" name="rule[<?= $rule->settings_rules_key ?>][]" value="<?= $config ?>" <?= ((in_array($config,explode(',', ((isset($ruleValue->value)) ? $ruleValue->value : '')))) ? 'checked="checked"' : '') ?> >
    </span>
    <input type="text" class="form-control" readonly="readonly" value="<?= $config ?>">
    </div>
    <?php
		}
	}
	elseif($rule->settings_rules_config_type == 'sel')
	{
	?>
    <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-option-vertical"></i></span>
    <select name="rule[<?= $rule->settings_rules_key ?>]" class="form-control">
    <option value=""><?= $rule->settings_rules_desc ?></option>
    <?php 
	$configs = unserialize($rule->settings_rules_config);
	foreach($configs as $config)
	{
	?>
    <option value="<?= $config ?>" <?= (isset($ruleValue->value) && $config==$ruleValue->value) ? 'selected="selected"' : '' ?>><?= $config ?></option>
    <?php
	}
	?>
    </select>
    </div>
    <?php
	}
	elseif($rule->settings_rules_config_type == 'mail')
	{
	?>
    <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
    <input type="text" class="form-control" name="rule[<?= $rule->settings_rules_key ?>]" value="<?= isset($ruleValue->value)?$ruleValue->value:'' ?>" placeholder="<?= $rule->settings_rules_desc ?>" />
    </div>
    <?php
	}
	elseif($rule->settings_rules_config_type == 'txtarea')
	{
	?>
    <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-text-size"></i></span>
    <textarea class="form-control" name="rule[<?= $rule->settings_rules_key ?>]" rows="3"><?= isset($ruleValue->value)?$ruleValue->value:'' ?></textarea>
    </div>
    <?php
	}
	else
	{
	?>
    <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-text-size"></i></span>
    <input type="text" class="form-control" name="rule[<?= $rule->settings_rules_key ?>]" value="<?= isset($ruleValue->value)?$ruleValue->value:'' ?>" placeholder="<?= $rule->settings_rules_desc ?>" />
    </div>
    <?php
	}
	?>
    </td></tr>
    <?php
	}
	?>
    </tbody>
    </table>
    
                </div>
            </div>
        </div>
    <?php
	}
	?>
    
    </div>


    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php 
	ActiveForm::end(); 
	?>

</div>
