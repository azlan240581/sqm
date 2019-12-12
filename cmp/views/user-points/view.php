<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserPoints */

$this->title = 'Associate Points : '.$model->associateName->name;
$this->params['breadcrumbs'][] = 'Points Management';
$this->params['breadcrumbs'][] = ['label' => 'Associate Points', 'url' => ['/user-points']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-points-view">
    <p>
        <?php
		if($_SESSION['user']['id']==1 or ($_SESSION['user']['groups']!=NULL and array_intersect(array(1,2),$_SESSION['user']['groups'])))
        echo Html::a('<span class="glyphicon glyphicon-ruble"></span> Toggle Points', ['toggle-points', 'id' => $model->id], ['class' => 'btn btn-primary'])
		?>
    </p>


    <div class="row bg-dark-grey">
        <div class="col-xs-12"><h4>Points Details</h4></div>
    </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		
			[
				'label'=>'Agent Name',
				'value'=>$model->agentName->name,
			],
			[
				'label'=>'Associate Name',
				'value'=>$model->associateName->name,
			],
			[
				'label'=>'Associate Email',
				'value'=>$model->associateEmail->email,
			],
			[
				'label'=>'Associate Contact Number',
				'value'=>$model->associateContactNo->country_code.$model->associateContactNo->contact_number,
			],
			[
				'label'=>$model->getAttributeLabel('total_points_value'),
				'value'=>Yii::$app->AccessMod->getPointsFormat($model->total_points_value),
			],
			[
				'label'=>$model->getAttributeLabel('createdby'),
				'value'=>Yii::$app->AccessMod->getName($model->createdby),
			],
            'createdat:datetime',
			[
				'label'=>$model->getAttributeLabel('updatedby'),
				'value'=>Yii::$app->AccessMod->getName($model->updatedby),
			],
            'updatedat:datetime',
			
        ],
    ]) ?>

    <div class="row bg-dark-grey">
        <div class="col-xs-12"><h4>5 Latest Member Activities</h4></div>
    </div>
    <table id="w1" class="table table-striped table-bordered detail-view">
    <?php
    if(count($logAssociateActivities)==0)
    echo '<tbody><tr><td>No results found.</td></tr></tbody>';
    else
    {
    ?>
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Activity Name</th>
        <th scope="col">Activity Points</th>
        <th scope="col">Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        foreach($logAssociateActivities as $logActivity)
        {
        ?>
        <tr>
            <th scope="row"><?php echo $i ?>.</th>
            <td>
				<?php 
				$acitivity = Yii::$app->PointsMod->getActivity($logActivity['activity_id']);
				echo $acitivity['activity_name']; 
				?>
            </td>
            <td>
				<?php 
				echo Yii::$app->AccessMod->getPointsFormat($logActivity['points_value']) 
				?>
            </td>
            <td><?php echo Yii::$app->formatter->asDatetime($logActivity['createdat'], 'long') ?></td>
            <td></td>
        </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
    <?php
    }
    ?>
    </table>

    <div class="row bg-dark-grey">
        <div class="col-xs-12"><h4>5 Latest Points Transactions</h4></div>
    </div>
    <table id="w1" class="table table-striped table-bordered detail-view">
    <?php
    if(count($logUserPoints)==0)
    echo '<tbody><tr><td>No results found.</td></tr></tbody>';
    else
    {
    ?>
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Actions</th>
        <th scope="col">Points Value</th>
        <th scope="col">Remarks</th>
        <th scope="col">Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        foreach($logUserPoints as $logPoints)
        {
        ?>
        <tr>
            <th scope="row"><?php echo $i ?>.</th>
            <td><?php echo $logPoints['status'] ?></td>
            <td><?php echo Yii::$app->AccessMod->getPointsFormat($logPoints['points_value']) ?></td>
            <td><?php echo $logPoints['remarks'] ?></td>
            <td><?php echo Yii::$app->formatter->asDatetime($logPoints['createdat'], 'long') ?></td>
            <td></td>
        </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
    <?php
    }
    ?>
    </table>


</div>
