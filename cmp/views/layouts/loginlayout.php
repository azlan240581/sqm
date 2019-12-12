<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\LoginAsset;

LoginAsset::register($this);

?>
<?php 
$this->beginPage();
?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo $_SESSION['settings']['SITE_LOGO_ICON'] ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= $_SESSION['settings']['SITE_NAME'] ?> | <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="/cmp/contents/css/site.css" rel="stylesheet">
    <script src="/cmp/contents/js/main.js"></script>
</head>

<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    /*NavBar::begin([
        'brandLabel' => $_SESSION['settings']['SITE_NAME'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
	
	echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();*/
    ?>    
    <div class="container">
        <div class="site-login-wrapper">
            <h1><a href="/" title="Rex Ventura" tabindex="-1">
            Rex Ventura
            <img src="<?php echo $_SESSION['settings']['SITE_LOGO_MEDIUM'] ?>" alt="Rex Ventura">
            </a></h1>
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="main-footer">
    <div class="container">
        <p class="text-center"><?php // echo Yii::powered() ?>Powered by &copy; <a href="http://forefront.com.my">Forefront</a> <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
