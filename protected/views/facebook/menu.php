<?php if (Yii::app()->params["fb"]): ?>
	<a href="<?php echo $logoutUrl; ?>">
	  <img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif">
	</a>
<?php else: ?>
	<div id="fb_login">
	  <fb:login-button></fb:login-button>
	</div>
<?php endif ?>