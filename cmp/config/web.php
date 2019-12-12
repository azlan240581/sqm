<?php
$params = require(__DIR__ . '/params.php');
$allowedActions = array('login','logout','error','api','backoffice','profile','inbox','inbox-detail','inbox-delete');
$defaultRoute = '/dashboard/';

$config = array(
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
	//'defaultRoute' => $defaultRoute.'index',
	'defaultRoute' => $defaultRoute,
    'bootstrap' => array('log','AccessRule'),
	'modules' => array(),
    'components' => array(
		'formatter' => [
			'class' => 'yii\i18n\Formatter',
			'defaultTimeZone' => 'UTC',
			'timeZone' => 'Etc/Greenwich',
		],
        'request' => array(
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'FFSYiiApp',
        ),
        'cache' => array(
            'class' => 'yii\caching\FileCache',
        ),
        'user' => array(
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => true,
        ),
        'errorHandler' => array(
            'errorAction' => 'errors/error',
        ),
        'mailer' => array(
            'class' => 'yii\swiftmailer\Mailer',
			'viewPath' => '@app/mail',
            'enableSwiftMailerLogging' =>true,
			'CustomMailerConfig' => true,
			'useFileTransport' => false,
        ),
        'log' => array(
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => array(
                array(
                    'class' => 'yii\log\FileTarget',
                    'levels' => array('error', 'warning'),
                ),
            ),
        ),
        'db' => require(__DIR__ . '/db.php'),
        
        'urlManager' => array(
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => array(
				'<controller:[\w-]+>/update/<id:\d+>' => '<controller>/update',
				'<controller:[\w-]+>/view/<id:\d+>' => '<controller>/view',
				'<controller:[\w-]+>/delete/<id:\d+>' => '<controller>/delete',
				'<controller:\w+>/<action:\w+>/<request:[\w\W]+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
        ),
		'AccessRule'=>array(
			'class'=>'app\components\AccessRule'
		 ),
		'AccessMod'=>array(
			'class'=>'app\components\AccessMod'
		 ),
		'GeneralMod'=>array(
			'class'=>'app\components\GeneralMod'
		 ),
		'CatalogMod'=>array(
			'class'=>'app\components\CatalogMod'
		 ),
		'MemberMod'=>array(
			'class'=>'app\components\MemberMod'
		 ),
		'PointsMod'=>array(
			'class'=>'app\components\PointsMod'
		 ),
		'CommissionMod'=>array(
			'class'=>'app\components\CommissionMod'
		 ),
		'ProspectMod'=>array(
			'class'=>'app\components\ProspectMod'
		 ),
		'NewsFeedMod'=>array(
			'class'=>'app\components\NewsFeedMod'
		 ),
		'AgentMod'=>array(
			'class'=>'app\components\AgentMod'
		 ),
    ),
    'params' => $params,
	
	/* start: before any request, force login */
	'as beforeRequest' => array(
		'class' => 'yii\filters\AccessControl',
		'rules' => array(
			array(
				'actions' => $allowedActions,
				'allow' => true,
			),
			array(
				//'actions' => array('index','logout'),
				'allow' => true,
				'roles' => array('@'),
			),
		),
		'denyCallback' => function () {
			$browse_history = $_SERVER['REQUEST_URI'];
			$session = Yii::$app->session;
			$session->set('browse_history', $browse_history);			
			return Yii::$app->response->redirect(array('/login'));
		},
	),
	
	'on beforeAction' => function () {
		global $allowedActions;
		global $defaultRoute;

        if(Yii::$app->controller->id!='default' and !Yii::$app->user->isGuest and !in_array(Yii::$app->controller->action->id,$allowedActions))
		{
			$permission = Yii::$app->AccessRule->get_permission();
						
			if(Yii::$app->controller->id=='errors')
			{
				
			}
			elseif(!$permission)
			{
				throw new \yii\web\HttpException(401, 'Unauthorized: Access is denied due to invalid credentials.');
			}
			else
			{
				/*if((Yii::$app->controller->id=='dashboard' and Yii::$app->controller->action->id=='index') and $_SESSION['user']['id']!=1)
				{
					header('Location:'.$defaultRoute.$permission[0]);
					exit();
				}*/
				
				if(!in_array(Yii::$app->controller->action->id,$permission))
				throw new \yii\web\HttpException(401, 'Unauthorized: Access is denied due to invalid credentials.');
				
				$_SESSION['user']['permission'] = $permission;
				$_SESSION['user']['controller'] = Yii::$app->controller->id;
				$_SESSION['user']['action'] = Yii::$app->controller->action->id;
				$session = Yii::$app->session;
				$session->set('user', $_SESSION['user']);
			}
		}
    },
	/* end: before any request, force login */

);

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = array(
        'class' => 'yii\debug\Module',
    );

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = array(
        'class' => 'yii\gii\Module',
		'allowedIPs' => array('*'),
    );
}

return $config;
