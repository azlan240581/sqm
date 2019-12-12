<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\base\ErrorException;

class ErrorsController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

	public function init()
    {
        $this->layout = errorlayout;
    }
	
    public function errorIndex()
    {
		$exception = Yii::$app->errorHandler->exception;
        return $this->render('index',['exception' => $exception]);
    }
}
