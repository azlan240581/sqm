<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GroupAccess */
/* @var $form yii\widgets\ActiveForm */


//get module groups data
foreach($module_groups as $mod)
{
	$array1[] = $mod['module_id'];
	$array2[$mod['module_id']] = unserialize($mod['permission']);
}

?>

<style>
#assigned-module {width:100%;}
#assigned-module th, #assigned-module td {
	font-size:12px !important;
}
.column-controller {width:25%;}
@media (max-width:991px) {
	.column-controller {width:50%;}
}
</style>

<div class="group-access-form" style="max-height:calc(95vh - 210px); overflow-y:scroll; display:block;">

    <?php $form = ActiveForm::begin(); ?>

    <table id="assigned-module" border="1px" style="background-color:#FFF;">
    <tr>
        <th class="column-controller">Modules</th>
        <th>Permission</th>
    </tr>
	<?php 
	if(count($module_groups)==0)
	{
		foreach($module as $modkey => $modvalue)
		{
			echo '<tr>';
				echo '<td>';
					echo '<input id="'.str_replace(' ', '_', $modvalue['name']).'_'.$modvalue['id'].'" name="modulename['.$modvalue['id'].']" style="margin-left:5px; margin-right:5px" type="checkbox" value="'.$modvalue['id'].'">';
					echo '<label for="'.str_replace(' ', '_', $modvalue['name']).'_'.$modvalue['id'].'">'.$modvalue['name'].'</label>';
					echo '<p style="margin-left:20px;">(<a href="#" id="selectall'.$modvalue['id'].'" onclick="return false;">Select All</a>)</p>';
				echo '</td>';
				echo '<td>';
					$permission = Yii::$app->AccessMod->getAllControllerActions($modvalue['controller']);
					if(!$permission)
					$permission[] = 'index';
	
					foreach($permission as $perm)
					{
						echo '<div class="col-md-6">';
						echo '<input id="'.$perm.'_'.$modvalue['id'].'" name="module['.$modvalue['id'].'][]" style="margin-right:5px" type="checkbox" class="test'.$modvalue['id'].'" value="'.$perm.'">';
						echo '<label for="'.$perm.'_'.$modvalue['id'].'">'.$perm.'</label>';
						echo '</div>';
					}
				echo '</td>';
			echo '</tr>';
		}
	}
	else
	{
		foreach($module as $modkey => $modvalue)
		{
			echo '<tr>';
				echo '<td>';
					echo (($modvalue['parentid'] != 0) ? ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' : '');
					if(in_array($modvalue['id'], $array1))
					{
						echo '<input id="'.str_replace(' ', '_', $modvalue['name']).'_'.$modvalue['id'].'" name="modulename['.$modvalue['id'].']" style="margin-left:5px; margin-right:5px" type="checkbox" value="'.$modvalue['id'].'" checked="checked">';
					}
					else
					{
						echo '<input id="'.str_replace(' ', '_', $modvalue['name']).'_'.$modvalue['id'].'" name="modulename['.$modvalue['id'].']" style="margin-left:5px; margin-right:5px" type="checkbox" value="'.$modvalue['id'].'">';
					}
					echo '<label for="'.str_replace(' ', '_', $modvalue['name']).'_'.$modvalue['id'].'">'.$modvalue['name'].'</label>';
					echo '<p style="margin-left:20px;">(<a href="#" id="selectall'.$modvalue['id'].'" onclick="return false;">Select All</a>)</p>';
				echo '</td>';
				echo '<td>';
					$permission = Yii::$app->AccessMod->getAllControllerActions($modvalue['controller']);
					if(!$permission)
					$permission[] = 'index';
					
					foreach($permission as $perm)
					{
						echo '<div class="col-md-6">';
						if(isset($array2[$modvalue['id']]) && in_array($perm, $array2[$modvalue['id']]))
						{
							echo '<input id="'.$perm.'_'.$modvalue['id'].'" name="module['.$modvalue['id'].'][]" style="margin-right:5px" class="test'.$modvalue['id'].'" type="checkbox" value="'.$perm.'" checked="checked">';
						}
						else
						{
							echo '<input id="'.$perm.'_'.$modvalue['id'].'" name="module['.$modvalue['id'].'][]" style="margin-right:5px" class="test'.$modvalue['id'].'" type="checkbox" value="'.$perm.'">';
						}
						echo '<label for="'.$perm.'_'.$modvalue['id'].'">'.$perm.'</label>';
						echo '</div>';
					}
				echo '</td>';
			echo '</tr>';
		}
    }
	?>
    </table>

    <div class="form-group" style="margin-top:5px">
        <?= Html::submitButton(((count($module_groups) != 0) ? 'Update' : 'Assign'), ['class' => ((count($module_groups) != 0) ? 'btn btn-primary' : 'btn btn-success')]) ?>
    </div>

    <?php ActiveForm::end(); ?>

<script type="text/javascript">
$(function(){

<?php 
foreach($module as $modkey => $modvalue)
{
	?>
	//remove attribute href
	//$("#<?php echo 'selectall'.$modvalue['id'] ?>").removeAttr("href").css({"opacity" : "0.3", "cursor":"default"});
	
	$("input.<?php echo 'test'.$modvalue['id'] ?>").prop("readonly", true);
	
	//add and remove attribute when checkec or uncheck
	$('#<?php echo str_replace(' ', '_', $modvalue['name']).'_'.$modvalue['id'] ?>').change(function() {
        if ($(this).prop('checked')) {
			$("input.<?php echo 'test'.$modvalue['id'] ?>").prop("readonly", false);
			//add attrbute href
            $("#<?php echo 'selectall'.$modvalue['id'] ?>").attr('href', '#').css({"opacity" : "1"});
			
			//select all checkbox
			$("a#<?php echo 'selectall'.$modvalue['id'] ?>").click(function(){
				if($('.<?php echo 'test'.$modvalue['id'] ?>:checked').length > 0){
					$('.<?php echo 'test'.$modvalue['id'] ?>').prop('checked', false);
					$('a#<?php echo 'selectall'.$modvalue['id'] ?>').html('Select all');
				}else{
					$('.<?php echo 'test'.$modvalue['id'] ?>').prop('checked', true);
					$('a#<?php echo 'selectall'.$modvalue['id'] ?>').html('Unselect all');
				}
			});
			
			$(".<?php echo 'test'.$modvalue['id'] ?>").click(function(){
				if($(".<?php echo 'test'.$modvalue['id'] ?>").length == $(".<?php echo 'test'.$modvalue['id'] ?>:checked").length) {
					$('a#<?php echo 'selectall'.$modvalue['id'] ?>').html('Unselect All');
				} else {
					$('a#<?php echo 'selectall'.$modvalue['id'] ?>').html('Select all');
				}	
			});

        } else {
			$("input.<?php echo 'test'.$modvalue['id'] ?>").prop("readonly", true);
			//remove attribute href
            $("#<?php echo 'selectall'.$modvalue['id'] ?>").removeAttr("href").css({"opacity" : "0.3", "cursor":"default"});
			if($('.<?php echo 'test'.$modvalue['id'] ?>:checked').length > 0){
				$('.<?php echo 'test'.$modvalue['id'] ?>').prop('checked', false);
				$('a#<?php echo 'selectall'.$modvalue['id'] ?>').html('Select all');
			}
			$("#<?php echo 'selectall'.$modvalue['id'] ?>").unbind("click");
        }
    });
		
	<?php
}

?>
});
</script>

</div>
