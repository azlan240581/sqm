<?php

namespace app\controllers;

use Yii;
use app\models\LogUsers;
use app\models\LogUsersSearch;
use app\models\LogUsersSearchByEmployer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogUsersController implements the CRUD actions for LogUsers model.
 */
class LogUsersController extends Controller
{
	public function init()
	{
		$this->defaultAction = Yii::$app->AccessRule->get_default_action_by_controller($this->id);
	}
	
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new LogUsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
	public function actionExportExcel()
	{		
		$error = '';
		$datacolumns = array();
		require_once(Yii::getAlias("@vendor/PHPExcel/Classes/PHPExcel.php"));
		$objPHPExcel = new \PHPExcel();

		$modelLogUsers = new LogUsers();
		$user='';
		$remarks='';
		$createdatrange='';
		
		if(count($_REQUEST)!=0)
		{
			$user = $_REQUEST['user'];
			$remarks = $_REQUEST['remarks'];
			$createdatrange = $_REQUEST['createdatrange'];
		}
		
		$data = $modelLogUsers->getLogUsers($user,$remarks,$createdatrange);
		
		$datacolumns[]['name'] = 'name';
		$datacolumns[]['name'] = 'remarks';
		$datacolumns[]['name'] = 'createdby';
		$datacolumns[]['name'] = 'createdat';
				
		$columnexcel = array('A','B','C','D');
		$newcolumn = array();
		
		$objPHPExcel->getProperties()->setCreator("Forefront")
						 ->setLastModifiedBy("Forefront")
						 ->setTitle("Office 2007 XLSX Test Document")
						 ->setSubject("Office 2007 XLSX Test Document")
						 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
						 ->setKeywords("office 2007 openxml php")
						 ->setCategory("Export File");

		//set column name (first row)
		$i = 0;
		foreach($columnexcel as $value)
		{
			$objPHPExcel->getActiveSheet()->setCellValue($value.'1', str_replace('_',' ',ucwords($datacolumns[$i]['name'])));
			$newcolumn[] = $value;
			$i++;
		}
		
		if($data)
		{
			foreach($data as $key => $value)
			{
				$data[$key]['createdby'] = YII::$app->AccessMod->getUsername($value['createdby']);
				$data[$key]['createdat'] = date("M d, Y H:i:s A", strtotime($value['createdat']));
			}
			
			$k = 0;
			foreach($data as $value)
			{
				foreach($datacolumns as $columns)
				{
					$datausers[$k][$columns['name']] = $value[$columns['name']];	
				}
				$k++;	
			}
		
			$i = 2;
			foreach($datausers as $user)
			{
				$k = 0;
				foreach($newcolumn as $new)
				{
					$objPHPExcel->getActiveSheet()->setCellValue($new.$i, $user[$datacolumns[$k]['name']]);
					$k++;
				}
				$i++;
			}
		}
		
		foreach($newcolumn as $col)
		{
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('Users');
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="Log-users-'.date('YmdHis').'.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
							
		return $this->redirect('index');
	}
	
    protected function findModel($id)
    {
        if (($model = LogUsers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
