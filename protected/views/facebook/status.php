<?php if (Yii::app()->params["facebook"] == 1 && $me): ?>

	<h3><a href="#" class="str">Facebook connect status</a></h3>
	<pre><?php print_r($session); ?></pre>

	<h3>You</h3>
	<img src="https://graph.facebook.com/<?php echo $uid; ?>/picture">
	<?php echo $me['name']; ?>

	<h3>Your User Object</h3>
	<pre><?php print_r($me); ?></pre>
<?php endif ?>