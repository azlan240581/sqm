<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$this->beginPage();

?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?php echo $_SESSION['settings']['SITE_NAME'] ?> | <?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?php echo $_SESSION['settings']['SITE_LOGO_ICON'] ?>">
    <?php $this->head() ?>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" integrity="sha256-xNjb53/rY+WmG+4L6tTl9m6PpqknWZvRt0rO1SRnJzw=" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.18.2/ol.css">
    <link rel="stylesheet" href="/cmp/contents/css/jquery.orgchart.css">
    <link rel="stylesheet" href="/cmp/contents/css/style.orgchart.css">
    <style type="text/css">
      html,body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
      }

      .demo-container {
        position: relative;
        display: inline-block;
        top: 10px;
        left: 10px;
        height: calc(100% - 24px);
        width: calc(100% - 24px);
        border: 2px dashed #eee;
        border-radius: 5px;
        overflow: auto;
        text-align: center;
      }

      .orgchart {
        background: #FEFAFA; 
      }

      .orgchart>.spinner {
        color: rgba(255, 255, 0, 0.75);
      }

      .orgchart .node .title {
        background-color: #fff;
        color: #000; 
      }

      .orgchart .node .content {
        border-color: transparent;
        border-top-color: #333;
      }

      .orgchart .node>.spinner {
        color: rgba(184, 0, 54, 0.75);
      }

      .orgchart .node:hover {
        background-color: rgba(255, 255, 0, 0.6);
      }

      .orgchart .node.focused {
        background-color: rgba(255, 255, 0, 0.6);
      }

      .orgchart .node .edge {
        color: rgba(0, 0, 0, 0.6);
      }

      .orgchart .edge:hover {
        color: #000;
      }

      .orgchart tr.lines td.leftLine,
      .orgchart tr.lines td.topLine,
      .orgchart tr.lines td.rightLine {
        border-color: black;
        border-radius: 0px;
      }

      .orgchart tr.lines .downLine {
        background-color: black;
      }

      .orgchart .second-menu-icon {
        transition: opacity .5s;
        opacity: 0;
        right: -5px;
        top: -5px;
        z-index: 2;
        color: rgba(184, 0, 100, 0.8);
        font-size: 18px;
        position: absolute;
      }

      .orgchart .second-menu-icon:hover {
        color: #b80064;
      }

      .orgchart .node:hover .second-menu-icon {
        opacity: 1;
      }

      .orgchart .node .second-menu {
        display: none;
        position: absolute;
        top: 0;
        right: -70px;
        border-radius: 35px;
        box-shadow: 0 0 4px 1px #999;
        background-color: #fff;
        z-index: 1;
      }

      .orgchart .node .second-menu .avatar {
        width: 60px;
        height: 60px;
        border-radius: 30px;
        float: left;
        margin: 5px;
      }

      .orgchart~.mask .spinner {
        color: rgba(255, 255, 0, 0.75);
      }

      #color-coded .orgchart {
        background: transparent;
      }
      .orgchart .director-level .title {
        background-color: #006699;
      }
      .orgchart .manager-level .title {
        background-color: #009933;
      }
      .orgchart .agent-level .title {
        background-color: #996633;
      }
      .orgchart .member-level .title {
        background-color: #cc0066;
      }
    </style>




</head>

<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>

<div class="wrapper">
    
    <header class="main-header">
        <!-- Logo -->
        <?= Html::a('<span class="logo-mini"><img src="'.$_SESSION['settings']['SITE_LOGO_SMALL'].'" width="90%" style="margin:2px 0;"></span><span class="logo-lg"><img src="'.$_SESSION['settings']['SITE_LOGO_MEDIUM'].'" width="90%" style="margin:2px 0; max-height:50px;"></span>', ['/dashboard'], ['class'=>'logo']) ?>
        <!-- Header Navbar: style can be found in header.less -->
        
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        	
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">


					<?php
                    $totalMessage = 0;
					if(($userNewMessages = Yii::$app->AccessMod->getUserNewMessage($_SESSION['user']['id'])))
					$totalMessage = count($userNewMessages);
                    if($totalMessage==0)
                    $summary = 'Sorry! You have no new message.';
                    else
                    $summary = 'You have '.$totalMessage.' new message'.($totalMessage==1?'':'s').'!';
                    ?>
                    <li class="dropdown notifications-menu">
                      <a href="#" class="dropdown-toggle notification" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-bell <?php echo $totalMessage!=0?'bell-shake':'' ?>"></i>
                        <?php
						if($userNewMessages[0]['priority']==3)
						$color = '#F30';
						elseif($userNewMessages[0]['priority']==2)
						$color = '#F60';
						else
						$color = '#399';
						?>
                        <audio id="myAudio"><source src="/cmp/contents/audio/sound01.wav" type="audio/wav">Your browser does not support the audio element.</audio>
						<script>
                        var x = document.getElementById("myAudio"); 
                        <?php echo $totalMessage!=0?'x.play()':''; ?>
                      </script>
                        <span class="label label-warning" style="margin-top:2px; margin-right:-2px; background-color:<?php echo $color ?> !important;"><?php echo $totalMessage ?></span>
                      </a>
                      <ul class="dropdown-menu">
                        <li class="header"><?php echo $summary ?></li>
                        <li>
                            <ul class="menu">
                            	<?php
								if($totalMessage!=0)
								{
									foreach($userNewMessages as $newMessage)
									{
										if($newMessage['priority']==3)
										{
											$priority = 'Important! ';
											$color = '#F30';
										}
										elseif($newMessage['priority']==2)
										{
											$priority = 'Need your attention! ';
											$color = '#F60';
										}
										else
										{
											$priority = 'Priority Low! ';
											$color = '#399';
										}
										$message = $newMessage['subject'];
								?>
                                <li title="<?php echo $priority.$message ?>"><a href="/user-messages/inbox-detail?id=<?php echo $newMessage['id'] ?>"><i class="fa fa-envelope" style="color:<?php echo $color ?>"></i> <?php echo $message ?></a></li>
                                <?php
									}
								}
								?>
                            </ul>
                        </li>
                        <li class="footer"><a href="/user-messages/inbox">View all</a></li>
                      </ul>
                    </li>


                
                
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle user" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i><span class="hidden-xs"><?= Yii::$app->user->identity->name ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
								<?php
								if(isset(Yii::$app->user->identity->avatar_id) && strlen(Yii::$app->user->identity->avatar_id))
								{
									$sql = "SELECT image FROM `lookup_avatars` where id=".Yii::$app->user->identity->avatar_id;
									$avatar = Yii::$app->db->createCommand($sql)->queryOne();
									echo Html::img($avatar['image']);
								}
								?>
                                <p>
                                    <?= Yii::$app->user->identity->name ?>
                                    <small>Member since <?= \Yii::$app->formatter->asDate(Yii::$app->user->identity->createdat) ?></small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <?= 
									Html::a('Profile', ['/users/profile/'], ['class' => 'btn btn-primary'])
									?>
                                </div>
                                <div class="pull-right">
                                    <?= 
									Html::a('Logout', ['/logout'], ['class' => 'btn btn-danger']);
									?>
                                </div>
                            </li>
                        </ul>
                    </li>
            	</ul>
            </div>
        </nav>
    </header>
      
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar" style="overflow: auto">
            <?php
			YII::$app->AccessMod->navigationSiteBar('', 0);
			?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?= $this->title ?>
          </h1>
          <ol class="breadcrumb">
            <li><?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?></li>
          </ol>
        </section>
    
        <!-- Main content -->
        <section class="content">
            <?= $content ?>
            <div style="clear:both;"><br /></div>
        </section>
    </div>
    
    <footer class="main-footer">
        <div class="container">
            <p class="pull-left">&copy; <?php echo str_replace('Administration','',$_SESSION['settings']['SITE_NAME']) ?> <?= date('Y') ?></p>
            <p class="pull-right"><?php // echo Yii::powered() ?>Powered by <a href="http://forefront.com.my">Forefront</a></p>
        </div>
    </footer>

</div>

<?php
if(isset($this->params['breadcrumbs']))
{
?>
<script>
$(document).ready(function(e) {
	<?php
	foreach($this->params['breadcrumbs'] as $breadcrumbs)
	{
		if(is_array($breadcrumbs))
		$breadcrumbs = strtolower(YII::$app->AccessMod->replaceString($breadcrumbs['label'],'_'));
		else
		$breadcrumbs = strtolower(YII::$app->AccessMod->replaceString($breadcrumbs,'_'));
	?>
	$('.<?= $breadcrumbs ?>').addClass("active");
	<?php
	}
	?>
});
</script>
<?php	
}
?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
