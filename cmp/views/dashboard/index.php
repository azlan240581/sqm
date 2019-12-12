<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;

$this->title = 'Dashboard';

/*echo '<pre>';
//print_r(Yii::$app->AccessMod->getAgentProjectID($_SESSION['user']['id']));
//print_r(Yii::$app->CommissionMod->generateUserCommissionsByProspectBooking(2));
//print_r(Yii::$app->CommissionMod->errorMessage);
//print_r(Yii::$app->CommissionMod->errorMessage);
//print_r(Yii::$app->PointsMod->memberPointsActivities(18,'PROSPECT_SET_APPOINTMENT',7,array('action_name'=>'PROSPECT_HISTORY','prospect_id'=>1,'history_id'=>3)));
//print_r(Yii::$app->PointsMod->memberPointsActivities(18,'PROSPECT_VISIT_MARKETING_GALLERY',7,array('action_name'=>'PROSPECT_HISTORY','prospect_id'=>1,'history_id'=>4)));
echo '</pre>';
exit();*/

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/dashboard']];
?>
<div class="dashboard-index">
    <div class="body-content" style="overflow-x:hidden !important;">
        <div class="row" style="padding:20px 0; height:400px;">
            
            <div class="col-md-6" style="overflow:hidden !important;">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Associate Status</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <canvas id="pieChartAssociate" style="height:400px"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6" style="overflow:hidden !important;">
                <?php /*?>
				<div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Prospect Status</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <canvas id="pieChartProspect" style="height:400px"></canvas>
                    </div>
                </div>
				<?php */?>
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Prospect Status</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="barChartProspect" style="height:400px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>   
    </div>
</div>

<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script>
var pieChartAssociate = document.getElementById("pieChartAssociate").getContext('2d');
var myChartAssociate = new Chart(pieChartAssociate, {
    type: 'doughnut',
    data: {
        labels: [<?php foreach($totalMemberStatus as $key=>$value){ echo '"'.ucwords(str_replace('_',' ',$key)).'", '; } ?>],
        datasets: [{
            data: [<?php foreach($totalMemberStatus as $key=>$value){ echo $value.', '; } ?>],
            backgroundColor: [
				<?php foreach($totalMemberStatus as $key=>$value){ echo '"#"+((1<<24)*Math.random()|0).toString(16),'; } ?>
            ],
        }]
    },
    options: {
        cutoutPercentage: 0,
    }
});
<?php /*?>var pieChartProspect = document.getElementById("pieChartProspect").getContext('2d');
var myChartProspect = new Chart(pieChartProspect, {
    type: 'doughnut',
    data: {
        labels: [<?php foreach($totalProspectStatus as $key=>$value){ echo '"'.ucwords(str_replace('_',' ',$key)).'", '; } ?>],
        datasets: [{
            data: [<?php foreach($totalProspectStatus as $key=>$value){ echo $value.', '; } ?>],
            backgroundColor: [
				<?php foreach($totalProspectStatus as $key=>$value){ echo '"#"+((1<<24)*Math.random()|0).toString(16),'; } ?>
            ],
        }]
    },
    options: {
        cutoutPercentage: 0,
    }
});<?php */?>
var barChartProspect = document.getElementById("barChartProspect").getContext('2d');
var myChartProspect = new Chart(barChartProspect, {
    type: 'bar',
    data: {
        labels: [<?php foreach($totalProspectStatus as $key=>$value){ echo '"'.ucwords(str_replace('_',' ',$key)).'", '; } ?>],
        datasets: [{
			label: '# Prospect History Status',
            data: [<?php foreach($totalProspectStatus as $key=>$value){ echo $value.', '; } ?>],
            backgroundColor: [
				<?php foreach($totalProspectStatus as $key=>$value){ echo '"#"+((1<<24)*Math.random()|0).toString(16),'; } ?>
            ],
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

