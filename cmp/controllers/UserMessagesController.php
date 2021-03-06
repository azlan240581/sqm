<?php

namespace app\controllers;

use Yii;
use app\models\UserMessages;
use app\models\UserMessagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserMessagesController implements the CRUD actions for UserMessages model.
 */
class UserMessagesController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all UserMessages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserMessagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInbox()
    {
		//Bulk action
		if(strlen(Yii::$app->request->post('action')))
		{
			$bulk_action=Yii::$app->request->post('action');
			if($bulk_action == 'delete')
			{
				$selection=(array)Yii::$app->request->post('selection');//typecasting
				foreach($selection as $select)
				{
					$this->findModel($select)->delete();
				}
			}
		}
		
 		$_GET['UserMessagesSearch']['user_id'] = $_SESSION['user']['id'];
        $searchModel = new UserMessagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->sort->defaultOrder = ['priority' => SORT_DESC];

        return $this->render('inbox', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserMessages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionInboxDetail($id)
    {
		$model = UserMessages::find()->where(['id'=>$id,'user_id'=>$_SESSION['user']['id']])->one();
		
		if($model!=null)
		{
			$modelSave = UserMessages::findOne($id);
			$modelSave->mark_as_read = 1;
			$modelSave->save();
		}
		else
        return $this->redirect(['inbox']);

		
        return $this->render('inbox-detail', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new UserMessages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserMessages();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserMessages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserMessages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionInboxDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['inbox']);
    }

    /**
     * Finds the UserMessages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserMessages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserMessages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
