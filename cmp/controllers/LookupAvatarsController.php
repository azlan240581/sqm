<?php

namespace app\controllers;

use Yii;
use app\models\LookupAvatars;
use app\models\LookupAvatarsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * LookupAvatarController implements the CRUD actions for LookupAvatar model.
 */
class LookupAvatarsController extends Controller
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
        $searchModel = new LookupAvatarsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new LookupAvatars();
		$model->scenario = 'create';
		
        if (count($_POST)!=0)
		{
			/***** lookup_avatar create process ******/
			$model->load(Yii::$app->request->post());

			//get the instance of uploaded file
			$imageName = $model->name;
			$model->file = UploadedFile::getInstance($model,'file');
			$model->file->saveAs('contents/avatar/'.$imageName.'.'.$model->file->extension);
			
			//save path to db column
			$model->image = '/contents/avatar/'.$imageName.'.'.$model->file->extension;

			$model->save();
					
			if(count($model->errors)==0)
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->render('create', [
			'model' => $model,
		]);

    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (count($_POST)!=0) 
		{
			/***** lookup_avatar update process ******/
			$model->load(Yii::$app->request->post());

			$image = '';
			if($_FILES['LookupAvatars']['error']['file']!=4)
			{
				//delete current image
				unlink('.'.$model->image);
				//get the instance of uploaded file
				$imageName = $model->name;
				$model->file = UploadedFile::getInstance($model,'file');
				$model->file->saveAs('contents/avatar/'.$imageName.'.'.$model->file->extension);
				//save path to db column
				$image = '/contents/avatar/'.$imageName.'.'.$model->file->extension;
			}
			
			//save path to db column
			if(strlen($image))
			$model->image = '/contents/avatar/'.$imageName.'.'.$model->file->extension;

			$model->save();				
			
			if(count($model->errors)==0)
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->render('update', [
			'model' => $model,
		]);
    }

    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
		$model = $this->findModel($id);
		
		$model->deleted = 1;

		$model->save();				

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = LookupAvatars::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
