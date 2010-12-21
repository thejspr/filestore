<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link REL="SHORTCUT ICON" HREF="images/favicon.ico">
	<title><?= $this->pageTitle ?></title>

    <? 
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->getClientScript()->registerCoreScript('yii');
        Yii::app()->clientScript->registerScriptFile('js/jquery.hint.js');
        Yii::app()->clientScript->registerScriptFile('js/jquery.cookie.js');
        Yii::app()->clientScript->registerScriptFile('js/modernizr-1.6.min.js');
        Yii::app()->clientScript->registerScriptFile('js/shared.js'); 
    ?>
    
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
    <?
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    $mobile = preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));
    if($mobile)
    { ?>
        <link rel="stylesheet" type="text/css" href="css/mobile.css" media="screen" />
    <? } else { ?>
        <link rel="stylesheet" type="text/css" href="css/theme.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/log.css" media="screen" />
    <? } ?>
	
</head>
<body>
<? $this->renderPartial('//facebook/init');  // facebook init scripts ?>
<div id="container">
	<div id="header">
        <div id="search">
            <a id="toggle_theme" href="javascript:toggleTheme()">Change Theme</a>
            <? $search_title = "Search";
                $search_title .= Yii::app()->user->isGuest ? " public" : "";
                $search_title .= " files"; ?>
            <input type="input" id="search-field" onkeypress="return runScript(event)" 
            title="<?= $search_title ?>" placeholder="<?= $search_title ?>" />
            <a href="javascript:search()">
                <img src="images/icons/magnifier.png" id="search-image" alt="Search" />
            </a>
        </div>
        <h1 class="title"><a href="<?= $this->createUrl('site/index')?>"><span id="logo-first" style="color:#000">File</span>Storage</a></h1>
        <div id="nav">
			<ul class="clearfix">
				<? if (!Yii::app()->user->isGuest) { ?>
					<li class="clearfix"><?= CHtml::link('My Files', array('/folder/')) ?></li>
					<li class="clearfix"><?= CHtml::link('Public Files', array('/folder/public')) ?></li>
					<li class="clearfix"><?= CHtml::link('My Profile', array('user/view','id'=>Yii::app()->user->id)) ?></li>
					<!--<li class="clearfix"><?= CHtml::link('Todo List', array('site/page', 'view'=>'todo')) ?></li>-->
					<li class="clearfix last"><?= CHtml::link('Logout ('.Yii::app()->user->name.')', array('/site/logout')) ?></li>
				<? } else { ?>
					<li class="clearfix"><?= CHtml::link('Login', array('/site/login'.Yii::app()->user->id)) ?></li>
					<li class="clearfix"><?= CHtml::link('Register', array('/user/create')) ?></li>
                    <li class="clearfix last"><?= CHtml::link('Public Files', array('/folder/public')) ?></li>
					<!--<li class="clearfix"><?= CHtml::link('Todo List', array('site/page', 'view'=>'todo')) ?></li>-->
				<? } ?>
			</ul>
		</div> <!-- nav -->
	</div> <!-- header -->
	<? if(!Yii::app()->user->isGuest && !$mobile) { ?>
	<div id="log-container">
        <? $this->renderPartial('//site/log') ?>
    </div>
    <? } ?>
	<?php echo $content; ?>

	<div id="footer">
        <span style="color:#999;font-size:85%;">
        <?= CHtml::link('About', array('site/page', 'view'=>'about')) ?>
        &copy; <?= date('Y')?> Jesper Kjeldgaard
        <span style="float:right;">Powered by Yii <?= Yii::getVersion() ?></span>
        </span>
	</div><!-- footer -->

</div><!-- container -->
</body>
</html>
