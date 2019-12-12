<?php

namespace app\controllers;

use Yii;
use app\models\LogApi;
use app\models\LogApiSearch;
use app\models\LogApiSearchByEmployer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogApiController implements the CRUD actions for LogApi model.
 */
class LogApiController extends Controller
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
        $searchModel = new LogApiSearch();
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

		$modelLogApi = new LogApi();
		$user='';
		$api_actions='';
		$createdatrange='';
		
		if(count($_REQUEST)!=0)
		{
			$user = $_REQUEST['user'];
			$api_actions = $_REQUEST['api_actions'];
			$createdatrange = $_REQUEST['createdatrange'];
		}
		
		$data = $modelLogApi->getLogApis($user,$api_actions,$createdatrange);
				
		foreach($data as $key => $value)
		{
			$data[$key]['createdat'] = date("M d, Y H:i:s A", strtotime($value['createdat']));
		}
		
		$datacolumns[]['name'] = 'api_actions';
		$datacolumns[]['name'] = 'request';
		$datacolumns[]['name'] = 'response';
		$datacolumns[]['name'] = 'staff_name';
		$datacolumns[]['name'] = 'createdat';
		
		$k = 0;
		foreach($data as $value)
		{
			foreach($datacolumns as $columns)
			{
				$datausers[$k][$columns['name']] = $value[$columns['name']];	
			}
			$k++;	
		}
		
		$columnexcel = array('A','B','C','D','E');
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

		foreach($newcolumn as $col)
		{
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('Api Request');
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="Log-api-'.date('YmdHis').'.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
							
		return $this->redirect('index');
	}
	
    protected function findModel($id)
    {
        if (($model = LogApi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
