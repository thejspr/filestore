<!doctype html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<title><?= $this->pageTitle ?></title>

    <? Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <? Yii::app()->clientScript->registerScriptFile('js/shared.js'); ?>
    <script>
        function runScript(e) {
            if (e.keyCode == 13) {
                search();
                return false;
            }
        }

        function search() {
            var query = $('#search-field').val();
            if (query != "")
                window.location = "<?= $this->createUrl('site/search') ?>&query=" + query
        }
    </script>
    <link rel="stylesheet" type="text/css" href="css/layout.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/theme.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/mobile.css" media="handheld" />

	<? $this->renderPartial('//facebook/init');  // facebook init scripts ?>
</head>
<body>
<div id="container">
	<div id="header">
        <div id="search">
            <input type="input" id="search-field" onkeypress="return runScript(event)"
                   placeholder="Search<?= Yii::app()->user->isGuest ? " public" : "" ?> files" />
            <a href="javascript:search()">
                <img src="images/icons/magnifier.png" id="search-image" alt="Search" />
            </a>
        </div>
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
