<!doctype html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<title><?= $this->pageTitle ?></title>

	<?php $bp = Yii::app()->request->baseUrl; // cache basepath ?>

    <? Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <? Yii::app()->clientScript->registerScriptFile('js/shared.js'); ?>
	<link rel="stylesheet" type="text/css" href="<?= $bp ?>/css/layout.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?= $bp ?>/css/theme.css" media="screen" />

	<? $this->renderPartial('//facebook/init');  // facebook init scripts ?>
</head>
<body>
<div id="container">
	<div id="header">
        <h1><a href="<?= $this->createUrl('site/index')?>"><span style="color:#000">File</span>Storage</a></h1>
		<div id="nav">
			<ul class="clearfix">
				<? if (!Yii::app()->user->isGuest) { ?>
					<li class="clearfix"><?= CHtml::link('Home', array('/site/index')) ?></li>
					<li class="clearfix"><?= CHtml::link('My Files', array('/folder/')) ?></li>
					<li class="clearfix"><?= CHtml::link('Public Files', array('/folder/public')) ?></li>
					<li class="clearfix"><?= CHtml::link('My Profile', array('user/view','id'=>Yii::app()->user->id)) ?></li>
					<li class="clearfix"><?= CHtml::link('Todo List', array('site/page', 'view'=>'todo')) ?></li>
					<li class="clearfix"><?= CHtml::link('About', array('site/page', 'view'=>'about')) ?></li>
					<li class="clearfix last"><?= CHtml::link('Logout ('.Yii::app()->user->name.')', array('/site/logout')) ?></li>
				<? } else { ?>
					<li class="clearfix"><?= CHtml::link('Login', array('/site/login'.Yii::app()->user->id)) ?></li>
					<li class="clearfix"><?= CHtml::link('Register', array('/user/create')) ?></li>
                    <li class="clearfix"><?= CHtml::link('Public Files', array('/folder/public')) ?></li>
					<li class="clearfix"><?= CHtml::link('Todo List', array('site/page', 'view'=>'todo')) ?></li>
					<li class="clearfix last"><?= CHtml::link('About', array('site/page', 'view'=>'about')) ?></li>
				<? } ?>
				<? $this->renderPartial('//facebook/menu'); // facebook login/logout buttons ?>
			</ul>
		</div> <!-- nav -->
	</div> <!-- header -->

	<?php echo $content; ?>

	<div id="footer">
        &copy; <?= date('Y')?> Jesper Kjeldgaard
        <span style="color:#999;float:right;">Yii v.<?= Yii::getVersion() ?></span>
	</div><!-- footer -->

</div><!-- container -->
</body>
</html>
